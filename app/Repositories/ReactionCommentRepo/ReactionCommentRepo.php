<?php

namespace App\Repositories\ReactionCommentRepo;

use App\Models\ReactionComment;
use TimWassenburg\RepositoryGenerator\Repository\BaseRepository;

/**
 * Class ReactionCommentRepo.
 */
class ReactionCommentRepo extends BaseRepository implements ReactionCommentRepoInterface
{
    /**
     * UserRepository constructor.
     */
    public function __construct(ReactionComment $model)
    {
        parent::__construct($model);
    }
}
