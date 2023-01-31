<?php

namespace Tests\Feature\ShortUrls;

use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShortUrlsUpdateTest extends TestCase
{
    use RefreshDatabase;

    private const UPDATE_URL = '/api/short-urls/';

    private const ARCHIVED_INDEX_URL = '/api/archived-short-urls';

    public function test_expect_hit_counts_to_reset_when_updating_existing_short_url()
    {
        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::factory()->visits()->create();

        $this->assertNotEquals(0, $shortUrl->unique_hits);
        $this->assertNotEquals(0, $shortUrl->total_hits);

        $response = $this->putJson(self::UPDATE_URL.$shortUrl->short_code, ['long_url' => 'https://google.com']);

        $response->assertStatus(200)
            ->assertJsonPath('data.unique_hits', 0)
            ->assertJsonPath('data.total_hits', 0);
    }

    public function test_expect_short_url_to_be_archived_when_updating_existing_short_url()
    {
        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::factory()->visits()->create();

        $updateResponse = $this->putJson(self::UPDATE_URL.$shortUrl->short_code, ['long_url' => 'https://google.com']);
        $updateResponse->assertStatus(200);

        $archivedResponse = $this->getJson(self::ARCHIVED_INDEX_URL);
        $archivedResponse->assertStatus(200)
            ->assertJsonPath('data.0.long_url', $shortUrl->long_url)
            ->assertJsonPath('data.0.unique_hits', $shortUrl->unique_hits)
            ->assertJsonPath('data.0.total_hits', $shortUrl->total_hits);
    }

    public function test_expect_long_url_error_when_passing_invalid_scheme()
    {
        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::factory()->create();

        $response = $this->putJson(self::UPDATE_URL.$shortUrl->short_code, ['long_url' => 'ws://google.com']);

        $response
            ->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) => $json->has('message')
                    ->has('errors.long_url')
            );
    }

    public function test_expect_required_error_when_missing_long_url()
    {
        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::factory()->create();

        $response = $this->putJson(self::UPDATE_URL.$shortUrl->short_code);

        $response
            ->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) => $json->has('message')
                    ->has('errors.long_url')
            );
    }

    public function test_expect_length_error_when_long_url_is_too_long()
    {
        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::factory()->create();

        $response = $this->putJson(self::UPDATE_URL.$shortUrl->short_code, [
            'long_url' => str('http://google.com/?test=')->padRight(600, 'p')->toString(),
        ]);

        $response
            ->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) => $json->has('message')
                    ->has('errors.long_url')
            );
    }

    public function test_expect_no_change_when_passing_identical_long_url()
    {
        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::factory()->create();

        $response = $this->putJson(self::UPDATE_URL.$shortUrl->short_code, ['long_url' => $shortUrl->long_url]);
        $response->assertStatus(200);

        $this->assertEquals($shortUrl->long_url, $response->json('data.long_url'));
    }
}
