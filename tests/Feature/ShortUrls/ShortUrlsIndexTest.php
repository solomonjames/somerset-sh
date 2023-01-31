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

    public function test_expect_empty_data_when_there_are_no_short_urls()
    {
        $response = $this->getJson(self::INDEX_URL);

        $response
            ->assertStatus(200)
            ->assertJsonPath('data', []);
    }

    public function test_expect_data_to_contain_records_when_short_urls_exist()
    {
        ShortUrl::factory()->count(2)->create();

        $response = $this->getJson(self::INDEX_URL);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->has('data', 2)->etc());
    }
}
