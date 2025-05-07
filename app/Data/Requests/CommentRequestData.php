<?php

namespace App\Data\Requests;

use App\Data\UserData;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class CommentRequestData extends Data
{

    public function __construct(
        public string $text,
    )
    {
    }
}
