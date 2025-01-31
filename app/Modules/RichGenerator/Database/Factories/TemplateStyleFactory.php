<?php

namespace App\Modules\RichGenerator\Database\Factories;

use App\Modules\RichGenerator\Models\TemplateStyle;
use Illuminate\Database\Eloquent\Factories\Factory;

class TemplateStyleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TemplateStyle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $data = [];

        foreach (config('delta.supportedLocales') as $key => $value) {
            $data['title'][$key] = $this->faker->sentence;
        }

        return $data;
    }
}
