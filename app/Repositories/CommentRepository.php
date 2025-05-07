<?php

namespace App\Repositories;

use App\Data\CommentData;
use App\Models\Comment;
use App\Repositories\Interfaces\CommentContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\LaravelData\PaginatedDataCollection;
use Spatie\QueryBuilder\QueryBuilder;

class CommentRepository implements CommentContract
{
    public function paginateFilter(Model $model): LengthAwarePaginator
    {
        $comments = QueryBuilder::for(Comment::class)
            ->whereMorphedTo('commentable', $model->getMorphClass())
            ->where('commentable_id', $model->id)
            ->with('user')
            ->allowedFilters([
                'text',
                'user.name',
                'user.email',
                'user.id',
            ])
            ->paginate(request('per_page'));

        return CommentData::collect($comments);
    }

    public function find(int $id): ?CommentData
    {
        return CommentData::from(
            Comment::with('user')->find($id)
        );
    }
}
