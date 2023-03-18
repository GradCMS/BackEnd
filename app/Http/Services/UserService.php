<?php

namespace App\Http\Services;

use App\DTOs\ModelCreationDTO;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Models\User;
use Illuminate\Support\Arr;


class UserService
{
    private $registry;
    private $userRepo;
    public function __construct(RepoRegisteryInterface $repoRegistery)
    {
        $this->registry = $repoRegistery->getInstance();
        $this->userRepo = $this->registry->get('user');
    }

    public function createUser($userData)
    {
        $fillableData = Arr::only($userData, ['user_name', 'email']);
        $nonFillableData = Arr::only($userData, ['password']);

        $nonFillableData['password'] = bcrypt($nonFillableData['password']);

        $userDTO = new ModelCreationDTO($fillableData, $nonFillableData);

        return $this->userRepo->create($userDTO);
    }


}
