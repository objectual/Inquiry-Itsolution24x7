<?php

use Faker\Factory as Faker;
use App\Models\Expertise;
use App\Repositories\Admin\ExpertiseRepository;

trait MakeExpertiseTrait
{
    /**
     * Create fake instance of Expertise and save it in database
     *
     * @param array $expertiseFields
     * @return Expertise
     */
    public function makeExpertise($expertiseFields = [])
    {
        /** @var ExpertiseRepository $expertiseRepo */
        $expertiseRepo = App::make(ExpertiseRepository::class);
        $theme = $this->fakeExpertiseData($expertiseFields);
        return $expertiseRepo->create($theme);
    }

    /**
     * Get fake instance of Expertise
     *
     * @param array $expertiseFields
     * @return Expertise
     */
    public function fakeExpertise($expertiseFields = [])
    {
        return new Expertise($this->fakeExpertiseData($expertiseFields));
    }

    /**
     * Get fake data of Expertise
     *
     * @param array $postFields
     * @return array
     */
    public function fakeExpertiseData($expertiseFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $expertiseFields);
    }
}
