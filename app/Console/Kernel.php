<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Components\GitHub\FetchGitHubFileContent::class,
        \App\Components\GoogleCalendar\FetchGoogleCalendarEvents::class,
        \App\Components\GoogleAnalytics\FetchGoogleAnalyticsEvents::class,
        \App\Components\LastFm\FetchCurrentTrack::class,
        \App\Components\InternetConnectionStatus\SendHeartbeat::class,
        \App\Components\RainForecast\FetchRainForecast::class,
        \App\Components\Twitter\ListenForMentions::class,
        \App\Components\SocialMedia\FetchShares::class,
        \App\Components\Pipedrive\FetchPipedrive::class,
        \App\Components\Newsletter\FetchNewsletter::class,
        \App\Components\SeoStats\fetchseo::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(\App\Components\LastFm\FetchCurrentTrack::class)->everyMinute();
        $schedule->command(\App\Components\GoogleCalendar\FetchGoogleCalendarEvents::class)->everyFiveMinutes();
        $schedule->command(\App\Components\GoogleAnalytics\FetchGoogleAnalyticsEvents::class)->everyFiveMinutes();
        $schedule->command(\App\Components\GitHub\FetchGitHubFileContent::class)->everyFiveMinutes();
        $schedule->command(\App\Components\InternetConnectionStatus\SendHeartbeat::class)->everyMinute();
        $schedule->command(\App\Components\RainForecast\FetchRainForecast::class)->everyMinute();
        $schedule->command(\App\Components\SocialMedia\FetchShares::class)->everyMinute();
        $schedule->command(\App\Components\Pipedrive\FetchPipedrive::class)->everyMinute();
        $schedule->command(\App\Components\Newsletter\FetchNewsletter::class)->everyMinute();
        $schedule->command(\App\Components\SeoStats\fetchseo::class)->everyMinute();
    }
}
