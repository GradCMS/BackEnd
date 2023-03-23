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
        $nonFillableData = Arr::only($userData, ['password', 'role']);

        $nonFillableData['password'] = bcrypt($nonFillableData['password']);

        $userDTO = new ModelCreationDTO($fillableData, $nonFillableData);

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
            $nonFillableData['password'] = bcrypt($nonFillableData['password']);
        }


        $userDTO = new ModelCreationDTO($fillableData, $nonFillableData);

        return $this->userRepo->update($id, $userDTO);
    }

// TODO: make a function that takes $userData and $modelDTO and fills the DTO based on the $userData
        // to eleminate the duplicate code fragment in the create and update functions
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

        return new ModelCreationDTO($fillableData, $nonFillableData);
    }

}
