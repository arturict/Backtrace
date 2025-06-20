<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_user(): void
    {
        $userData = [
            'FullName' => 'John Doe',
            'FirstName' => 'John',
            'LastName' => 'Doe',
            'username' => 'johndoe',
            'password' => bcrypt('password123'),
        ];

        $user = User::create($userData);

        $this->assertDatabaseHas('users', [
            'FullName' => 'John Doe',
            'FirstName' => 'John',
            'LastName' => 'Doe',
            'username' => 'johndoe',
        ]);

        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('johndoe', $user->email);
    }

    public function test_can_read_a_user(): void
    {
        $user = User::factory()->create([
            'FullName' => 'Jane Smith',
            'username' => 'janesmith',
        ]);

        $foundUser = User::find($user->id);

        $this->assertNotNull($foundUser);
        $this->assertEquals('Jane Smith', $foundUser->FullName);
        $this->assertEquals('janesmith', $foundUser->username);
        $this->assertEquals('Jane Smith', $foundUser->name);
        $this->assertEquals('janesmith', $foundUser->email);
    }

    public function test_can_update_a_user(): void
    {
        $user = User::factory()->create([
            'FullName' => 'Original Name',
            'username' => 'original',
        ]);

        $user->update([
            'FullName' => 'Updated Name',
            'username' => 'updated',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'FullName' => 'Updated Name',
            'username' => 'updated',
        ]);

        $this->assertEquals('Updated Name', $user->fresh()->name);
        $this->assertEquals('updated', $user->fresh()->email);
    }

    public function test_can_delete_a_user(): void
    {
        $user = User::factory()->create([
            'username' => 'tobedeleted',
        ]);

        $userId = $user->id;
        $user->delete();

        $this->assertDatabaseMissing('users', [
            'id' => $userId,
        ]);

        $this->assertNull(User::find($userId));
    }
}