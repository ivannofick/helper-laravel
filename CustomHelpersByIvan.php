<?php

namespace App\Helpers;
use Illuminate\Pagination\LengthAwarePaginator;
/**
 * 
 * @author ivannofick
 * ruangapp.com
 */
class CustomHelpersByIvan
{

    public static function arrayPaginator($array, $request)
    {
        $page = $request->page;
        $perPage = 10;
        $offset = ($page * $perPage) - $perPage;

        // return new \Illuminate\Pagination\Paginator($array, 2);
        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]);
    }
}