<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->title();
        return [
            'title' => $title,
            'slug' => $this->faker->slug(),
            'body' => $this->faker->text(),
            'channel_id' => function(){
                return Channel::factory()->create();
            },
            'user_id' => function(){
                return User::factory()->create();
            }
        ];
    }
}
