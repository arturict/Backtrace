<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_model_relationships_work_correctly(): void
    {
        // Create a user
        $user = User::factory()->create(['FullName' => 'Test User']);
        
        // Create a topic
        $topic = Topic::factory()->create(['name' => 'Test Topic']);
        
        // Create a post
        $post = Post::factory()->create([
            'title' => 'Test Post',
            'user_id' => $user->id,
            'topic_id' => $topic->id,
        ]);
        
        // Create a comment
        $comment = Comment::factory()->create([
            'content' => 'Test Comment',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        // Test User relationships
        $this->assertEquals(1, $user->posts()->count());
        $this->assertEquals(1, $user->comments()->count());
        $this->assertEquals($post->id, $user->posts->first()->id);
        $this->assertEquals($comment->id, $user->comments->first()->id);

        // Test Post relationships
        $this->assertEquals($user->id, $post->user->id);
        $this->assertEquals($topic->id, $post->topic->id);
        $this->assertEquals(1, $post->comments()->count());
        $this->assertEquals($comment->id, $post->comments->first()->id);

        // Test Comment relationships
        $this->assertEquals($user->id, $comment->user->id);
        $this->assertEquals($post->id, $comment->post->id);

        // Test Topic relationships
        $this->assertEquals(1, $topic->posts()->count());
        $this->assertEquals($post->id, $topic->posts->first()->id);
    }
}