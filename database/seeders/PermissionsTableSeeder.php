<?php

namespace Database\Seeders;

use App\DTOs\ModelCreationDTO;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    private $permissionRepo;
    private $registry;
    private $DTO;
    public function __construct(RepoRegisteryInterface $repoRegistery){
        $this->registry = $repoRegistery->getInstance();
        $this->permissionRepo = $this->registry->get('permission');
        $this->DTO = new ModelCreationDTO([],[]);
    }
    /**
     * Run the database seeds.
     *
     * To run the seeder:
     * php artisan db:seed --class=PermissionsTableSeeder

     * @return void
     */
    public function run()
    {

        $permissions = [
            'create posts',
            'edit posts',
            'delete posts',
            'publish posts',
            'unpublish posts',
            // Add more permissions as needed
        ];
        foreach ($permissions as $permission) {
            $this->DTO->nonFillable = ['name'=>$permission];
            $this->permissionRepo->create($this->DTO);
        }

    }
}
