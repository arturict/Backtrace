<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_comment(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $commentData = [
            'content' => 'This is a great post! Thanks for sharing.',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ];

        $comment = Comment::create($commentData);

        $this->assertDatabaseHas('comments', [
            'content' => 'This is a great post! Thanks for sharing.',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->assertEquals('This is a great post! Thanks for sharing.', $comment->content);
        $this->assertEquals($user->id, $comment->user_id);
        $this->assertEquals($post->id, $comment->post_id);
    }

    public function test_can_read_a_comment(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        
        $comment = Comment::factory()->create([
            'content' => 'Test comment content',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $foundComment = Comment::find($comment->id);

        $this->assertNotNull($foundComment);
        $this->assertEquals('Test comment content', $foundComment->content);
        $this->assertEquals($user->id, $foundComment->user_id);
        $this->assertEquals($post->id, $foundComment->post_id);
    }

    public function test_can_update_a_comment(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        
        $comment = Comment::factory()->create([
            'content' => 'Original comment',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $comment->update([
            'content' => 'Updated comment content',
        ]);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'content' => 'Updated comment content',
        ]);

        $this->assertEquals('Updated comment content', $comment->fresh()->content);
    }

    public function test_can_delete_a_comment(): void
    {
        $comment = Comment::factory()->create([
            'content' => 'To be deleted',
        ]);

        $commentId = $comment->id;
        $comment->delete();

        $this->assertDatabaseMissing('comments', [
            'id' => $commentId,
        ]);

        $this->assertNull(Comment::find($commentId));
    }
}