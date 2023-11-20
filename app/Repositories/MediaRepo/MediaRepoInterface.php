<?php

namespace App\Repositories\MediaRepo;

use Illuminate\Support\Collection;

interface MediaRepoInterface
{
   // Extend with your methods
    public function allWhere(array $params = []): Collection;
}
