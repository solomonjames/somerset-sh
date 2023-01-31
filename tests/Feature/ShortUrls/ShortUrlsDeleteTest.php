<?php

namespace Tests\Feature\ShortUrls;

use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortUrlsDeleteTest extends TestCase
{
    use RefreshDatabase;

    private const DELETE_URL = '/api/short-urls/';
    private const ARCHIVED_INDEX_URL = '/api/archived-short-urls';

    public function test_expect_no_content_when_successfully_deleted()
    {
        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::factory()->create();

        $response = $this->deleteJson(self::DELETE_URL . $shortUrl->short_code);

        $response->assertStatus(204);
    }

    public function test_expect_archived_short_url_when_successfully_deleted()
    {
        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::factory()->create();

        $this->deleteJson(self::DELETE_URL . $shortUrl->short_code);

        $response = $this->getJson(self::ARCHIVED_INDEX_URL);
        $response->assertJsonPath('data.0.short_code', $shortUrl->short_code);
    }
}
