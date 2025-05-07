<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogCommentCreated implements ShouldQueue
{
    public function handle(CommentCreated $event): void
    {
        Log::info("New Comment. #{$event->comment->id}, {$event->comment->text}, userID #{$event->comment->userId}");
    }
}
