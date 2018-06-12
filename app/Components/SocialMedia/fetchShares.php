<?php

namespace App\Components\SocialMedia;

use App\Events\SocialMedia\EventsFetched;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchShares extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:social';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the total shares in realtime';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $socialData = array();

        $in_share_count_endpoint = 'https://www.linkedin.com/countserv/count/share?url=http://www.everlytic.co.za/&format=json';
        $twt_followers_endpoint = 'https://cdn.syndication.twimg.com/widgets/followbutton/info.json?screen_names=everlytic';
        $you_uri = 'https://www.googleapis.com/youtube/v3/channels?part=statistics&id=UCvrcHIk91Zas4vxliC0tW6w&key=AIzaSyA0HapNCr0tygI3O3fibGCxdpJSLCTXeWM';
       

        $fb_access_token = 'EAAUtEAs5BR4BAHgbvEIMd8oF5vaaA53ZCRtCKbS96ieYR5tPU1pb05P1ufqIrOL2Q9gTNAGSXGdC3ITg5cUqKoImlaWX01BeU1ADQLn8f71pve8Ws95QEkFYegzSbivFll1Qh1d6WwiYavhYReQfaL7PyYplNZBZA0abIHZC6dAdBg1Ajmr22Fu5WR97B0iLHRcU1TNBdMwUEdlDXACF';
        $fb_uri = "https://graph.facebook.com/v2.10/me?fields=id%2Ccountry_page_likes&access_token=".$fb_access_token;

        $getFacebookLike = (string) (new Client())
                ->get($fb_uri)
                ->getBody();

        $getYouViews = (string) (new Client())
                ->get($you_uri)
                ->getBody();

        $getInShare = (string) (new Client())
                ->get($in_share_count_endpoint)
                ->getBody();

        $getTwitterFollowers = (string) (new Client())
                ->get($twt_followers_endpoint)
                ->getBody();

        $fbResData = $this->getShareCountFromResponseBody($getFacebookLike);
        $inResShareData = $this->getShareCountFromResponseBody($getInShare);
        $twtResShareData = $this->getShareCountFromResponseBody($getTwitterFollowers);
        $youResData = $this->getShareCountFromResponseBody($getYouViews);

        $socialData['facebook_likes_count'] = $fbResData['country_page_likes']['social'];
        $socialData['Website_in_share_count'] = $inResShareData['count']['social'];
        $socialData['twitter_followers_count'] = $twtResShareData[0]['social']->followers_count;
        $socialData['youtube_subscribers_count'] = (int) $youResData['items']['social'][0]->statistics->subscriberCount;

        event(new EventsFetched($socialData));
        //dd($socialData);
    }

    public function getShareCountFromResponseBody(string $responseBody) : array
    {
        $shareItems = json_decode($responseBody);

        $data = collect($shareItems)
        ->map(function ($shares) {
            return [
                'social' => $shares
            ];
        })
        ->toArray();

        $social = $data;

        return $social;
    }
}
