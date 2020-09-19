<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $this->be(User::factory()->create());
        $this->withoutExceptionHandling();
        $this->get('projects/create')->assertStatus(200);
        $attribute =[
            'title'=>$this->faker->title,
            'description'=>$this->faker->sentence
        ];
        $attribute['owner_id'] = auth()->id();
        $this->post('/projects',$attribute);
        $this->assertDatabaseHas('projects',$attribute);
        $this->get('/projects')->assertSee($attribute['title']);
    }
    public function testUserCanViewProject(){
        $this->be(User::factory()->create());
        $this->withoutExceptionHandling();
        $project =Project::factory()->create(['owner_id'=>auth()->id()]);
        $this->get($project->path())->assertSee($project->title)->assertSee($project->description);
    }
    public function testAuthUserCannotSeeProjectOther(){
        $this->be(User::factory()->create());
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
        $this->be(User::factory()->create());
        $attribute = Project::factory()->raw(['title'=>'']);
        $this->post('/projects',$attribute)->assertSessionHasErrors('title');
    }
    public function testProjectRequireDescription(){
        $this->be(User::factory()->create());
        $attribute = Project::factory()->raw(['description'=>'']);
        $this->post('/projects',$attribute)->assertSessionHasErrors('description');
    }
    /**
    test Model
     **/
    public function testHavePath(){
        $project =Project::factory()->make();
        $this->assertEquals("projects/{$project->id}",$project->path());
    }
    public function testRelationShipProjectUser(){
        $this->be(User::factory()->create());
        $project = Project::factory()->create();
        $this->assertInstanceOf(User::class,$project->owner);
    }

}
