<?php

namespace Tests\Feature\ShortUrls;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShortUrlsCreateTest extends TestCase
{
    use RefreshDatabase;

    private const CREATE_URL = '/api/short-urls';

    public function test_expect_a_200_when_creating_a_valid_short_url()
    {
        $response = $this->postJson(self::CREATE_URL, ['long_url' => 'https://google.com']);

        $response->assertStatus(201);
    }

    public function test_expect_long_url_error_when_passing_invalid_scheme()
    {
        $response = $this->postJson(self::CREATE_URL, ['long_url' => 'ws://google.com']);

        $response
            ->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) => $json->has('message')
                    ->has('errors.long_url')
            );
    }

    public function test_expect_required_error_when_missing_long_url()
    {
        $response = $this->postJson(self::CREATE_URL);

        $response
            ->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) => $json->has('message')
                    ->has('errors.long_url')
            );
    }

    public function test_expect_length_error_when_long_url_is_too_long()
    {
        $response = $this->postJson(self::CREATE_URL, [
            'long_url' => str('http://google.com/?test=')->padRight(600, 'p')->toString(),
        ]);

        $response
            ->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) => $json->has('message')
                    ->has('errors.long_url')
            );
    }

    public function test_expect_no_creation_when_passing_existing_long_url()
    {
        $initialCreation = $this->postJson(self::CREATE_URL, ['long_url' => 'https://google.com']);
        $initialCreation->assertStatus(201);

        $response = $this->postJson(self::CREATE_URL, ['long_url' => 'https://google.com']);

        $response->assertStatus(200);

        $this->assertEquals($initialCreation->json('data.short_code'), $response->json('data.short_code'));
    }
}
