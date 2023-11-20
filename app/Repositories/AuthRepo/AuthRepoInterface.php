<?php

namespace App\Repositories\AuthRepo;

interface AuthRepoInterface
{
   // Extend with your methods
    public function login(array $userData);
    public function register(array $data);
    public function logout();

}
