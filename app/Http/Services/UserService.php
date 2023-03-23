<?php

namespace App\Http\Services;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Models\User;
use App\Traits\DTOBuilder;
use Illuminate\Support\Arr;
use function Symfony\Component\String\b;


class UserService
{
    use DTOBuilder;
    private $registry;
    private $userRepo;
    public function __construct(RepoRegisteryInterface $repoRegistery)
    {
        $this->registry = $repoRegistery->getInstance();
        $this->userRepo = $this->registry->get('user');
    }

    public function createUser($userData)
    {
        $userDTO = $this->createDTO($userData);

        return $this->userRepo->create($userDTO);
    }
    public function getAllUsers()
    {
        return $this->userRepo->getAll();
    }
    public function deleteUser($id): void
    {
        $this->userRepo->delete($id);
    }

    public function updateUser($id, $userData): User
    {
        $userDTO = $this->createDTO($userData);

        return $this->userRepo->update($id, $userDTO);
    }

    public function createDTO($userData):ModelDTO
    {
        $fillableKeys = ['user_name', 'email'];
        $nonFillableKeys = ['password', 'role'];

        $dto = $this->buildDTO($fillableKeys, $nonFillableKeys, $userData);

        // post-processing for DTO
        if(isset($dto->getNonFillable()['password'])){

            $dto->getNonFillable()['password'] = $this->encryptPassword( $dto->getNonFillable()['password']);
        }

        return $dto;
    }

    public function encryptPassword($password): string
    {
        return bcrypt($password);
    }

}
