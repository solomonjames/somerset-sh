<?php

namespace Tests\Feature\ShortUrls;

use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShortUrlsIndexTest extends TestCase
{
    use RefreshDatabase;

    private const INDEX_URL = '/api/short-urls';

    public function test_listing_short_urls_empty_data()
    {
        $response = $this->getJson(self::INDEX_URL);

        $response
            ->assertStatus(200)
            ->assertJsonPath('data', []);
    }

    public function test_listing_short_urls_contains_data()
    {
        ShortUrl::factory()->count(2)->create();

        $response = $this->getJson(self::INDEX_URL);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->has('data', 2)->etc());
    }
}
