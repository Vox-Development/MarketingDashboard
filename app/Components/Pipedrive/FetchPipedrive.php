<?php

namespace App\Components\Pipedrive;

use App\Events\Pipedrive\EventsFetched;
use LasseRafn\Pipedrive;
use GuzzleHttp\Client;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;

class FetchPipedrive extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:pipedrive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch pipedrive tasks';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pipedriveData = array();

        $pipedrive = new Pipedrive\Pipedrive();
        $deals = $pipedrive->deals(18)->all();

        $dealsWon = collect($deals)
            ->map(function ($item) {
                return [
                'status' => $item->status === 'won'
                ];
            })
            ->sum('status');

        $dealsLost = collect($deals)
            ->map(function ($item) {
                return [
                'status' => $item->status === 'lost',
                ];
            })
            ->sum('status');

        $dealsIn = collect($deals)
        ->map(function ($item) {
            return [
            'status' => $item->status === 'open',
            ];
        })
        ->sum('status');

        $dealsInToday = collect($deals)
        ->map(function ($item) {
            $DateNow = Carbon::today();
            $dateCompare = preg_match("/(\d{4})\-(\d{1,2})\-(\d{1,2})/", $item->add_time, $matches);
            return [
            'date' => $dateCompare === Carbon::createFromFormat('Y-m-d H:i:s', $DateNow)->format('Y-m-d')
            ];
        });

        $dealsInTodayCollected = collect($dealsInToday)
        ->filter(function ($date) {
            return $date['date'] != false;
        })
        ->map(function($item){
            return [
                'items' => count($item['date'])
            ];
        })->sum('items');


        $pipedriveData['TotalDealsWon'] = $dealsWon;
        $pipedriveData['TotalDealsLost'] = $dealsLost;
        $pipedriveData['TotalLeadsIn'] = $dealsIn;
        $pipedriveData['TotalLeadsInToday'] = $dealsInTodayCollected;

        

        //dd($pipedriveData);

        event(new EventsFetched($pipedriveData));
    }
}
