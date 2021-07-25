<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class GravatarTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_generate_gravatar_email_when_no_email_found_first_character_a()
    {
        $user = User::factory()->create([
            'name' => 'Markamus',
            'email' => 'makememail@fakemail.com',
        ]);
        $gravatarUrl = $user->getAvatar();
        $this->assertEquals(
            'https://www.gravatar.com/avatar/' . md5( strtolower( trim( $user->email ))) . '?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-13.png',
            $gravatarUrl
        );
        $response = Http::get($user->getAvatar());
        $this->assertTrue($response->successful());
    }
    public function test_user_can_generate_gravatar_email_when_no_email_found_first_character_z()
    {
        $user = User::factory()->create([
            'name' => 'Markamus',
            'email' => 'zakememail@fakemail.com',
        ]);
        $gravatarUrl = $user->getAvatar();
        $this->assertEquals(
            'https://www.gravatar.com/avatar/' . md5( strtolower( trim( $user->email ))) . '?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-26.png',
            $gravatarUrl
        );
        $response = Http::get($user->getAvatar());
        $this->assertTrue($response->successful());
    }
}
