<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_index()
    {
        $comment = Comment::factory()->create();

        $filter = [
            'filter[user.id]' => $comment->user_id,
            'filter[user.name]' => $comment->user->name,
            'filter[user.email]' => $comment->user->email,
            'filter[text]' => $comment->text,
        ];

        $this->actingAs($comment->user)
            ->getJson("/api/comments/{$comment->id}?". http_build_query($filter))
            ->assertStatus(200)
            ->assertSee($comment->text);
    }

    public function test_can_read()
    {
        $comment = Comment::factory()->create();

        $this->actingAs($comment->user)
            ->getJson("/api/comments/{$comment->id}")
            ->assertStatus(200)
            ->assertSeeText($comment->text);
    }

    public function test_can_update()
    {
        $comment = Comment::factory()->create();

        $updatedData = [
            'text' => 'Updated comment',
        ];

        $this->actingAs($comment->user)
            ->putJson("/api/comments/{$comment->id}", $updatedData)
            ->assertStatus(200);

        $this->assertDatabaseHas('comments', $updatedData);
    }

    public function test_can_create()
    {
        $user = User::factory()->create();
        $news = News::factory()->create();

        $data = [
            'text' => 'Create comment',
        ];

        $this->actingAs($user)
            ->postJson("/api/news/{$news->id}/comments", $data)
            ->assertStatus(201);

        $this->assertDatabaseHas('comments', $data);
    }

    public function test_can_delete()
    {
        $comment = Comment::factory()->create();

        $this->actingAs($comment->user)
            ->deleteJson("/api/comments/{$comment->id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_error_update()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $updatedData = [
            'text' => 'Updated comment',
        ];

        $this->actingAs($user)->putJson("/api/comments/{$comment->id}", $updatedData)
            ->assertStatus(403);

        $this->assertDatabaseHas('comments', ['text' => $comment->text]);

    }

    public function test_error_delete()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $this->actingAs($user)
            ->deleteJson("/api/comments/{$comment->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('comments', ['id' => $comment->id]);

    }

}
