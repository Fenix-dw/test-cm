<?php

namespace App\Http\Controllers\Api;

use App\Data\CommentData;
use App\Data\Requests\CommentRequestData;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\News;
use App\Repositories\Interfaces\CommentContract;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

final class CommentController extends Controller
{

    public function __construct(
        protected CommentService $commentService,
        protected CommentContract $commentRepository
    )
    {
    }

    public function index(News $news): LengthAwarePaginator
    {
        return $this->commentRepository->paginateFilter($news);
    }

    public function show(int $comment): CommentData
    {
        return $this->commentRepository->find($comment);
    }

    public function store(News $news, CommentRequestData $requestData): CommentData
    {
        $this->authorize('create', Comment::class);

        $comment = $this->commentService->create($news, $requestData);

        return CommentData::from($comment);
    }

    public function update(Comment $comment, CommentRequestData $requestData): CommentData
    {
        $this->authorize('update', $comment);

        $comment = $this->commentService->update($comment, $requestData);

        return CommentData::from($comment);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        $this->authorize('delete', $comment);

        $this->commentService->delete($comment);

        return response()->json(['status' => true]);
    }
}
