<?php

namespace App\Http\Controllers;

use App\Models\Advisor;
use App\Models\AdvisorTree;
use App\Models\PersonalScore;
use App\Models\RankRevision;
use App\Models\ReferralBonuse;
use App\Models\TeamBonuse;
use App\Models\TeamScore;
use App\Jobs\CalculChiffre;
use App\Jobs\CalculPrime;
use App\Jobs\PassageDeGrade;
use Illuminate\Support\Facades\Bus;
use Illuminate\Http\Request;

class AdvisorController extends Controller
{
    
    /**
     * Show the application advisor.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $adviors = Advisor::all();
        $advisorsTree = buildTree($adviors->toArray());
        //dd($res);
        return view('advisors',compact('advisorsTree'));
    }    
    /**
     * Show the application advisor.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $advisor = Advisor::findOrFail($id);
        $adviorChild = AdvisorTree::where("advisor_id",$id)->get();
        $adviorOrders = $advisor->advisorOrders()->get();
        $personalScore = PersonalScore::where("advisor_id",$id)->first();
        $teamScore = TeamScore::where("advisor_id",$id)->first();

        $parrainageBonuse = ReferralBonuse::where('advisor_id',$id)->sum("amount");
        $animationBonuse = TeamBonuse::where("advisor_id",$id)->sum("amount");
        $newRank = RankRevision::where('advisor_id',$id)->first();

        return view('advisor_show',compact('advisor','adviorChild','adviorOrders','personalScore','teamScore','parrainageBonuse','animationBonuse','newRank'));
    }
    /**
     * Calculate New Rank advisor.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function passageGrade(){
        return view('passage_grade');
    }

    /**
     * Calculate New Rank advisor.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function newRank(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            $batch = Bus::chain([
                new CalculChiffre,
                new CalculPrime,
                new PassageDeGrade,
                /*(new CalculChiffre)->delay(now()->addMinutes(1)),
                (new CalculPrime)->delay(now()->addMinutes(1)),
                (new PassageDeGrade)->delay(now()->addMinutes(1)),*/
            ])->dispatch();
            return 'ok';
        }
    }
}
