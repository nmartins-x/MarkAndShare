<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Auth;
use Socialite;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OAuthTest extends TestCase {

    use RefreshDatabase;

    /**
     * @test
     */
    public function testSocialiteTwitterLogin() {
        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');

        $abstractUser
                ->shouldReceive('getId')
                ->andReturn(rand())
                ->shouldReceive('getNickName')
                ->andReturn('uniqid()')
                ->shouldReceive('getName')
                ->andReturn('uniqid()')
                ->shouldReceive('getEmail')
                ->andReturn(uniqid() . '@gmail.com')
                ->shouldReceive('getAvatar')
                ->andReturn('https://en.gravatar.com/userimage');

        Socialite::shouldReceive('driver->user')->andReturn($abstractUser);

        $this->get(route('SocialiteCallback', ['provider' => 'twitter']))
                ->assertStatus(302)
                ->assertRedirect(route('home'));
    }

}
