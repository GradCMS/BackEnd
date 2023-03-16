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
class PageRepo implements CRUDRepoInterface
{


    public function getAll()
    {
        return Page::all();
    }

    public function getById($id)
    {
        return Page::Query()->findOrFail($id);
    }

    public function delete($id): int
    {
        return Page::destroy($id);
    }

    public function create($modelDetails)
    {
        return Page::Query()->create($modelDetails);
    }

    public function update($id, $modelDetails): int
    {
        return Page::Query()->where($id)->update($modelDetails);
    }

}
