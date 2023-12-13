<?php

namespace App\Repositories\UserRepo;

use App\Models\User;
use App\Repositories\UserRepo\UserRepoInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use TimWassenburg\RepositoryGenerator\Repository\BaseRepository;

/**
 * Class UserRepo.
 */
class UserRepo extends BaseRepository implements UserRepoInterface
{

    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
        parent::__construct($user);
    }

    public function all(array $with = [],array $paramsSelect = ['*'], array $condition = []): Collection
    {
        return parent::all($with,$paramsSelect, $condition); // TODO: Change the autogenerated stub
    }

    public function paginate($limit = null, array $with = [], $columns = ['*'])
    {
        return parent::paginate($limit, $with, $columns); // TODO: Change the autogenerated stub
    }


    public function create(array $attributes): Model
    {
        return parent::create($attributes); // TODO: Change the autogenerated stub
    }

    public function delete(string $id)
    {
        return parent::delete($id); // TODO: Change the autogenerated stub
    }

    public function update(string $id, array $attributes): bool
    {
        return parent::update($id, $attributes); // TODO: Change the autogenerated stub
    }

    public function find(string $id, array $with = [], array $params = []): ?Model
    {
        return parent::find($id, $with, $params); // TODO: Change the autogenerated stub
    }

    public function findWithTrash(string $id): ?Model
    {
        return parent::findWithTrash($id); // TODO: Change the autogenerated stub
    }

    public function findByField(array $columns, string $keyword,$litmit = null, array $with = [])
    {
        return parent::findByField($columns, $keyword,$litmit, $with); // TODO: Change the autogenerated stub
    }


}
