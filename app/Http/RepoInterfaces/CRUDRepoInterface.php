<?php

namespace App\Http\RepoInterfaces;
use Illuminate\Database\Eloquent\Model;

interface CRUDRepoInterface
{
    public function create($modelDetails);
    public function getAll();
    public function getById($id);
    public function update($id, $modelDetails);
    public function delete($id);

}
