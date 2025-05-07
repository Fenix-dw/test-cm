<?php

namespace App\Events;

use App\Data\CommentData;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
class CommentCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public CommentData $comment,
    ) {}

    public function broadcastOn()
    {
        return new Channel('news-comments');
    }

    public function broadcastAs()
    {
        return 'NewCommentCreated';
    }
}
