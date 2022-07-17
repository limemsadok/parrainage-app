@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Dashboard for <strong>{{ $advisor->login.'- ID'.$advisor->id}} </strong></h1>
    <div class="container" style="margin-top:30px;">
        <div class="card-deck">
            <div class="card">
                <div class="card-header">Advisor Info</div>
              <div class="card-body">
                <p class="card-text">Login : {{$advisor->login}}</p>
                <p class="card-text">Rank : {{$advisor->rank_id}}</p>
                <p class="card-text">Advisor child: {{count($adviorChild)}}</p>
              </div>
            </div>
            <div class="card">
                <div class="card-header">Personal & Team Score</div>
              <div class="card-body">
                <h5 class="card-title">Personal score</h5>
                <p class="card-text">{{$personalScore?number_format($personalScore->amount):0}}</p>
                <h5 class="card-title">Team score</h5>
                <p class="card-text">{{number_format($teamScore->amount)}}</p>
              </div>
            </div>
            <div class="card">
                <div class="card-header">Referral & Team Bonus</div>
              <div class="card-body">
                <h5 class="card-title">Referral bonus</h5>
                <p class="card-text">{{number_format($parrainageBonuse)}}</p>
                <h5 class="card-title">Team bonus</h5>
                <p class="card-text">{{number_format($animationBonuse)}}</p>
              </div>
            </div>
            <div class="card">
                <div class="card-header">Rank revision</div>
              <div class="card-body">
                <p class="card-text">Old rank : {{$newRank?$newRank->old_rank_id:$advisor->rank_id}}</p>
                <p class="card-text">New rank : {{$newRank?$newRank->new_rank_id:'-'}}</p>
                <p class="card-text">Amount : {{$newRank?number_format($newRank->amount):'-'}}</p>
            </div>
            </div>
          </div>
    </div>
    <h3  class="mt-4">Advisor orders :</h3>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Total value</th>
            <th scope="col">Paid</th>
            <th scope="col">First Order</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($adviorOrders as $order)
            <tr>
                <th scope="row">{{$order->id}}</th>
                <td>{{$order->total_value}}</td>
                <td>{{$order->paid?'yes':'no'}}</td>
                <td>{{$order->fo?'yes':'no'}}</td>
              </tr>   
            @endforeach
        </tbody>
      </table>
</div>
@endsection