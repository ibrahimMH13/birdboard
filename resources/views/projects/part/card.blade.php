<div class="cards shadow" style="height: 200px">
    <h3 class="titleProjects"><a href="{{$project->path()}}">{{$project->title}}</a></h3>
    <div class="text-gray-400 break-words">
        {{\Illuminate\Support\Str::limit($project->description,50)}}
        <a href="{{$project->path()}}"></a>
    </div>
</div>
