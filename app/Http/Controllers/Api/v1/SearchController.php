<?php

namespace App\Http\Controllers\Api\v1;

use Analytics;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class SearchController extends Controller
{
    /**
     * Search all modules
     *
     */
    public function index()
    {
        /**
         * Create a collection
         */
        $results = collect([]);


        /**
         * Articles
         */
        $articles = Article::where('title', 'LIKE', '%' . Request::input('keyword') . '%')->limit(4)->get();

        if ($articles->isNotEmpty()) {
            $results->put('articles', $articles->map(function ($item) {
                return [
                    'id'   => $item->id,
                    'text' => $item->title,
                ];
            }));
        }


        /**
         * Pages
         */
        $pages = Page::where('title', 'LIKE', '%' . Request::input('keyword') . '%')->limit(4)->get();

        if ($pages->isNotEmpty()) {
            $results->put('pages', $pages->map(function ($item) {
                return [
                    'id'   => $item->id,
                    'text' => $item->title,
                ];
            }));
        }


        /**
         * JSON Response
         */
        return response()->json($results);
    }
}
