<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function getConnections(Request $request)
    {
        // client_id, connection_id, device_id, lat, long
        // post the request data to relative table.
        $data = [
            [
                "connectionId" => "1",
                "clientId" => "1",
                "connectionSsid" => "innology",
                "connectionPassword" => "innology@solution123",
                "connectionEncryptionType" => "tkip",
                "connectionSecurityType" => "wpa-psk"
            ],
            [
                "connectionId" => "2",
                "clientId" => "2",
                "connectionSsid" => "test",
                "connectionPassword" => "test",
                "connectionEncryptionType" => "tkip",
                "connectionSecurityType" => "wpa-psk"
            ]
        ];

        $meta = [
            "current_page" =>  1,
            "from" =>  1,
            "last_page" =>  1,
            "path" =>  "http://example.com/pagination",
            "per_page" =>  15,
            "to" =>  10,
            "total" =>  10
        ];

        $links = [
                "first" => "http://example.com/pagination?page=1",
                "last" => "http://example.com/pagination?page=1",
                "prev" => null,
                "next" => null
            ];

        return response()->json([
            'data' => $data,
            'meta' => $meta,
            'links' => $links,
            "action" => "ConnectionList",
            "status" => 1,
            "message" => "",
            "validation" => [],
        ]);
    }

    public function getClientDetail(Request $request)
    {
        // client_id, connection_id, device_id, lat, long
        // post the request data to relative table.
        $data = [
            [
                "clientName" => "Labim",
                "clientId" => "1",
                "clientLogo" => "http://labim.com.np/img/logo.png",
                "clientState" => "State3",
                "clientMunicipality" => "Lalitpur",
                "clientWada" => "2",
                "clientLat" => "12.12",
                "clientLong" => "122.12",
                "clientBanner" => [
                    "bannerTitle" => "Labmin",
                    "bannerImages" => [
                        [
                           "imagePath" => "http://living.com.np/upload/feature/gallery/1weIvwVk_1479461551.jpg"
                        ],
                        [
                           "imagePath" => "http://wowmagnepal.com/wp-content/uploads/2016/10/level-3.jpg"
                        ],
                        [
                            "imagePath" => "http://www.trbimg.com/img-58a3816d/turbine/ct-wonton-dumplings-2-jpg-20170214/750/750x422"
                        ],
                        [
                            "imagePath" => "http://living.com.np/upload/feature/gallery/vNPv4QVm_1479461450.jpg"
                        ]
                    ],
                    "bannerTexts" => [
                        [
                           "title" => "Welcome To Labim Mall."
                        ],
                        [
                           "title" => "50 Shops."
                        ],
                        [
                            "title" => "Parking Facilities."
                        ]
                    ]
                ],
                "products" => [
                    [
                        "clientId" => "2",
                        "clientName" => "Dream House Cafe",
                        "clientLogo" => "https://scontent.fktm3-1.fna.fbcdn.net/v/t1.0-9/30515768_934625693377848_7720667433589014528_n.jpg?_nc_cat=0&_nc_eui2=AeGy_Uf9-skiIYKMK1a4et-tfT7x-oeDYmxInPPQU6_U9fvO3LQjOUpRMKjh6-fh0lmnN0aZV7XUEbfSOGg8V8qc1A71bJTqnpaSGh7VHQG0NQ&oh=737f47091775dc913357fea7f938c976&oe=5BC3E5E5",
                        "productId" => "1",
                        "productName" => "Momo",
                        "productPrice" => "200",
                        "productDiscount" => "12",
                        "productFinalPrice" => "176",
                        "productDescription" => "Ekdum mitho momo. Chadai aunus ani discount payera khanus.",
                        "productLikeCount" => "200",
                        "productBanner" => [
                            "bannerTitle" => "Mitho Momo",
                            "bannerImages" => [
                                [
                                    "imagePath" => "https://www.whatsuplife.in/delhi/blog/wp-content/uploads/2016/11/momos-8.jpg"
                                ],
                                [
                                    "imagePath" => "http://www.iwallfinder.com/files/62/the-first-series-of-chinese-snack-noodles-30957.jpg"
                                ]
                            ],
                            "bannerTexts" => [
                                [
                                    "title" => "Many customers like our momo."
                                ],
                                [
                                    "title" => "Come Visit Us"
                                ]
                            ]
                        ]
                    ],
                    [
                        "clientId" => "3",
                        "clientName" => "Nike",
                        "clientLogo" => "http://2.bp.blogspot.com/-HJQ9hd4GlAI/Uz6_CiWJEdI/AAAAAAAAHz8/Wz3cAA-FHFQ/s1600/Nike+HD+Wallpaper.jpg",
                        "productId" => "2",
                        "productName" => "Nike Blaze",
                        "productPrice" => "15000",
                        "productDiscount" => "7",
                        "productFinalPrice" => "13950",
                        "productDescription" => "Ekdum dami jutta.",
                        "productLikeCount" => "47",
                        "productBanner" => [
                            "bannerTitle" => "Nike everywhere you go.",
                            "bannerImages" => [
                                [
                                    "imagePath" => "http://paytmofferlive.wpengine.com/wp-content/uploads/2017/01/shBnr02.jpg"
                                ],
                                [
                                    "imagePath" => "https://wallpapercave.com/wp/fwJJS77.jpg"
                                ]
                            ],
                            "bannerTexts" => [
                                [
                                    "title" => "Variety of colors."
                                ],
                                [
                                    "title" => "!0 visits one free."
                                ]
                            ]

                        ]
                    ]
                ],
            ]
        ];

        $meta = [
            "current_page" =>  1,
            "from" =>  1,
            "last_page" =>  1,
            "path" =>  "http://example.com/pagination",
            "per_page" =>  15,
            "to" =>  10,
            "total" =>  10
        ];

        $links = [
                "first" => "http://example.com/pagination?page=1",
                "last" => "http://example.com/pagination?page=1",
                "prev" => null,
                "next" => null
            ];

        return response()->json([
            'data' => $data,
            'meta' => $meta,
            'links' => $links,
            "action" => "getClientDetail",
            "status" => 1,
            "message" => "",
            "validation" => [],
        ]);
    }

    public function getProductDetail(Request $request)
    {

        // client_id, connection_id, device_id, lat, long
        // post the request data to relative table.
        $product_id = $request->input('product_id');
        $client_id = $request->input('client_id');
        $data = [
            [
                "clientId" => $client_id,
                "clientName" => "Labim",
                "clientLogo" => "http://labim.com.np/img/logo.png",
                "productId" => $product_id,
                "productName" => "Momo",
                "productPrice" => "200",
                "productDiscount" => "12",
                "productFinalPrice" => "176",
                "productDescription" => "Ekdum mitho momo. Chadai aunus ani discount payera khanus.",
                "productLikeCount" => "200",
                "productBanner" => [
                    "bannerTitle" => "Mitho Momo",
                    "bannerImages" => [
                        [
                            "imagePath" => "https://www.whatsuplife.in/delhi/blog/wp-content/uploads/2016/11/momos-8.jpg"
                        ],
                        [
                            "imagePath" => "http://www.iwallfinder.com/files/62/the-first-series-of-chinese-snack-noodles-30957.jpg"
                        ]
                    ],
                    "bannerTexts" => [
                        [
                            "title" => "Many customers like our momo."
                        ],
                        [
                            "title" => "Come Visit Us"
                        ]
                    ]
                ]
            ]
        ];

        $meta = [
          "current_page" =>  1,
          "from" =>  1,
          "last_page" =>  1,
          "path" =>  "http://example.com/pagination",
          "per_page" =>  15,
          "to" =>  10,
          "total" =>  10
      ];

        $links = [
              "first" => "http://example.com/pagination?page=1",
              "last" => "http://example.com/pagination?page=1",
              "prev" => null,
              "next" => null
          ];

        return response()->json([
          'data' => $data,
          'meta' => $meta,
          'links' => $links,
          "action" => "getProductDetail",
          "status" => 1,
          "message" => "",
          "validation" => [],
        ]);
    }
}
