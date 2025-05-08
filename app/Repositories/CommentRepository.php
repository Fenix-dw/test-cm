<?php

namespace App\Repositories;

use App\Data\CommentData;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class CommentRepository extends CoreRepository
{

    protected function getModelClass(): string
    {
        return Comment::class;
    }

    public function paginateFilter(Model $model, int $perPage = null): LengthAwarePaginator
    {
        return QueryBuilder::for(Comment::class)
            ->whereMorphedTo('commentable', $model->getMorphClass())
            ->where('commentable_id', $model->id)
            ->with('user')
            ->allowedFilters([
                'text',
                'user.name',
                'user.email',
                'user.id',
            ])
            ->paginate($perPage);
    }

    public function find(int $id) : ?Comment
    {
        return $this->startConditions()
            ->with('user')
            ->find($id);
    }
}
