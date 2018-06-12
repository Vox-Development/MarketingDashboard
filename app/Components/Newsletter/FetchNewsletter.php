<?php

namespace App\Components\Newsletter;

use App\Events\Newsletter\NewsletterFetched;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchNewsletter extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:newsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch everlytic newsletter subscriptions';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $newsletterData = array();

        $user = env('NEWSLETTER_USER');
        $appKey = env('NEWSLETTER_APP_KEY');

        $responseBody = (string) (new Client())
            ->get('live.everlytic.net/api/2.0/lists/45', ['auth' =>  [$user, $appKey]])
            ->getBody();

        $res = $this->getNewsletterDataFromResponseBody($responseBody);
        $resFormatted = $res['total_newsletter_subscribers'];

        $newsletterData['emailContacts'] = $resFormatted->email_contacts;
        $newsletterData['emailContactsBounced'] = $resFormatted->email_contacts_bounced;
        $newsletterData['emailContactsUnsubscribed'] = $resFormatted->email_contacts_unsubscribed;


        //dd($newsletterData);
        event(new NewsletterFetched($newsletterData));
    }


    public function getNewsletterDataFromResponseBody(string $responseBody) : array
    {
        $newsletterList = json_decode($responseBody);

        $everlytic_newsletters_stats = collect($newsletterList)
        ->map(function( $item ) {
            return [
                'total_newsletter_subscribers' => $item
            ];
        })
        ->toArray();

        return $everlytic_newsletters_stats['item'];
    }
}
