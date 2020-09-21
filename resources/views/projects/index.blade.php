@extends('layouts.app')
@section('content')
        <header class="flex items-center mb-3 py-4">
            <div class="flex justify-end w-full items-center">
                <h2 class="mr-auto">My Projects</h2>
                <a class="button" href="{{route('projects.create')}}">New Project</a>
            </div>
        </header>
        <div class="lg:flex lg:flex-wrap -mx-3">
            @forelse($projects??[] as $project)
                <div class="lg:w-1/3 px-4 pb-6">
                    @include('projects.part.card')
                </div>
            @empty
                <p>No There data</p>
            @endforelse
        </div>
@endsection
