<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;


/**
 * 
 * @author ivannofick
 * 
 * helper custom Query using Elastic search version 7.15
 * 
 * you can use it, just call class it on a controller
 * ruangapp.com
 */
class CustomApiEsV7
{

  /**
   * create index
   * 
   * @param int $idIndex
   * @param array $data
   * @param string $index
   * 
   * @return array $data
   */
  public static function createIndex($idIndex=null, $data=null, $index=null)
  {
    $resCreate = Http::post(config('services.elasticsearch.base_url')."/".$index."/"."_doc/".$idIndex, (array)$data)->body();
    $data = json_decode($resCreate, true);
    return $data;
  }

  /**
   * get data in index ES
   * 
   * @author ruangapp
   * @param Int $idIndex
   * @param Array $data
   * @param String $index
   * @return array $dataResponse
   */
  public static function getIndex($idIndex=null, $data=null, $index=null, $search=null)
  {
    $arr = [
      "query" => [
            "match" => [
                "title" => $search  
            ]
      ]
    ];
    $response = Http::withHeaders(['Content-Type' => 'application/json'])
    ->send('GET', config('services.elasticsearch.base_url')."/".$index."/"."_search?filter_path=hits.hits._source", [
        'json' => $arr
    ])->body();
    $json = json_decode($response, true);

    if (count($json) < 1 || !isset($json["hits"])) {
      $json = [
        "hits" => [
          "hits" => [
            [
              "_source" => ["message" => "data tidak ditemukan"]
            ]
          ]
        ]
      ];
    }
    $dataEs = array_map(function ($i) {
        if (!isset($i["_source"]["message"])) {
            return $i["_source"];
        }
    }, $json["hits"]["hits"]);
    if ($dataEs[0] != null) {
        return $dataEs;
    }
  }


















    // public static function getDataIndex()
    // {
    //     $response = Http::accept('application/json')->withHeaders([
    //         'accept' => 'application/json'
    //     ])->get(config('services.elasticsearch.base_url')."/z_bendol/_mapping?pretty=true")
    //     ->body();
    //     $data = json_decode($response, true);
    //     if (isset($data["status"])) {
    //         return ["data" => "sorry data tidak ditemukan"];
    //     }
    //     return $data;
    // }

    // public static function createIndex()
    // {
    //     $data = array (
    //         'data' => 
    //         array (
    //           0 => 
    //             array (
    //             'id' => 1,
    //             'name' => 'bendil',
    //             'country' => 
    //             array (
    //               'country_name' => 'indonesia',
    //               'region_name' => 'semarang',
    //             ),
    //           ),
    //           1 => 
    //           array (
    //             'id' => 2,
    //             'name' => 'kokorotomo',
    //             'country' => 
    //             array (
    //               'country_name' => 'amerika',
    //               'region_name' => 'cdeak',
    //             ),
    //           ),
    //         ),
    //     );
    //     $request = $httpClient->request('POST', config('services.elasticsearch.base_url').'z_bendol_ko/_doc', [
    //         'headers' => [
    //             'accept' => 'application/json'
    //         ],
    //         'json' => $data
    //     ]);
    //     $dataResponse = json_decode($request->getBody()->getContents());
    //     return (array)$dataResponse;
    // }
}