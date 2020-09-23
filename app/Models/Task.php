<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable=[
        'body',
        'completed',
        'project_id',
    ];
    //here we notify table or model have relation ship with task model when task model updated
    protected $touches =['project'];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function path(){
        return "{$this->project->path()}./task/{$this->id}";
    }
}
