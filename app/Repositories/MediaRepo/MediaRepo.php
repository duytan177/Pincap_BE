<?php

namespace App\Repositories\MediaRepo;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use TimWassenburg\RepositoryGenerator\Repository\BaseRepository;

/**
 * Class MediaRepo.
 */
class MediaRepo extends BaseRepository implements MediaRepoInterface
{
    /**
     * UserRepository constructor.

     */
    protected $media;
    public function __construct(Media $model)
    {
        $this->media = $model;
        parent::__construct($model);
    }

    public function all(array $paramsSelect = ['*'],array $condition=[]): Collection
    {

        return parent::all($paramsSelect,$condition); // TODO: Change the autogenerated stub
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

    public function allWhere(array $params = []): Collection
    {
        return $this->media->where($params)->get();
    }
}