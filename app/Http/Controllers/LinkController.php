<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Admin\Link as LinkResource;

class LinkController extends Controller
{
    protected static $chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = 0;

        $validatedData = $request->validate([
            'url' => 'required|url|max:255',
        ]);

        if (!$validatedData) {
            return $status;
        } else {
            $exists = Link::where('url', $request->url)->exists();

            if (!$exists) {
                $link = new Link;
                $link->url = $request->input('url');

                if ($link->save()) {
                    $link->code = $this->getShortCode($link->id);
                    if ($link->save()) {
                        $status = 1;
                    }
                }
            } else {
                return response()->json([
                    'data' => [
                        'status' => $status
                    ]
                ]);
            }
        }

        return new LinkResource($link);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function getShortCode($id) {

        $length = strlen(self::$chars);

        $code = "";
        while ($id > $length - 1) {

            $code = self::$chars[fmod($id, $length)] .
                $code;

            // reset $id to remaining value to be converted
            $id = floor($id / $length);
        }

        $code = self::$chars[$id] . $code;

        return $code;
    }
}
