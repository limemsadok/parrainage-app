<?php

namespace App\Jobs;

use App\Models\Advisor;
use App\Models\Order;
use App\Models\PersonalScore;
use App\Models\TeamScore;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculChiffre implements ShouldQueue
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
        //Calculate and Store Personal score
        PersonalScore::truncate();
        $persoScore = Order::where('paid',1)
        ->groupBy('advisor_id')
        ->selectRaw('advisor_id, sum(total_value) as amount')->get();
		PersonalScore::insert($persoScore->toArray());
        //Fin Calculate and Store Personal score

        //Calculate and Store Team score
        TeamScore::truncate();
        $advisors = Advisor::with("amount")->get();
        foreach($advisors as $advisor){
            $advisorAmount = (optional($advisor->amount)->amount)?optional($advisor->amount)->amount:0;
            $sumAmount = $advisor->childAmount()->sum('amount')+$advisorAmount;
            $teamScore[]=[
                "advisor_id" => $advisor->id ,
                "amount" => ($sumAmount)?$sumAmount:0 ,
            ];
        }
        TeamScore::insert($teamScore);
        // Fin Calculate and Store Team score
    }
}
