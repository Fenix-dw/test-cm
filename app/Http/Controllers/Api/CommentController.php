<?php

namespace App\Http\Controllers\Api;

use App\Data\CommentData;
use App\Data\Requests\CommentRequestData;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\News;
use App\Repositories\CommentRepository;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\PaginatedDataCollection;

final class CommentController extends Controller
{

    public function __construct(
        protected CommentService $commentService,
        protected CommentRepository $commentRepository,
    )
    {
    }

    public function index(News $news): PaginatedDataCollection
    {
        $comments = $this->commentRepository
            ->paginateFilter($news, request('per_page'));

        return CommentData::collect($comments);
    }

    public function show(int $comment): CommentData
    {
        $comment = $this->commentRepository->find($comment);

        if(empty($comment)){
            abort(404, 'Not found.');
        }

        return CommentData::from($comment);
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
