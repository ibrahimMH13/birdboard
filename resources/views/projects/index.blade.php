@extends('welcome')
@section('content')
<div class="">
    <ul>
        @forelse($projects??[] as $project)
            <li><a href="{{$project->path()}}">{{$project->title}}</a></li>
        @empty
            <li>No There data</li>
        @endforelse
    </ul>
</div>
@endsection
