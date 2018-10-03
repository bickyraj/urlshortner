<?php

namespace App\Http\Controllers\Admin;

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
        $link = Link::paginate(100);

        // return collection of link as a resource.
        return LinkResource::collection($link);
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
        // Log::info($request->all());
        // die();
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
                $link->expiration_time = $request->input('expiration_time');

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
        $link = Link::findOrFail($id);

        // return single link as resource.
        return new LinkResource($link);
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
        // get link.
        $link = Link::findOrFail($id);
        $status = 0;
        if ($link->delete()) {
            $status = 1;
        }
        return response($status, 410);
    }

    public function getActualUrl($code)
    {
        $url = Link::where('code', $code)->first();

        if (isset($url) && !empty($url)) {
            $url->increment('counter');
            return redirect($url->url);
        }

        return back();
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

    // search function for url.
    // params keyword.
    public function searchUrl(Request $request)
    {
        $keyword = $request->keyword;
        $links = Link::where('url', 'LIKE', '%' . $keyword . '%')->get();

        return LinkResource::collection($links);
    }

    // lookup function for short url.
    // params shortUrl.
    public function lookupShortUrl(Request $request)
    {
        $baseUrl = url('/shortUrl');
        $status = 0;
        $shortUrl = $request->shortUrl;
        $link = [];

        if (strpos($shortUrl, $baseUrl) !== false) {
            $urlArr = explode($baseUrl, $shortUrl);
            if ($urlArr[0] == '') {
                $code = substr($urlArr[1], strpos($urlArr[1], "/") + 1);

                if (!empty($code)) {
                    $link = Link::where('code', $code)->first();
                }

                if (isset($link) && !empty($link)) {
                    $status = 1;
                }
            }
        }

        return response()->json([
            'status' => $status,
            'data' => $link
        ]);
    }

    public function getShortUrlList()
    {
        $codes = Link::pluck('code');
        $links = [];
        foreach ($codes as $code) {
            $links[] = url('/') . '/shortUrl/' . $code;
        }

        return response()->json([
            'data' => $links
        ]);
    }
}
