<?php

namespace App\Http\Controllers;


use App\Models\Advisor;
use App\Models\AdvisorTree;
use App\Models\Order;
use App\Models\PersonalScore;
use App\Models\RankRevision;
use App\Models\ReferralBonuse;
use App\Models\TeamBonuse;
use App\Models\TeamScore;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        return view('dashboard');
    }

    public function animation(){
        $advisorsWithDirectChild = AdvisorTree::where("direct",1)->get();
        $allAdvisors = Advisor::all()->toArray();
        foreach($advisorsWithDirectChild as $adv){
            $chd_rank = getRank($allAdvisors,$adv->child_id);
            $adv_rank = getRank($allAdvisors,$adv->advisor_id);
            $personalScore = $adv->getPersoScore()->first();
            if($adv_rank>$chd_rank && $chd_rank>1 && optional($personalScore)->amount > 200){
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
    }

    public function parrainage(){
        $configParrainage = DB::table('config_referral_bonuses')->get()->toArray();
        $orders = Order::where([
                ["fo",1],
                ["paid",1],
                ["parent_rank",">","advisor_rank"]
                ])->get();
        foreach($orders as $order){
            //dd(getPourcentage($configParrainage,$order->parent_rank)*$order->total_value/100);
            ReferralBonuse::create([
                "advisor_id" => $order->parent_id,
                "order_id" => $order->id,
                "amount" => getPourcentageParrainage($configParrainage,$order->parent_rank)*$order->total_value/100,
            ]);
        }             
    } 

    public function calculChiffres(){
        
        //Calculate and Store Personal score
        $persoScore = Order::where('paid',1)
        ->groupBy('advisor_id')
        ->selectRaw('advisor_id, sum(total_value) as amount')->get();
		PersonalScore::insert($persoScore->toArray());
        //Fin Calculate and Store Personal score

        //Calculate and Store Team score
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
