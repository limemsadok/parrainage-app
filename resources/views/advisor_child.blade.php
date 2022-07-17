
@if ($advisorChild)
<ul>
    @foreach ($advisorChild as $advisor)
    @php($advisor = (object)$advisor)
    <li><a href="{{route("advisor.show",$advisor->id)}}">{{$advisor->login}} ({{ count($advisor->childrens)}})</a>
        @if(@$advisor->childrens)
            @include('advisor_child', ['advisorChild'=>$advisor->childrens])
        @endif
    </li> 
    @endforeach
    
</ul>    
@endif
