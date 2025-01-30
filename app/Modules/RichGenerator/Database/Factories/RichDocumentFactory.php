<?php

namespace App\Modules\RichGenerator\Database\Factories;

use Carbon\Carbon;
use App\Modules\RichGenerator\Models\RichDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

class RichDocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RichDocument::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = [];

        foreach (config('delta.supportedLocales') as $key => $value) {
            $data['title'][$key] = $this->faker->sentence;
        }

        return $data;
    }
}
