<?php

use Faker\Factory as Faker;
use App\Models\ProjectType;
use App\Repositories\Admin\ProjectTypeRepository;

trait MakeProjectTypeTrait
{
    /**
     * Create fake instance of ProjectType and save it in database
     *
     * @param array $projectTypeFields
     * @return ProjectType
     */
    public function makeProjectType($projectTypeFields = [])
    {
        /** @var ProjectTypeRepository $projectTypeRepo */
        $projectTypeRepo = App::make(ProjectTypeRepository::class);
        $theme = $this->fakeProjectTypeData($projectTypeFields);
        return $projectTypeRepo->create($theme);
    }

    /**
     * Get fake instance of ProjectType
     *
     * @param array $projectTypeFields
     * @return ProjectType
     */
    public function fakeProjectType($projectTypeFields = [])
    {
        return new ProjectType($this->fakeProjectTypeData($projectTypeFields));
    }

    /**
     * Get fake data of ProjectType
     *
     * @param array $postFields
     * @return array
     */
    public function fakeProjectTypeData($projectTypeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'project_id' => $fake->word,
            'type' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $projectTypeFields);
    }
}
