<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $user_repo;

    public function __construct( UserRepository $user_repo )
    {
        $this->user_repo = $user_repo;
    }

    public function findUserByEmail( string $email ) : ?User
    {
        return $this->user_repo->findByEmail( $email );
    }
}