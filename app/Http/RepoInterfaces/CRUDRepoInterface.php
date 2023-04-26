<?php

namespace App\Http\RepoInterfaces;
use App\DTOs\ModelDTO;
use Illuminate\Database\Eloquent\Model;

interface CRUDRepoInterface
{
    public function create(ModelDTO $modelDTO);
    public function getAll();
    public function getById($id);
    public function update($id, ModelDTO|array $newData);
    public function delete($id);

}
