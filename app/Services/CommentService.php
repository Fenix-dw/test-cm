<?php

namespace App\Services;

use App\Data\CommentData;
use App\Data\Requests\CommentRequestData;
use App\Events\CommentCreated;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Services\Base\MySqlService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class CommentService extends MySqlService
{

    public function create(Model $model, CommentRequestData $data) : Comment
    {
        DB::beginTransaction();

        try {

            $comment = Comment::make($data->toArray());

            $comment->user()->associate(Auth::id());
            $comment->commentable()->associate($model);

            $comment->save();

            event(new CommentCreated(CommentData::from($comment)));

            DB::commit();

            return $comment;
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

    public function update(Comment $comment, CommentRequestData $data) : Comment
    {
        DB::beginTransaction();
        try {
            $comment->update($data->toArray());

            DB::commit();

            return $comment;
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

    public function delete(Comment $comment)
    {
        DB::beginTransaction();
        try {
            $comment->delete();

            DB::commit();

            return $comment;
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }
}
