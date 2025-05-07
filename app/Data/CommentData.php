<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class CommentData extends Data
{

    public function __construct(
        public int $id,
        public int $userId,
        public ?UserData $user,
        public string $commentableType,
        public int $commentableId,
        public string $text,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    )
    {
    }
}
