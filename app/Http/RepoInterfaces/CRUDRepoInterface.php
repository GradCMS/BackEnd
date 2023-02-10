<?php

namespace App\Http\RepoInterfaces;
use Illuminate\Database\Eloquent\Model;

interface CRUDRepoInterface
{
    public function getAll();
    public function getById($id);
    public function delete($id);
    public function create(array $modelDetails);
    public function update($id, array $modelDetails);

}
