<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Offers;

class OffersTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        (new \DatabaseSeeder())->run();
    }

    public function testIndex()
    {
        $response = $this->get('/api/offers');
        $response->assertStatus(200);
        $this->assertCount(6, $response->json());
    }

    public function testShow()
    {
        $response = $this->get('/api/offers/1');
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $data = [
            'menu' => 'カット',
            'price' => 4500,
            'date_time' => '2014-08-01 23:01:05',
            'distance_range' => 3,
            'user_location' => ['lat' => 34.6835522,'lng' => 135.4976581],
            'hair_type' => 1,
            'comment' => 'よろしくお願いします。',
            'charity_id' => 1,
        ];
        $response = $this->post('/api/offers', $data);
        $response->assertStatus(201);
        // $response->assertJson($data);
        $offer = Offers::query()->find($response->json()['id']);
        $this->assertInstanceOf(Offers::class, $offer);
    }

    public function testUpdateIsClosed()
    {
        $data = ['is_closed' => true];
        $response = $this->patch('/api/offers/1', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
        $offer = Offers::query()->find(1);
        $this->assertEquals(true, $offer->is_closed);
    }
}
