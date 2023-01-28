<?php

namespace Database\Factories;

use App\Actions\ShortCodeGeneratorAction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShortUrl>
 */
class ShortUrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'short_code' => app(ShortCodeGeneratorAction::class)->execute(),
            'long_url' => $this->faker->url(),
        ];
    }

    public function visits()
    {
        return $this->state(function (array $attributes) {
            $totalHits = random_int(1, 1000000);

            return [
                'unique_hits' => random_int(1, $totalHits),
                'total_hits' => $totalHits,
            ];
        });
    }
}
