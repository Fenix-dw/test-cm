<?php

namespace App\Repositories\Interfaces;

use App\Data\CommentData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\LaravelData\PaginatedDataCollection;

interface CommentContract
{
    public function paginateFilter(Model $model) : LengthAwarePaginator;
    public function find(int $id) : ?CommentData;
}
