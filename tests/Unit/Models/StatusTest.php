<?php

namespace Tests\Unit\Models;

use App\Models\Status;
use App\User;
use App\Models\Like;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function a_status_belongs_to_a_user()
	{
		$status = factory(Status::class)->create();

		$this->assertInstanceOf(User::class, $status->user);
	}

	/** @test */
	function a_status_has_many_likes()
	{
		$status = factory(Status::class)->create();

		factory(Like::class)->create(['status_id' => $status->id]);

		$this->assertInstanceOf(Like::class, $status->likes->first());

	}
	/** @test */
	function a_status_can_be_liked()
	{
		$status = factory(Status::class)->create();

		$this->actingAs(factory(User::class)->create() );

		$status->like();

		$this->assertEquals(1, $status->likes->count());
	}

	/** @test */
	function a_status_can_be_liked_once()
	{
		$status = factory(Status::class)->create();
		
		$this->actingAs(factory(User::class)->create() );

		$status->like();

		$this->assertEquals(1, $status->likes->count());

		$status->like();

		$this->assertEquals(1, $status->fresh()->likes->count());
	}
}
