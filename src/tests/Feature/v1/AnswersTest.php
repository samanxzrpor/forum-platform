<?php

namespace Tests\Feature\v1;

use App\Models\Answer;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AnswersTest extends TestCase
{
    use RefreshDatabase;

    public function testShowAllAnswer(): void
    {

        $answers = Answer::factory(13)->create();
        $response = $this->get(route('answers.list'));

        $response->assertStatus(200);
        $response->assertJsonCount(13);
    }

    public function testCreateNewAnswerWithCorrectData(): void
    {
        $thread = Thread::factory()->create();
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson(route('answers.store'),[
            'body' => 'New Test For Create Answer',
            'thread_id' => $thread->id
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('answers' , ['body'=>'New Test For Create Answer']);
    }


    public function testIncreaseUserScoreWheneSubmitAnAnswer()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create();
        $response = $this->postJson(route('answers.store'),[
            'body' => 'New Test For Create Answer',
            'thread_id' => $thread->id
        ]);
        $user->refresh();
        $this->assertDatabaseHas('users' , ['score' => 10]);
        $this->assertEquals(10 , $user->score);
    }


    public function testCreateNewAnswerWithIncorrectData(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson(route('answers.store'),[

        ]);

        $response->assertStatus(422);
    }

    public function testUpdateAnswerWithCorrectDataAndPermissions() : void
    {
        $user = User::factory()->create();
        $answer = Answer::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user);

        $response = $this->putJson(route('answers.update' , [$answer]),[
            'body' => 'Test Body For Update Answer',
            'thread_id' => $answer->thread_id
        ])->isSuccessful();

        $this->assertDatabaseHas('answers' , ['body' => 'Test Body For Update Answer']);
    }

    public function testUpdateAnswerWithCorrectDataAndDontHavePermissions() : void
    {
        $user = User::factory()->create();
        $answer = Answer::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->putJson(route('answers.update' , [$answer]),[
            'body' => 'Test Body For Update Answer',
            'thread_id' => $answer->thread_id
        ]);

        $response->assertStatus(403);
        $this->assertSame($response->json('message') , 'You are not allowed to update answers');
        $this->assertDatabaseMissing('answers' , ['body' => 'Test Body For Update Answer']);
    }


    public function testDeleteAnswers(): void
    {
        $user = User::factory()->create();
        $answer = Answer::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user);

        $response = $this->delete(route('answers.delete' , [$answer]));
        $response->assertStatus(200);
    }
}
