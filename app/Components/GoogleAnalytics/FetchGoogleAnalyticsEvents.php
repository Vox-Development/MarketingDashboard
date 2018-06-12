<?php

namespace App\Components\GoogleAnalytics;

use App\Events\GoogleAnalytics\EventsFetched;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;
use Spatie\Analytics\Period;
use Analytics;
use GazzleHttp;

class FetchGoogleAnalyticsEvents extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:analytics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Google Analytics events.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $data_totals = array();

        $product_most_viewed_pages = collect(Analytics::fetchTotalVisitorsAndPageViews(Period::days(5)))
        ->map(function ($pages) {return ['pageViews' => $pages['pageViews']];})
            ->take(5)
            ->sum('pageViews');

        $product_top_pages = collect(Analytics::fetchMostVisitedPages(Period::days(5)))
        ->map(function ($top_pages) {
            return [
                'pageTitle' => $top_pages['pageTitle'],
                'pageViews' => $top_pages['pageViews']
            ];
        })
        ->take(5)
        ->unique('pageTitle')
        ->toArray();

        $data_totals['total_page_views'] =  $product_most_viewed_pages;
        $data_totals['top_page_views'] =  $product_top_pages;
        $users = Analytics::getActiveUsers();
        $data_totals['current_users_online'] =  $users[0]['active_users'];

        //dd($data_totals);
       event(new EventsFetched($data_totals));
    }
}
