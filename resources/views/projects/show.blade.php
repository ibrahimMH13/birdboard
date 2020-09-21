@extends('layouts.app')
@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-end w-full items-center">
            <p class="mr-auto">
                <a href="{{route('projects.index')}}">My Projects</a> / {{$project->title}}
            </p>
            <a class="button" href="{{route('projects.create')}}">New Project</a>
        </div>
    </header>
    <main>
        <div class="flex -ml-3">
            <div class="lg:w-3/4 px-3">
                <div class="mb-8">
                    <h2 class="text-lg text-gray-400 font-normal">Tasks</h2>
                    @foreach($project->tasks as $task)
                        <div class="cards mt-3">
                           <form action="{{$project->path().'/task/'.$task->id}}" method="post">
                               @method('PATCH')
                               @csrf
                                <div class="flex">
                                   <input type="text" class="w-full {{ $task->completed?'text-gray-400':''}}" name="body" value="{{$task->body}}">
                                   <input type="checkbox" name="complete" {{ $task->completed?'checked':''}} onchange="this.form.submit()">
                               </div>
                           </form>
                        </div>
                    @endforeach
                    <div class="cards mt-3">
                        <form action="{{ $project->path()."/task" }}" method="POST">
                            @csrf
                            <input type="text" name="body" placeholder="No There Task Yet, Beging add task..."
                                   class="w-full">
                        </form>
                    </div>
                </div>
                <div class="mb-3">
                <h2 class="text-lg text-gray-400 font-normal">General Tasks</h2>
                <textarea  class="cards w-full" style="min-height: 200px">
                    bla bla bla
                </textarea>
            </div>
            </div>
            <div class="lg:w-1/4 px-3">
                @include('projects.part.card')
            </div>
        </div>
        </div>
    </main>
@endsection
