<?php

namespace App\Repositories\Role;
use App\Models\Role;
use App\Models\Module;
use App\Models\Permission;
use App\Repositories\BaseRepository;


class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    protected $select = [];

    public function getModel()
    {
        return Role::class;
    }


    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function getAllPermissions()
    {
        return Permission::all();
    }

    public function getAllPermissionsNoModule()
    {
        return Permission::all()->whereNull('module_id');
    }

    public function getAllModules()
    {
        return Module::orderBy('id', 'DESC')->get();
    }

    public function getAllPermissionsInAllModules()
    {
        $arrModule = Module::orderBy('id', 'DESC')->get();
        foreach ($arrModule as $module) {
            $permssionsList[$module->id]['module_name'] = $module->name;
            $permssionsList[$module->id]['list'] = Permission::where('module_id', $module->id)->get();
        }
        return $permssionsList;
    }
}
