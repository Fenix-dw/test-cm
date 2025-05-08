<?php

namespace App\Repositories;

use App\Models\News as Model;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsRepository extends CoreRepository
{

    protected function getModelClass(): string
    {
        return Model::class;
    }

    public function getForComboBox(int $perPage = null): LengthAwarePaginator
    {
       return $this
           ->startConditions()
           ->paginate($perPage);
    }

    public function find(int $id) : ?Model
    {
        return $this->startConditions()->find($id);
    }
}
