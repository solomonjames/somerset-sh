<?php

namespace Database\Seeders;

use App\Models\ShortUrl;
use Illuminate\Database\Seeder;

class ShortUrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShortUrl::factory()
            ->count(100)
            ->visits()
            ->create();

        ShortUrl::factory()
            ->count(100)
            ->create();
    }
}
