<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Http;

/**
 * 
 * @author ivannofick
 * 
 * helper custom Query using Elastic search
 * 
 * you can use it, just call class it on a controller
 * ruangapp.com
 */
class CustomApiEsV7
{
  public function createIndex($idIndex, $data, $index)
  {
    $request = $httpClient->request('PUT', config('services.elasticsearch.base_url').$index."/"."_doc/".$idIndex, [
        'headers' => [
            'accept' => 'application/json'
        ],
        'json' => $data
    ]);
    $dataResponse = json_decode($request->getBody()->getContents());
    return (array)$dataResponse;
  }

  public function getIndex($idIndex, $data, $index)
  {
   $request = $httpClient->request('GET', config('services.elasticsearch.base_url').$index."/"."_search", [
        'headers' => [
            'accept' => 'application/json'
        ],
        'json' => $data
    ]);
    $dataResponse = json_decode($request->getBody()->getContents());
    return (array)$dataResponse;
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