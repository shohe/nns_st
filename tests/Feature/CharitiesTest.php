<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Charities;

class CharitiesTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        (new \DatabaseSeeder())->run();
    }

    public function testIndex()
    {
        $response = $this->get('/api/charities');
        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    public function testShow()
    {
        $response = $this->get('/api/charities/1');
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $data = [
            'title' => 'test title',
            'short_detail' => 'short detail text',
            'detail_url' => 'https://detailurlexample.com',
            'thumbnail_url' => 'https://thumbnailurlexample.com'
        ];
        $response = $this->post('/api/charities', $data);
        $response->assertStatus(201);
        $response->assertJson($data);
        $charity = Charities::query()->find($response->json()['id']);
        $this->assertInstanceOf(Charities::class, $charity);
    }

    public function testUpdateThumbnail()
    {
        $data = ['thumbnail_url' => 'https://update_thumbnailurlexample.com'];
        $response = $this->patch('/api/charities/1', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
        $charity = Charities::query()->find(1);
        $this->assertSame('https://update_thumbnailurlexample.com', $charity->thumbnail_url);
    }

    public function testUpdateIsClosed()
    {
        $data = ['is_closed' => true];
        $response = $this->patch('/api/charities/1', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
        $charity = Charities::query()->find(1);
        $this->assertEquals(true, $charity->is_closed);
    }
}
