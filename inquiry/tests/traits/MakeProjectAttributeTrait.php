<?php

use Faker\Factory as Faker;
use App\Models\ProjectAttribute;
use App\Repositories\Admin\ProjectAttributeRepository;

trait MakeProjectAttributeTrait
{
    /**
     * Create fake instance of ProjectAttribute and save it in database
     *
     * @param array $projectAttributeFields
     * @return ProjectAttribute
     */
    public function makeProjectAttribute($projectAttributeFields = [])
    {
        /** @var ProjectAttributeRepository $projectAttributeRepo */
        $projectAttributeRepo = App::make(ProjectAttributeRepository::class);
        $theme = $this->fakeProjectAttributeData($projectAttributeFields);
        return $projectAttributeRepo->create($theme);
    }

    /**
     * Get fake instance of ProjectAttribute
     *
     * @param array $projectAttributeFields
     * @return ProjectAttribute
     */
    public function fakeProjectAttribute($projectAttributeFields = [])
    {
        return new ProjectAttribute($this->fakeProjectAttributeData($projectAttributeFields));
    }

    /**
     * Get fake data of ProjectAttribute
     *
     * @param array $postFields
     * @return array
     */
    public function fakeProjectAttributeData($projectAttributeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'instance_id' => $fake->word,
            'instance_type' => $fake->word,
            'content' => $fake->text,
            'amount' => $fake->word,
            'attachment' => $fake->text,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $projectAttributeFields);
    }
}
