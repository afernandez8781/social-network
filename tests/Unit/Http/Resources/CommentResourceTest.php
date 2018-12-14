<?php

namespace Tests\Unit\Http\Resources;

use App\Models\Status;
use Tests\TestCase;
use App\Http\Resources\CommentResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentResourceTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
   public function a_comment_resources_must_have_the_necesary_fields()
   {
		$comment = factory(Status::class)->create();

		$commentResource = CommentResource::make($comment)->resolve();

      $this->assertEquals(
         $comment->id, 
         $commentResource['id']
      );

      $this->assertEquals(
         $comment->body, 
         $commentResource['body']
      );

      $this->assertEquals(
         $comment->user->name, 
         $commentResource['user_name']
      );

      $this->assertEquals(
         $comment->user->link(), 
         $commentResource['user_link']
      );

      $this->assertEquals(
         $comment->user->avatar(), 
         $commentResource['user_avatar']
      );

      $this->assertEquals(
         0, 
         $commentResource['likes_count']
      );

      $this->assertEquals(
         false,
         $commentResource['is_liked']
      );
   }
}
