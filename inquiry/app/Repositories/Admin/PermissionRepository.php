<?php

namespace App\Repositories\Admin;

use App\Helper\Util;
use App\Models\Permission;
use App\Models\Role;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PermissionRepository
 * @package App\Repositories\Admin
 * @version April 2, 2018, 1:45 pm UTC
 *
 * @method Permission findWithoutFail($id, $columns = ['*'])
 * @method Permission find($id, $columns = ['*'])
 * @method Permission first($columns = ['*'])
 */
class PermissionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'display_name',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Permission::class;
    }

    /**
     * @param $request
     * @param $module
     * @return mixed
     */
    public function saveRecord($request, $module)
    {
        $util = new Util();

        //region Crete Permission

        $data['name'] = $request->name;
        $data['module_id'] = $module->id;
        $data['display_name'] = ucwords($request->display_name);
        $data['description'] = ucwords($request->description);
        $data['is_protected'] = 0;

        /*$this->data['name'] = str_plural(lcfirst($module->name)) . '.' . $permission;
        $this->data['display_name'] = substr(join(" ", $pieces), 1);
        $this->data['description'] = ucwords($permission) . ' ' . $module->slug;*/

        $permission = $this->create($data);

        array_splice($data, 0, 0, ['id' => $permission->id]);

        #update csv
        $util->updateCSV('permissions_seeder.csv', [$data]);

        //endregion

        //region Assigning permission to super admin
        $super_admin = Role::find(Role::ROLE_SUPER_ADMIN);
        $super_admin->perms()->attach($permission->id);

        #update csv
        $permissionRoleData = [
            'permission_id' => $permission->id,
            'role_id'       => Role::ROLE_SUPER_ADMIN
        ];
        $util->updateCSV('permission_role_seeder.csv', [$permissionRoleData]);
        //endregion

        return $permission;
    }
}
