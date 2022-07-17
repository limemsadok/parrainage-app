@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{asset('css/style.css')}}" />
@endsection

@section('js')
<script src="{{asset('js/tree.js')}}"></script>
@endsection
@section('content')

<div class="container-fluid">
    <h1 class="mt-4">Advisor Tree</h1>
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-md-12">
                @if ($advisorsTree)
                <ul id="tree1">
                    @foreach ($advisorsTree as $advisor)
                    @php($advisor = (object)$advisor)
                    <li>
                        <a href="{{route("advisor.show",$advisor->id)}}">{{$advisor->login}} ({{ count($advisor->childrens)}})</a>
                        @if(@$advisor->childrens)
                            @include('advisor_child', ['advisorChild'=>$advisor->childrens])
                        @endif
                    </li> 
                    @endforeach
                </ul>    
                @endif
            </div>
            </div>
            </div>
        </div>
    </div></div>
@endsection