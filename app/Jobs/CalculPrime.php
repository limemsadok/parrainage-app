<?php

namespace App\Jobs;

use App\Models\Advisor;
use App\Models\AdvisorTree;
use App\Models\Order;
use App\Models\ReferralBonuse;
use App\Models\TeamBonuse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CalculPrime implements ShouldQueue
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
        //Prime de parrainage
        ReferralBonuse::truncate();
        $configParrainage = DB::table('config_referral_bonuses')->get()->toArray();
        $orders = Order::where([
                ["fo",1],
                ["paid",1],
                ["parent_rank",">","advisor_rank"]
                ])->get();
        foreach($orders as $order){
            ReferralBonuse::create([
                "advisor_id" => $order->parent_id,
                "order_id" => $order->id,
                "amount" => getPourcentageParrainage($configParrainage,$order->parent_rank)*$order->total_value/100,
            ]);
        } 
        // Fin prime de parrainage

        //Prime d animation
        TeamBonuse::truncate();
        $advisorsWithDirectChild = AdvisorTree::where("direct",1)->get();
        $allAdvisors = Advisor::all()->toArray();
        foreach($advisorsWithDirectChild as $adv){
            $chd_rank = getRank($allAdvisors,$adv->child_id);
            $adv_rank = getRank($allAdvisors,$adv->advisor_id);
            $personalScore = $adv->getPersoScore()->first();
            if($adv_rank>$chd_rank && optional($personalScore)->amount > 200){
                $configAnimation = DB::table('config_team_bonuses')->get()->toArray();
                $animPercentage = getPourcentageAnimation($configAnimation,$adv_rank,$chd_rank);
                $bonusAnimation = $animPercentage* $adv->getTeamScoreChild()->first()->amount ;
                if ($bonusAnimation>0) {                    
                    $teamBonus[]=[
                        "advisor_id"=> $adv->advisor_id,
                        "advisor_rank_id"=> $adv_rank,
                        "child_id"=> $adv->child_id,
                        "child_rank_id"=> $chd_rank,
                        "amount"=> $bonusAnimation,
                    ];
                }
            }
        }
        TeamBonuse::insert($teamBonus);
        // Fin prime d animation
    }
}
