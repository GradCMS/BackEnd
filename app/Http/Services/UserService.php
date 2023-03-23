<?php

namespace App\Http\Services;

use App\DTOs\ModelCreationDTO;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Models\User;
use Illuminate\Support\Arr;
use function Symfony\Component\String\b;


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
        $userDTO = $this->DTOBuilder($userData);

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
        $userDTO = $this->DTOBuilder($userData);

        return $this->userRepo->update($id, $userDTO);
    }

    public function DTOBuilder($userData):ModelCreationDTO
    {
        $fillableKeysToCopy = ['user_name', 'email'];

        $nonFillableKeysToCopy = ['password', 'role'];

        $fillableData =[];
        $nonFillableData = [];

        foreach ($fillableKeysToCopy as $key)  // dynamically build the fillable array based on user input
        {
            if(isset($userData[$key]))
            {
                $fillableData[$key] = $userData[$key];
            }
        }

        foreach ($nonFillableKeysToCopy as $key)
        {
            if(isset($userData[$key]))
            {
                $nonFillableData[$key] = $userData[$key];
            }
        }

        if(isset($nonFillableData['password'])){

            $nonFillableData['password'] = $this->encryptPassword( $nonFillableData['password']);
        }

        return new ModelCreationDTO($fillableData, $nonFillableData);
    }

    public function encryptPassword($password): string
    {
        return bcrypt($password);
    }

}
