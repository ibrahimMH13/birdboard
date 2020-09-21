<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->sentence(1),
            'completed' => rand(0, 1),
            'project_id' => function () {
                return Project::factory()->create()->id;
            },
        ];
    }
}
