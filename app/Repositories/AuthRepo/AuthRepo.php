<?php

namespace App\Repositories\AuthRepo;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use TimWassenburg\RepositoryGenerator\Repository\BaseRepository;


/**
 * Class AuthRepo.
 */
class AuthRepo extends BaseRepository implements AuthRepoInterface
{
    /**
     * UserRepository constructor.

     */
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
        parent::__construct($user);
    }
    public function login(array $userData)
    {
        return auth()->attempt($userData);
    }

    public function register(array $data)
    {
        // TODO: Implement register() method.
        $data['password'] = Hash::make($data['password']);
        return $this->user->create($data);
    }

    public function logout()
    {
        // TODO: Implement logout() method.
        return auth()->logout();
    }

}
