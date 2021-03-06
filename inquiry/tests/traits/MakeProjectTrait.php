<?php

use Faker\Factory as Faker;
use App\Models\Project;
use App\Repositories\Admin\ProjectRepository;

trait MakeProjectTrait
{
    /**
     * Create fake instance of Project and save it in database
     *
     * @param array $projectFields
     * @return Project
     */
    public function makeProject($projectFields = [])
    {
        /** @var ProjectRepository $projectRepo */
        $projectRepo = App::make(ProjectRepository::class);
        $theme = $this->fakeProjectData($projectFields);
        return $projectRepo->create($theme);
    }

    /**
     * Get fake instance of Project
     *
     * @param array $projectFields
     * @return Project
     */
    public function fakeProject($projectFields = [])
    {
        return new Project($this->fakeProjectData($projectFields));
    }

    /**
     * Get fake data of Project
     *
     * @param array $postFields
     * @return array
     */
    public function fakeProjectData($projectFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->word,
            'category_id' => $fake->word,
            'name' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $projectFields);
    }
}
