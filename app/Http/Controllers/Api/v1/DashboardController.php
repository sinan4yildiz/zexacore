<?php

namespace App\Http\Controllers\Api\v1;

use Analytics;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Dashboard\AnalyticsResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\ContentType;
use App\Models\Message;
use App\Models\Page;
use App\Models\Redirection;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Spatie\Analytics\Period;
use Symfony\Component\Finder\Finder;

class DashboardController extends Controller
{
    /**
     * Reports by periods
     *
     */
    public function reports()
    {
        /**
         * Create a collection
         */
        $reports = collect([]);


        /**
         * Required metrics
         */
        $metrics = ['ga:sessions', 'ga:pageviews'];


        /**
         * Report periods
         */
        $periods = [
            'today'      => Period::days(0),
            'yesterday'  => Period::create(Carbon::yesterday(), Carbon::yesterday()),
            'this_month' => Period::create(Carbon::now()->startOfMonth(), Carbon::now()),
            'this_year'  => Period::create(Carbon::now()->startOfYear(), Carbon::now()),
        ];


        /**
         * Format data
         */
        foreach ($periods as $name => $period) {

            /**
             * Analytics data
             */
            $values = head(Analytics::performQuery($period, implode(',', $metrics))->rows);

            /**
             * Replace numeric keys with metric names
             */
            foreach ($values as $index => $value) {
                $values[ltrim($metrics[$index], 'ga:')] = number_format($value);
                unset($values[$index]);
            }


            /**
             * Put in the collection
             */
            $reports->put($name, $values);
        }


        /**
         * JSON Response
         */
        return response()->json($reports);
    }

    /**
     * Statistics
     *
     */
    public function statistics()
    {
        /**
         * Create a collection
         */
        $statistics = collect([
            'series' => collect([]),
            'labels' => collect([]),
            'total'  => collect([]),
        ]);


        /**
         * Required metrics
         */
        $metrics = ['ga:sessions', 'ga:pageviews'];


        /**
         * Analytics data
         */
        $analytics = Analytics::performQuery(
            Period::create(Carbon::now()->subDays(30), Carbon::yesterday()),
            'ga:sessions',
            [
                'metrics'    => implode(',', $metrics),
                'dimensions' => 'ga:nthDay'
            ]
        );


        /**
         * Format data
         */
        foreach ($analytics->rows as $day) {

            /**
             * Put in the collection
             */
            $statistics['series']->push([
                'sessions'  => $day[1],
                'pageviews' => $day[2],
            ]);
        }


        /**
         * Labels
         */
        foreach (CarbonPeriod::between(Carbon::now()->subDays(30), Carbon::today()) as $date) {
            $statistics['labels']->push($date->format('d M'));
        }


        /**
         * Totals
         */
        foreach ($analytics->totalsForAllResults as $metric => $total) {
            $statistics['total']->push([
                ltrim($metric, 'ga:') => number_format($total)
            ]);
        }


        /**
         * JSON Response
         */
        return response()->json($statistics);
    }

    /**
     * Counts overview
     *
     */
    public function counts()
    {
        /**
         * Create a collection
         */
        $counts = collect([]);


        /**
         * Articles
         */
        $counts->push([
            'module' => 'articles',
            'count'  => number_format(Article::all()->count())
        ]);


        /**
         * Pages
         */
        $counts->push([
            'module' => 'pages',
            'count'  => number_format(Page::all()->count())
        ]);


        /**
         * Uploads
         */
        $finder = new Finder();
        $finder->in(config('filesystems.disks.uploads.root'));
        $files = collect($finder->files()->ignoreDotFiles(true)->ignoreVCS(true));

        $counts->push([
            'module' => 'uploads',
            'count'  => number_format($files->count())
        ]);


        /**
         * Messages
         */
        $counts->push([
            'module' => 'messages',
            'count'  => number_format(Message::all()->count())
        ]);


        /**
         * Users
         */
        $counts->push([
            'module' => 'users',
            'count'  => number_format(User::all()->count())
        ]);


        /**
         * Categories
         */
        $counts->push([
            'module' => 'categories',
            'count'  => number_format(Category::all()->count())
        ]);


        /**
         * Content types
         */
        $counts->push([
            'module' => 'content_types',
            'count'  => number_format(ContentType::all()->count())
        ]);


        /**
         * Redirections
         */
        $counts->push([
            'module' => 'redirections',
            'count'  => number_format(Redirection::all()->count())
        ]);


        /**
         * JSON Response
         */
        return response()->json($counts);
    }
}
