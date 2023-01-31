<?php

namespace Tests\Feature;

use App\Jobs\HandleShortUrlVisit;
use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class RedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_expect_404_when_short_code_doesnt_exist()
    {
        $response = $this->get('/IDONTEXIST');

        $response->assertStatus(404);
    }

    public function test_expect_a_redirect_when_using_valid_short_code()
    {
        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::factory()->create();

        $response = $this->get(sprintf('/%s', $shortUrl->short_code));
        $response->assertRedirect($shortUrl->long_url);
    }

    public function test_expect_visit_job_dispatched_when_using_valid_short_code()
    {
        Bus::fake();

        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::factory()->create();

        $this->get(sprintf('/%s', $shortUrl->short_code));

        Bus::assertDispatched(HandleShortUrlVisit::class);
    }

    public function test_expect_visit_to_be_unique_when_first_hit_to_short_code()
    {
        Bus::fake();

        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::factory()->create();

        $this->get(sprintf('/%s', $shortUrl->short_code));

        Bus::assertDispatched(HandleShortUrlVisit::class, static fn (HandleShortUrlVisit $event) => $event->isUnique);
    }

    public function test_expect_visit_to_not_be_unique_when_already_hit_the_short_code()
    {
        Bus::fake();

        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::factory()->create();

        $this->withSession([
            $shortUrl->short_code => 1
        ])->get(sprintf('/%s', $shortUrl->short_code));

        Bus::assertDispatched(HandleShortUrlVisit::class, static fn (HandleShortUrlVisit $event) => ! $event->isUnique);
    }

    public function test_expect_visit_to_increment_both_hits_when_first_hit_to_short_code()
    {
        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::factory()->create();
        $originalTotalHits = $shortUrl->total_hits;
        $originalUniqueHits = $shortUrl->unique_hits;

        $this->get(sprintf('/%s', $shortUrl->short_code));

        $this->assertEquals($originalTotalHits + 1, $shortUrl->refresh()->total_hits);
        $this->assertEquals($originalUniqueHits + 1, $shortUrl->refresh()->unique_hits);
    }

    public function test_expect_visit_to_increment_total_hits_when_already_hit_the_short_code()
    {
        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::factory()->create();
        $originalTotalHits = $shortUrl->total_hits;

        $this->withSession([
            $shortUrl->short_code => 1
        ])->get(sprintf('/%s', $shortUrl->short_code));

        $this->assertEquals($originalTotalHits + 1, $shortUrl->refresh()->total_hits);
    }
}
