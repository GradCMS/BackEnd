<?php
namespace App\Http\Repository;

use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
/**
 * Post
 *
 * @mixin Builder
 */
class PageRepo implements CRUDRepoInterface{


    public function getAll()
    {
        // TODO: Implement getAll() method.
        return Page::all();
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
        return Page::Query()->findOrFail($id);

    }

    public function delete($id): int
    {
        // TODO: Implement delete() method.
        return Page::destroy($id);
    }

    public function create(array $modelDetails)
    {
        // TODO: Implement create() method.
        return Page::Query()->create($modelDetails);
    }

    public function update($id, array $modelDetails): int
    {
        // TODO: Implement update() method.
        return Page::Query()->where($id)->update($modelDetails);
    }
}
