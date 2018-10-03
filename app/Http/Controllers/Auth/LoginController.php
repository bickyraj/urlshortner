<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use DB;
use App\Quotation;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
    {
        if (Auth::user()->isAdmin()) {
            return '/admin';
        }
        
        return '/login';
    }

    public function login()
    {
        $email = request('email');
        $password = request('password');

        // Check if a user with the specified email exists
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // Send an internal API request to get an access token
            $client = DB::table('oauth_clients')->where('id', 2)->first();
            $data = [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => $client->secret,
                'username' => $email,
                'password' => $password,
            ];

            $request = Request::create('/oauth/token', 'POST', $data);
            $response = app()->handle($request);

            // Check if the request was successful
            if ($response->getStatusCode() != 200) {
                return response()->json([
                    'message' => 'Wrong email or password',
                    'status' => 422
                ], 422);
            } else {

                // Get the data from the response
                $data = json_decode($response->getContent());

                // Format the final response in a desirable format
                return response()->json([
                    'token' => $data->access_token,
                    'user' => Auth::user(),
                    'status' => 200
                ]);
            }


        } else {

            return response()->json([
                'message' => 'Wrong email or password',
                'status' => 422
            ], 422);
        }
    }

    public function logout()
    {
        $accessToken = auth()->user()->token();

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        return response()->json(['status' => 200]);
    }
}
