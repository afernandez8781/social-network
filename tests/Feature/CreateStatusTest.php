<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Status;
use App\Http\Resources\StatusResource;
use App\Events\StatusCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function guests_users_can_not_create_statuses()
	{
		$response = $this->postJson(route('statuses.store'), ['body' => 'Mi primer status']);

		$response->assertStatus(401);
	}
    /** @test */
    public function an_authenticated_user_can_create_statuses()
    {
      Event::fake([StatusCreated::class]);

       	$user = factory(User::class)->create();
       	$this->actingAs($user);

       	$response = $this->postJson(route('statuses.store'), ['body' => 'Mi primer status']);

        Event::assertDispatched(StatusCreated::class, function ($e){
          return $e->status->id === Status::first()->id
              && get_class($e->status) === StatusResource::class;
        });

       	$response->assertJson([
       		'data' => ['body' => 'Mi primer status'],
       	]);

       	// 3. Then => Entonces veo un uevo estado en la base de datos
       	$this->assertDatabaseHas('statuses', [
       		'user_id' => $user->id,
       		'body' => 'Mi primer status'
       	]);
    }

    /** @test */
    public function a_status_requires_a_body()
    {
    	$user = factory(User::class)->create();
    	$this->actingAs($user);

    	$response = $this->postJson(route('statuses.store'), ['body' => '']);

    	$response->assertStatus(422);

    	$response->assertJsonStructure([
    		'message', 'errors' => ['body']
    	]);
    }

    /** @test */
    public function a_status_body_requires_a_minimum_length()
    {
    	$user = factory(User::class)->create();
    	$this->actingAs($user);

    	$response = $this->postJson(route('statuses.store'), ['body' => 'asdf']);

    	$response->assertStatus(422);

    	$response->assertJsonStructure([
    		'message', 'errors' => ['body']
    	]);
    }
}
