<?php

namespace Tests\Feature\v1;

use App\Http\Controllers\API\V1\Thraed\ThreadsController;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{

    use RefreshDatabase;

    public function testGetAllThreads()
    {
        $threads = Thread::factory(12)->create();
        $response = $this->getJson(route('thread.list'));
        $response->assertStatus(200);
    }

    public function testGetOneThreadWithSlug (){

        $thread = Thread::factory()->create();
        $response = $this->getJson(route('thread.show') , [
            'slug' => $thread->slug
        ]);

        $response->assertStatus(200);
//        $this->assertEquals($thread->name, $response->);
    }
}
