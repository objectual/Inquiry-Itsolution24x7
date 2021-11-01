<?php

use Faker\Factory as Faker;
use App\Models\Description;
use App\Repositories\Admin\DescriptionRepository;

trait MakeDescriptionTrait
{
    /**
     * Create fake instance of Description and save it in database
     *
     * @param array $descriptionFields
     * @return Description
     */
    public function makeDescription($descriptionFields = [])
    {
        /** @var DescriptionRepository $descriptionRepo */
        $descriptionRepo = App::make(DescriptionRepository::class);
        $theme = $this->fakeDescriptionData($descriptionFields);
        return $descriptionRepo->create($theme);
    }

    /**
     * Get fake instance of Description
     *
     * @param array $descriptionFields
     * @return Description
     */
    public function fakeDescription($descriptionFields = [])
    {
        return new Description($this->fakeDescriptionData($descriptionFields));
    }

    /**
     * Get fake data of Description
     *
     * @param array $postFields
     * @return array
     */
    public function fakeDescriptionData($descriptionFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'project_id' => $fake->word,
            'details' => $fake->text,
            'attachment' => $fake->text,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $descriptionFields);
    }
}
