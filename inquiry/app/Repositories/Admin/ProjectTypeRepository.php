<?php

namespace App\Repositories\Admin;

use App\Models\ProjectType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProjectTypeRepository
 * @package App\Repositories\Admin
 * @version March 13, 2019, 3:28 pm UTC
 *
 * @method ProjectType findWithoutFail($id, $columns = ['*'])
 * @method ProjectType find($id, $columns = ['*'])
 * @method ProjectType first($columns = ['*'])
 */
class ProjectTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'project_id',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProjectType::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
//        $input = $request->all();
        $projectType = $this->create($request);
        return $projectType;
    }

    /**
     * @param $request
     * @param $projectType
     * @return mixed
     */
    public function updateRecord($request, $projectType)
    {
//        $input = $request->all();
        $projectType = $this->update($request, $projectType->id);
        return $projectType;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $projectType = $this->delete($id);
        return $projectType;
    }

    public function projecttype($request)
    {
        if ($request->describe == 1) {
            return 'Fix a bug';
        }

        if ($request->describe == 2) {
            return 'Install/Integrate Software';
        }

        if ($request->describe == 3) {
            return 'Develop website from scratch';
        }

        if ($request->describe == 4) {
            return 'Create a landing page';
        }

        if ($request->describe == 5) {
            return $request->othertext;
        }
    }

    public function projectwork($request)
    {
        $feature = [];
        if ($request->designer != null) {
            $feature['designer'] = 'Designing';
        }

        if ($request->developer !== null) {
            $feature['developer'] = 'Developing';
        }

        if ($request->project_manager !== null) {
            $feature['pm'] = 'Project Managment';
        }

        if ($request->analyst !== null) {
            $feature['an'] = 'Business Analysation';
        }

        if ($request->qa !== null) {
            $feature['qa'] = 'QA (Quality Assurance)';
        }
        if ($request->other !== null) {
            $feature['other'] = 'Other';
        }
        return $feature;
    }

    public function api($request)
    {
        $api = [];
        if ($request->paypal != null) {
            $api['paypal'] = 'Paypal';
        }
        if ($request->cloud != null) {
            $api['cloud'] = 'Cloud';
        }

        if ($request->social != null) {
            $api['social'] = 'Social';
        }
        if ($request->otherapi != null) {
            $api['otherapi'] = 'Other Api';
        }
        return $api;
    }

    public function budgettype($request)
    {
        $api = [];
        if ($request->type != null) {
            $api['paypal'] = 'Paypal';
        }
        if ($request->cloud != null) {
            $api['cloud'] = 'Cloud';
        }

        if ($request->social != null) {
            $api['social'] = 'Social';
        }
        if ($request->otherapi != null) {
            $api['otherapi'] = 'Other Api';
        }
        return $api;
    }

    public function stage($request)
    {
        $api = [];
        if ($request->specification != null) {
            $api['concept'] = $request->specification;
        }
        if ($request->concept != null) {
            $api['concept'] = $request->concept;
        }

        return $api;

    }
}
