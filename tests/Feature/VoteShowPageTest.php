<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Idea;
use App\Models\Category;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Livewire\Livewire;
use App\Http\Livewire\IdeaShow;

class VoteShowPageTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_page_contains_idea_show_livewire_component()
    {
        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);

        $catOne = Category::factory()->create(['name' => 'Cat 1']);
        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);
        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My first Idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);

        $this->get(route('idea.show', $idea))
            ->assertSeeLivewire('idea-show');
    }

    public function test_page_correctly_receives_vote_count()
    {
        $user = User::factory()->create();
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
            'idea_id' => $idea->id,
            'user_id' => $user->id,
        ]);
        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $userB->id,
        ]);

        $this->get(route('idea.show', $idea))
            ->assertViewHas('votes', 2);
    }

    public function test_votes_count_shows_correctly_on_livewire_component()
    {
        $user = User::factory()->create();
 
        $catOne = Category::factory()->create(['name' => 'Cat 1']);
        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);
        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My first Idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
 
        Livewire::test('idea-show', [
            'idea' => $idea,
            'votes' => 5,
        ])
        ->assertSet('votes', 5);
        // ->assertSeeHtml('<div class="text-xl leading-snug text-blue">5</div>', false)
        // ->assertSeeHtml('<div class="text-sm font-bold leading-none text-blue">5</div>', false);
    }

    public function test_user_who_is_logged_in_shows_voted_if_already_voted_for()
    {
        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
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

        Livewire::actingAs($user)
            ->test(IdeaShow::class,[
                'idea' => $idea,
                'votes' => 5,
            ])
             ->assertSet('hasVoted', true)
            ->assertSee('Voted');
    }
}
