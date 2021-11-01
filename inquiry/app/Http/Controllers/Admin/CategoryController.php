<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\CategoryDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Repositories\Admin\CategoryRepository;
use App\Http\Controllers\AppBaseController;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

class CategoryController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
        $this->ModelName = 'categories';
        $this->BreadCrumbName = 'Categories';
    }

    /**
     * Display a listing of the Category.
     *
     * @param CategoryDataTable $categoryDataTable
     * @return Response
     */
    public function index(CategoryDataTable $categoryDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $categoryDataTable->render('admin.categories.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.categories.create')->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = $this->categoryRepository->saveRecord($request);

        Flash::success($this->BreadCrumbName . ' saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.categories.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.categories.edit', $category->id));
        } else {
            $redirect_to = redirect(route('admin.categories.index'));
        }
        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.categories.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $category);
        return view('admin.categories.show')->with(['category' => $category, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.categories.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $category);
        return view('admin.categories.edit')->with(['category' => $category, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  int              $id
     * @param UpdateCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.categories.index'));
        }

        $category = $this->categoryRepository->updateRecord($request, $category);

        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.categories.create'));
        } else {
            $redirect_to = redirect(route('admin.categories.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.categories.index'));
        }

        $this->categoryRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.categories.index'))->with(['title' => $this->BreadCrumbName]);
    }
}
