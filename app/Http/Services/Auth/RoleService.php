<?php
namespace App\Http\Services\Auth;
use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Traits\DTOBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

class RoleService{

    use DTOBuilder;
    private $roleRepo;
    private $permissionRepo;
    private  $registry;
    public function __construct(RepoRegisteryInterface $repoRegistery)
    {
        $this->registry = $repoRegistery->getInstance();
        $this->roleRepo = $this->registry->get('role');
        $this->permissionRepo = $this->registry->get('permission');
    }
    /**
     * creates a role and return a model instance
     * @param $roleData
    */
    public function createRole($roleData)
    {
        $roleDTO = $this->createDTO($roleData);

        return $this->roleRepo->create($roleDTO);
    }

    public function deleteRole($id): void
    {
         $this->roleRepo->delete($id);
    }
    public function updateRole($id, $data): Role
    {
        $roleDTO = $this->createDTO($data);

        return $this->roleRepo->update($id,$roleDTO);
    }
    public function getRole($id):Role
    {
        return $this->roleRepo->getById($id);
    }

    /**
     * get all roles
    */
    public function getAllRoles()
    {
        return $this->roleRepo->getAll();
    }

    public function createDTO($data):ModelDTO
    {
        $nonFillableKeys = ['name', 'permissions'];

        return $this->buildDTO([], $nonFillableKeys, $data);
    }

}
