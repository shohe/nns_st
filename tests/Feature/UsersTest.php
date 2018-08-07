<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Users;

class UsersTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        (new \DatabaseSeeder())->run();
    }

    public function testIndex()
    {
        $response = $this->get('/api/users');
        $response->assertStatus(200);
        $this->assertCount(12, $response->json());
    }

    public function testShow()
    {
        $response = $this->get('/api/users/1');
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $data = [
            'last_name' => 'Walton',
            'first_name' => 'Doris',
            'email' => 'doris.walton@example.com',
            'password' => bcrypt('password')
        ];
        $response = $this->post('/api/users', $data);
        $response->assertStatus(201);
        $response->assertJson($data);
        $user = Users::query()->find($response->json()['id']);
        $this->assertInstanceOf(Users::class, $user);
    }

    public function testUpdateName()
    {
        $data = ['last_name' => 'testlast', 'first_name' => 'testfirst'];
        $response = $this->patch('/api/users/1', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
        $user = Users::query()->find(1);
        $this->assertSame('testlast', $user->last_name);
        $this->assertSame('testfirst', $user->first_name);
    }

    public function testUpdateEmail()
    {
        $data = ['email' => 'test@example.com'];
        $response = $this->patch('/api/users/1', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
        $user = Users::query()->find(1);
        $this->assertSame('test@example.com', $user->email);
    }

    public function testUpdatePassword()
    {
        $newpswd = bcrypt('password');
        $data = ['password' => $newpswd];
        $response = $this->patch('/api/users/1', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
        $user = Users::query()->find(1);
        $this->assertSame($newpswd, $user->password);
    }

    public function testUpdateImageUrl()
    {
        $data = ['image_url' => 'http://testcreative.co.uk/wp-content/uploads/2017/10/Test-Logo-Small-Black-transparent-1.png'];
        $response = $this->patch('/api/users/1', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
        $user = Users::query()->find(1);
        $this->assertSame('http://testcreative.co.uk/wp-content/uploads/2017/10/Test-Logo-Small-Black-transparent-1.png', $user->image_url);
    }

    public function testUpdateStatusComment()
    {
        $data = ['status_comment' => 'test comment!'];
        $response = $this->patch('/api/users/1', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
        $user = Users::query()->find(1);
        $this->assertSame('test comment!', $user->status_comment);
    }

    public function testUpdateCharityId()
    {
        $data = ['charity_id' => 1];
        $response = $this->patch('/api/users/1', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
        $user = Users::query()->find(1);
        $this->assertSame(1, $user->charity_id);
    }

    public function testUpdateIsStylist()
    {
        $data = ['is_stylist' => true];
        $response = $this->patch('/api/users/1', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
        $user = Users::query()->find(1);
        $this->assertEquals(true, $user->is_stylist);
    }

    public function testUpdateSalonName()
    {
        $data = ['salon_name' => 'update salon name'];
        $response = $this->patch('/api/users/1', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
        $user = Users::query()->find(1);
        $this->assertSame('update salon name', $user->salon_name);
    }

    public function testUpdateSalonAdress()
    {
        $data = ['salon_address' => 'update salon address'];
        $response = $this->patch('/api/users/1', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
        $user = Users::query()->find(1);
        $this->assertSame('update salon address', $user->salon_address);
    }

    public function testUpdateSalonLocation()
    {
        $data = ['salon_location' => ['lat' => 34.6835522,'lng' => 135.4976581]];
        $response = $this->patch('/api/users/1', $data);
        $response->assertStatus(200);
        $user = Users::query()->find(1);
        $this->assertSame(['lat' => '34.6835522','lng' => '135.4976581'], Users::getLocationAttribute($user->salon_location));
    }

}
