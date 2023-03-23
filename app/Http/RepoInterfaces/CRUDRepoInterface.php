<?php

namespace App\Http\RepoInterfaces;
use App\DTOs\ModelCreationDTO;
use Illuminate\Database\Eloquent\Model;

interface CRUDRepoInterface
{
    public function create(ModelCreationDTO $modelDTO);
    public function getAll();
    public function getById($id);
    public function update($id, ModelCreationDTO $modelDTO);
    public function delete($id);

}
