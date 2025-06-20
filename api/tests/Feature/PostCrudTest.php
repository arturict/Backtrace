<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_post(): void
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create();

        $postData = [
            'title' => 'My First Post',
            'body' => 'This is the body of my first post.',
            'author' => 'John Doe',
            'status' => 'published',
            'slug' => 'my-first-post-123',
            'views' => 0,
            'topic_id' => $topic->id,
            'user_id' => $user->id,
        ];

        $post = Post::create($postData);

        $this->assertDatabaseHas('posts', [
            'title' => 'My First Post',
            'body' => 'This is the body of my first post.',
            'author' => 'John Doe',
            'status' => 'published',
            'slug' => 'my-first-post-123',
            'views' => 0,
            'topic_id' => $topic->id,
            'user_id' => $user->id,
        ]);

        $this->assertEquals('My First Post', $post->title);
        $this->assertEquals($user->id, $post->user_id);
        $this->assertEquals($topic->id, $post->topic_id);
    }

    public function test_can_read_a_post(): void
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create();
        
        $post = Post::factory()->create([
            'title' => 'Test Post',
            'body' => 'Test body content',
            'user_id' => $user->id,
            'topic_id' => $topic->id,
        ]);

        $foundPost = Post::find($post->id);

        $this->assertNotNull($foundPost);
        $this->assertEquals('Test Post', $foundPost->title);
        $this->assertEquals('Test body content', $foundPost->body);
        $this->assertEquals($user->id, $foundPost->user_id);
        $this->assertEquals($topic->id, $foundPost->topic_id);
    }

    public function test_can_update_a_post(): void
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create();
        
        $post = Post::factory()->create([
            'title' => 'Original Title',
            'body' => 'Original body',
            'user_id' => $user->id,
            'topic_id' => $topic->id,
        ]);

        $post->update([
            'title' => 'Updated Title',
            'body' => 'Updated body content',
            'status' => 'draft',
        ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'body' => 'Updated body content',
            'status' => 'draft',
        ]);

        $this->assertEquals('Updated Title', $post->fresh()->title);
        $this->assertEquals('Updated body content', $post->fresh()->body);
        $this->assertEquals('draft', $post->fresh()->status);
    }

    public function test_can_delete_a_post(): void
    {
        $post = Post::factory()->create([
            'title' => 'To Be Deleted',
        ]);

        $postId = $post->id;
        $post->delete();

        $this->assertSoftDeleted('posts', [
            'id' => $postId,
        ]);

        $this->assertNull(Post::find($postId));
        $this->assertNotNull(Post::withTrashed()->find($postId));
    }
}