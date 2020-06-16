<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Socialite\Facades\Socialite;
use \Mockery;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    /**
    * @test
    */    
    public function test_user_can_view_a_login_form()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }
    
    /**
    * @test
    */
    function testUserCanAuthenticate()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->assertAuthenticatedAs($user);
    }
    
    /**
    * @test
    */
    public function register_creates_and_authenticates_a_user()
    {
        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $password = $this->faker->password(8);

        $response = $this->post('register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertRedirect(route('home'));

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email
        ]);
    }
    
    /**
    * @test
    */
    public function index_returns_a_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertStatus(200);
    }
}
