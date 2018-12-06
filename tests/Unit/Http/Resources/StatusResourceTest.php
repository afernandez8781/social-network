<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\StatusResource;

use App\Models\Status;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusResourceTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
   public function a_status_resources_must_have_the_necesary_fields()
   {
   		$status = factory(Status::class)->create();

   		$statusResource = StatusResource::make($status)->resolve();

   		$this->assertEquals(
            $status->id, 
            $statusResource['id']
         );
         $this->assertEquals(
            $status->body, 
            $statusResource['body']
         );
   		$this->assertEquals(
   			$status->user->name, 
   			$statusResource['user_name']
   		);
   		$this->assertEquals(
   			'https://avatars0.githubusercontent.com/u/33205904?s=400&u=388b4a2754a037d598d2bec4e42a7da102427768&v=4', 
   			$statusResource['user_avatar']
   		);
   		$this->assertEquals(
   			$status->created_at->diffForHumans(), 
   			$statusResource['ago']
   		);
         $this->assertEquals(
            false,
            $statusResource['is_liked']
         );
   }
}
