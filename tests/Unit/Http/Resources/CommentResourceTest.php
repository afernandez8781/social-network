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
         $comment->body, 
         $commentResource['body']
      );

      $this->assertEquals(
         $comment->user->name, 
         $commentResource['user_name']
      );

      $this->assertEquals(
         'https://avatars0.githubusercontent.com/u/33205904?s=400&u=388b4a2754a037d598d2bec4e42a7da102427768&v=4', 
         $commentResource['user_avatar']
      );
   }
}
