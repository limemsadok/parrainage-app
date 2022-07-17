<?php

namespace App\Jobs;

use App\Models\Advisor;
use App\Models\RankRevision;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class PassageDeGrade implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        RankRevision::truncate();
        $advisors = Advisor::with("teamScore","amount")->get();
        $configRank = DB::table('config_rank_levellings')->orderBy("amount","DESC")->get()->toArray();
        
        foreach ($advisors as $advisor) {
            if(optional($advisor->amount)->amount > 200){
                $new_rank_id = getNewRank($configRank,optional($advisor->teamScore)->amount); 
                if($new_rank_id> $advisor->rank_id)  {
                    $rankRevision[]=[
                        "advisor_id" => $advisor->id ,
                        "old_rank_id" => $advisor->rank_id ,
                        "new_rank_id" => $new_rank_id ,
                        "amount" => optional($advisor->teamScore)->amount ,
                    ];
                }          
            }
        }
        RankRevision::insert($rankRevision);
    }
}
