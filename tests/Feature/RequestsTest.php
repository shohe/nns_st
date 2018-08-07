<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Requests;

class RequestsTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        (new \DatabaseSeeder())->run();
    }

    public function testIndex()
    {
        $response = $this->get('/api/requests');
        $response->assertStatus(200);
        $this->assertCount(6, $response->json());
    }

    public function testShow()
    {
        $response = $this->get('/api/requests/1');
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $data = [
            'offer_id' => 1,
            'price' => 4000,
            'comment' => 'リクエストテストコメント'
        ];
        $response = $this->post('/api/requests', $data);
        $response->assertStatus(201);
        $response->assertJson($data);
        $request = Requests::query()->find($response->json()['id']);
        $this->assertInstanceOf(Requests::class, $request);
    }

    public function testUpdateIsMatched()
    {
        $data = ['is_matched' => true];
        $response = $this->patch('/api/requests/1', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
        $request = Requests::query()->find(1);
        $this->assertEquals(true, $request->is_matched);
    }
}
