<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'description',
        'owner_id',
        'notes'
    ];

    public function path(){
        return "/projects/{$this->id}";
    }

    public function owner(){
     return $this->belongsTo(User::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function addTask($body){
      return  $this->tasks()->create(compact('body'));
    }
}
