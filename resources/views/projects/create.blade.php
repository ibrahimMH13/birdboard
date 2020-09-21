@extends('layouts.app')
@section('content')
    <div>
        <form method="POST" action="{{route('projects.store')}}">
            @csrf
             <input type="text" name="title" >
            <p>
            <textarea  name="description">
            </textarea>
            </p>
            <button>ADD</button>

        </form>
    </div>
@endsection
