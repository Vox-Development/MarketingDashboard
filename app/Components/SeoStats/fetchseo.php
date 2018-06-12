<?php

namespace App\Components\SeoStats;

//use App\Events\Pipedrive\EventsFetched;
use SEOstats\Services as SEOstats;
//use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchSeo extends Command
{

	/**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:seo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch seo';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = 'http://www.everlytic.co.za/';
        $seostats = new \SEOstats\SEOstats;

        if ($seostats->setUrl($url)) {
            // Create a new SEOstats instance.
    		///dd(SEOstats\Alexa::getGlobalRank());
            dd(SEOstats\Social::getLinkedInShares());
            // dd(SEOstats\Alexa::getGlobalRank());
            // dd(SEOstats\Alexa::getGlobalRank());
            // dd(SEOstats\Alexa::getGlobalRank());
            // dd(SEOstats\Alexa::getGlobalRank());
        }
    }
}