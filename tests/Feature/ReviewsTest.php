<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Reviews;

class ReviewsTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        (new \DatabaseSeeder())->run();
    }

    public function testIndex()
    {
        $response = $this->get('/api/reviews');
        $response->assertStatus(200);
        $this->assertCount(6, $response->json());
    }

    public function testShow()
    {
        $response = $this->get('/api/reviews/1');
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $data = [
            'deal_user_id' => 2,
            'evaluate_star' => 4,
            'review' => 'よかったです。',
        ];
        $response = $this->post('/api/reviews', $data);
        $response->assertStatus(201);
        $response->assertJson($data);
        $review = Reviews::query()->find($response->json()['id']);
        $this->assertInstanceOf(Reviews::class, $review);
    }
}
