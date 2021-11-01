<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Util;
use App\Http\Requests\Admin\CreatePermissionRequest;
use App\Http\Requests\Admin\UpdatePermissionRequest;
use App\Models\Menu;
use App\Models\Module;
use App\Repositories\Admin\PermissionRepository;
use App\DataTables\Admin\PermissionDataTable;
use App\Http\Controllers\AppBaseController;
use App\Helper\BreadcrumbsRegister;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;

/**
 * Class PermissionController
 * @package App\Http\Controllers\Admin
 */
class PermissionController extends AppBaseController
{
    /** @var  PermissionRepository */
    private $permissionRepository;

    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /**
     * PermissionController constructor.
     * @param PermissionRepository $permissionRepo
     */
    public function __construct(PermissionRepository $permissionRepo)
    {
        $this->permissionRepository = $permissionRepo;
        $this->ModelName = 'permissions';
        $this->BreadCrumbName = 'Permission';
    }

    /**
     * Display a listing of the Permission.
     *
     * @param PermissionDataTable $permissionDataTable
     * @return Response
     */
    public function index(PermissionDataTable $permissionDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $permissionDataTable->render('admin.permissions.index');
    }

    /**
     * Show the form for creating a new Permission.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created Permission in storage.
     *
     * @param CreatePermissionRequest $request
     *
     * @return Response
     */
    public function store(CreatePermissionRequest $request)
    {
        $util = new Util();

        //region Create Module

        $data['table_name'] = '-';
        $data['name'] = $request->module;
        $data['icon'] = 'fa fa-' . $request->icon;
        $data['slug'] = str_plural($request->slug);
        $data['is_module'] = Module::NOT_A_MODULE;

        $module = Module::create($data);

        array_splice($data, 0, 0, ['id' => $module->id]);

        #update csv
        $util->updateCSV('modules_seeder.csv', [$data]);

        //endregion

        if ($request->add_menu == 1) {
            //region Create Menu
            $newMenu = [
                'name'         => ucwords(str_replace("-", " ", $module->slug)),
                'module_id'    => $module->id,
                'icon'         => $module->icon,
                'slug'         => str_plural($module->slug),
                'position'     => Menu::max('position') + 1,
                'is_protected' => 0,
                'static'       => 1,
                'status'       => 1
            ];

            Menu::create($newMenu);

            #update csv
            $util->updateCSV('menus_seeder.csv', [$newMenu]);
            //endregion
        }
        $permission = $this->permissionRepository->saveRecord($request, $module);

        Flash::success('Permission saved successfully.');
        return redirect(route('admin.permissions.index'));
    }

    /**
     * Display the specified Permission.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $permission = $this->permissionRepository->findWithoutFail($id);

        if (empty($permission)) {
            Flash::error('Permission not found');
            return redirect(route('admin.permissions.index'));
        }
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $permission);
        return view('admin.permissions.show')->with('permission', $permission);
    }

    /**
     * Show the form for editing the specified Permission.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $permission = $this->permissionRepository->findWithoutFail($id);

        if (empty($permission)) {
            Flash::error('Permission not found');
            return redirect(route('admin.permissions.index'));
        }
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $permission);
        return view('admin.permissions.edit')->with('permission', $permission);
    }

    /**
     * Update the specified Permission in storage.
     *
     * @param  int $id
     * @param UpdatePermissionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePermissionRequest $request)
    {
        $permission = $this->permissionRepository->findWithoutFail($id);

        if (empty($permission)) {
            Flash::error('Permission not found');
            return redirect(route('admin.permissions.index'));
        }

        $permission = $this->permissionRepository->update($request->all(), $id);

        Flash::success('Permission updated successfully.');
        return redirect(route('admin.permissions.index'));
    }

    /**
     * Remove the specified Permission from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $permission = $this->permissionRepository->findWithoutFail($id);
        if (empty($permission)) {
            Flash::error('Permission not found');
            return redirect(route('admin.permissions.index'));
        }

        if ($permission->is_protected == 1) {
            Flash::error('You are not allowed to perform this action.');
            return redirect(route('admin.permissions.index'));
        }

        $this->permissionRepository->delete($id);

        Flash::success('Permission deleted successfully.');
        return redirect(route('admin.permissions.index'));
    }
}