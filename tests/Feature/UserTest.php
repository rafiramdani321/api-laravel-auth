<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotNull;

class UserTest extends TestCase
{
    public function testRegisterSuccess()
    {
        $this->post('/api/users', [
            'username' => 'rafiramdani',
            'password' => '123123',
            'name' => 'Muhammad Rafi Ramdani'
        ])->assertStatus(201)->assertJson([
            "data" => [
                'username' => 'rafiramdani',
                'name' => 'Muhammad Rafi Ramdani'
            ]
        ]);
    }

    public function testRegisterFailed()
    {
        $this->post('/api/users', [
            'username' => '',
            'password' => '',
            'name' => ''
        ])->assertStatus(400)->assertJson([
            "errors" => [
                "username" => [
                    "The username field is required."
                ],
                "password" => [
                    "The password field is required."
                ],
                "name" => [
                    "The name field is required."
                ]
            ]
        ]);
    }

    public function testRegisterUsernameAlreadyExists()
    {
        $this->testRegisterSuccess();
        $this->post('/api/users', [
            'username' => 'rafiramdani',
            'password' => '123123',
            'name' => 'Muhammad Rafi Ramdani'
        ])->assertStatus(400)->assertJson([
            "errors" => [
                "username" => [
                    "username already registered"
                ]
            ]
        ]);
    }

    public function testLoginSuccess()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/users/login', [
            'username' => 'coba',
            'password' => 'coba',
        ])->assertStatus(200)->assertJson([
            "data" => [
                'username' => 'coba',
                'name' => 'coba'
            ]
        ]);

        $user = User::where('username', 'coba')->first();
        self::assertNotNull($user->token);
    }

    public function testLoginFailed()
    {
    }
}
