<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testProjectCanHaveATask()
    {
        $this->singIn();
        $this->withoutExceptionHandling();
        $project = Project::factory()->create(['owner_id' => auth()->id()]);
        $this->post("{$project->path()}/task",["body"=>"test Task"]);
        $this->get("{$project->path()}")->assertSee("test Task");

    }
    public function testBodyTaskRequired(){
        $this->singIn();
        $project = Project::factory()->create(['owner_id' => auth()->id()]);
        $attribute = Task::factory()->raw(['body'=>'']);
        $this->post("{$project->path()}/task",$attribute)->assertSessionHasErrors('body');
    }

    public function testOnlyOwnerProjectCanAddTask(){
        $this->singIn();
        $project = Project::factory()->create();
        $this->post($project->path()."/task",['body'=>'test Task'])->assertStatus(403);
        $this->assertDatabaseMissing('tasks',['body'=>'test Task']);
    }

    public function testTaskCanUpdate(){
        $this->singIn();
        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );
        $task = $project->addTask('test Task');
        $this->patch($task->path(),[
            'body' =>'updated',
            'completed' => true,
        ]);
         $this->assertDatabaseMissing('tasks',[
            'body' =>'updated',
            'completed' =>true,
        ]);
    }
    public function testOnlyOwnerTaskCanUpdate(){
        $this->singIn();
        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );
        $task = $project->addTask('test Task');
        $this->patch($task->path(),[
            'body' =>'updated',
            'completed' => true,
        ])->assertStatus(403);
         $this->assertDatabaseMissing('tasks',[
            'body' =>'updated',
            'completed' =>true,
        ]);
    }

    public function testRelationshipWithProject(){
        $task = Task::factory()->create();
        $this->assertInstanceOf(Project::class,$task->project);
    }

    /**
    Model test
     **/
    public function testTaskHavePath(){
        $task = Task::factory()->create();
        $this->assertEquals('/projects/'.$task->project->id.'/task/'.$task->id,$task->path());
    }


}
