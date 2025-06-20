<?php

namespace Tests\Feature;

use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TopicCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_topic(): void
    {
        $topicData = [
            'name' => 'Technology',
            'description' => 'All about technology and innovation',
        ];

        $topic = Topic::create($topicData);

        $this->assertDatabaseHas('topics', [
            'name' => 'Technology',
            'description' => 'All about technology and innovation',
        ]);

        $this->assertEquals('Technology', $topic->name);
        $this->assertEquals('All about technology and innovation', $topic->description);
    }

    public function test_can_read_a_topic(): void
    {
        $topic = Topic::factory()->create([
            'name' => 'Science',
            'description' => 'Scientific discoveries and research',
        ]);

        $foundTopic = Topic::find($topic->id);

        $this->assertNotNull($foundTopic);
        $this->assertEquals('Science', $foundTopic->name);
        $this->assertEquals('Scientific discoveries and research', $foundTopic->description);
    }

    public function test_can_update_a_topic(): void
    {
        $topic = Topic::factory()->create([
            'name' => 'Original Topic',
            'description' => 'Original description',
        ]);

        $topic->update([
            'name' => 'Updated Topic',
            'description' => 'Updated description',
        ]);

        $this->assertDatabaseHas('topics', [
            'id' => $topic->id,
            'name' => 'Updated Topic',
            'description' => 'Updated description',
        ]);

        $this->assertEquals('Updated Topic', $topic->fresh()->name);
        $this->assertEquals('Updated description', $topic->fresh()->description);
    }

    public function test_can_delete_a_topic(): void
    {
        $topic = Topic::factory()->create([
            'name' => 'To Be Deleted',
        ]);

        $topicId = $topic->id;
        $topic->delete();

        $this->assertDatabaseMissing('topics', [
            'id' => $topicId,
        ]);

        $this->assertNull(Topic::find($topicId));
    }
}