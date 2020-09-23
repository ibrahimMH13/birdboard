<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use \App\Models\User;
class ProjectTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testUserCanCreateProject(){
        $this->withoutExceptionHandling();
        $this->singIn();
        $this->get('projects/create')->assertStatus(200);
        $attribute =[
            'title'=>$this->faker->sentence,
            'description'=>$this->faker->sentence,
            'notes' => 'General Note...'
        ];
        $response = $this->post('/projects',$attribute);
        $project = Project::where($attribute)->first();
        $response->assertRedirect($project->path());
        $this->assertDatabaseHas('projects',$attribute);
        $this->get($project->path())
            ->assertSee($attribute['title'])
            ->assertSee($attribute['description'])
            ->assertSee($attribute['notes']);
    }
    public function testUserCanViewProject(){
        $this->singIn();
        //$this->withoutExceptionHandling();
        $project =Project::factory()->create(['owner_id'=>auth()->id()]);
        $this->get($project->path())->assertSee($project->title)->assertSee($project->description);
    }
    public function testAuthUserCannotSeeProjectOther(){
        $this->singIn();
        $project = Project::factory()->create();
        $this->get($project->path())->assertStatus(403);
    }
    public function testOnlyUserCanViewProject(){
        $project =Project::factory()->make();
        $this->get($project->path())->assertRedirect('login');
     }
    public function testProjectRequiredOwner(){
        $attribute = Project::factory()->raw(['owner_id' => null]);
        $this->post('/projects', $attribute)->assertRedirect('login');

    }
    public function testProjectRequireTitle(){
        $this->singIn();
        $attribute = Project::factory()->raw(['title'=>'']);
        $this->post('/projects',$attribute)->assertSessionHasErrors('title');
    }
    public function testProjectRequireDescription(){
        $this->singIn();
        $attribute = Project::factory()->raw(['description'=>'']);
        $this->post('/projects',$attribute)->assertSessionHasErrors('description');
    }

    public function testUserCanUpdateProject(){
        $this->singIn();
        $project = Project::factory()->create(['owner_id'=>\auth()->id()]);
        $this->patch($project->path(),[
            'notes' => 'added new Notes'
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects',['notes'=>'added new Notes']);
      }
    public function testOnlyOwnerUserCanUpdateProject(){
        $this->singIn();
        $project = Project::factory()->create();
        $this->patch($project->path(),[
            'notes' => 'added new Notes'
        ])->assertStatus(403);
      }
    /**
    test Model
     **/
    public function testHavePath(){
        $project =Project::factory()->make();
        $this->assertEquals("/projects/{$project->id}",$project->path());
    }
    public function testRelationShipProjectUser(){
        $this->singIn();
        $project = Project::factory()->create();
        $this->assertInstanceOf(User::class,$project->owner);
    }

    public function testItCanAddTask(){
        $project = Project::factory()->create();
        $task = $project->addTask("test Task");
        $this->assertTrue($project->tasks->contains($task));
    }

}
