<?php

namespace App\Console\Commands;

use App\Models\Deal;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckDeals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:deals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This comman checks the active deals for expiration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deals = Deal::where('active',1)->get();

        $currantTime = Carbon::now();

        foreach ($deals as $deal) {

            if($deal->end_at->lessThan($currantTime)){
                $deal->update(['active'=> 0]);
            }
        }

        logger('done');
    }
}
