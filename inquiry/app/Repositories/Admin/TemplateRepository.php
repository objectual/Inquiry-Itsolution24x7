<?php

namespace App\Repositories\Admin;

use App\Models\Template;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TemplateRepository
 * @package App\Repositories\Admin
 * @version August 2, 2019, 11:24 am UTC
 *
 * @method Template findWithoutFail($id, $columns = ['*'])
 * @method Template find($id, $columns = ['*'])
 * @method Template first($columns = ['*'])
*/
class TemplateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'subject',
        'message'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Template::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $template = $this->create($input);
        return $template;
    }

    /**
     * @param $request
     * @param $template
     * @return mixed
     */
    public function updateRecord($request, $template)
    {
        $input = $request->all();
        $template = $this->update($input, $template->id);
        return $template;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $template = $this->delete($id);
        return $template;
    }
}
