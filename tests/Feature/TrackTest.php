<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class TrackTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    protected bool $seed = true;

    /** @test */
    public function test_all_tracks_without_auth()
    {
        $this->seed(DatabaseSeeder::class);
        $response = $this->get_all_tracks();
        dd($response);

        $response->assertStatus(500);
    }

    /** @test */
    public function test_all_tracks_with_correct_auth()
    {
        $this->seed(DatabaseSeeder::class);
        $headers = ['Authorization'=>'Bearer '.$this->register_user(), 'Accept' => 'application/json'];
        $response = $this->get_all_tracks($headers);

        $response->assertJsonStructure([
            'tracks' => [
              '*' => [
                "id",
                "username",
                "avatar",
                "total_distance",
                "total_time",
                "date",
                "last_likes"
              ]
            ],
            'pagination'

          ]);
        $response->assertStatus(200);
    }

    private function get_all_tracks(array $headers = [])
    {
        return $this->withHeaders($headers)->get('api/tracks');
    }

    private function register_user()
    {
        $body = [
            "username" => "user_test",
            "avatar" => "https://via.placeholder.com/640x480.png/00cc11?text=consequatur",
            "token" => "123456789abcdef"
        ];
        $response = $this->post('/api/register', $body);

        return $response->getData()->access_token;
    }
}
