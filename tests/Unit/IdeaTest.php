<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Idea;
use App\Models\Category;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;

class IdeaTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_check_if_idea_is_voted_for_by_user()
    {

        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $userB = User::factory()->create();
        $catOne = Category::factory()->create(['name' => 'Cat 1']);
        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);
        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My first Idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);

        Vote::factory()->create([
            'user_id' => $user->id,
            'idea_id' => $idea->id,
            ]
        );
        $this->assertTrue($idea->isVotedByUser($user));
        $this->assertFalse($idea->isVotedByUser($userB));
        $this->assertFalse($idea->isVotedByUser(null));

    }
}
