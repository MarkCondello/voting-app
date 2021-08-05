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
use App\Http\Livewire\IdeaIndex;

class VoteIndexPageTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_page_contains_idea_index_livewire_component()
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

        $this->get(route('idea.index'))
            ->assertSeeLivewire('idea-index');
    }

    public function test_index_page_correctly_receives_vote_count()
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

        $this->get(route('idea.index'))
            ->assertViewHas('ideas', function($ideas){
                return $ideas->first()->votes == '2';
            });
    }

    public function test_votes_count_shows_correctly_on_livewire_component_on_index_page()
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
 
        Livewire::test('idea-index', [
            'idea' => $idea,
            'votes' => 5,
        ])
        ->assertSet('votes', 5)
        ->assertSeeHtml('<div class="font-semibold text-2xl ">5</div>', false);
    }

    // public function test_user_who_is_logged_in_shows_voted_if_already_voted_for()
    // {
    //     $user = User::factory()->create([
    //         'name' => 'MarkCond',
    //         'email' => 'condellomark@gmail.com',
    //     ]);
    //     $catOne = Category::factory()->create(['name' => 'Cat 1']);
    //     $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);
    //     $idea = Idea::factory()->create([
    //         'user_id' => $user->id,
    //         'title' => "My first Idea",
    //         'description' => "Description of my first idea.",
    //         'category_id' => $catOne->id,
    //         'status_id' => $statusImplementing->id,
    //     ]);

    //     Vote::factory()->create([
    //         'user_id' => $user->id,
    //         'idea_id' => $idea->id,
    //         ]
    //     );

    //     $response = $this->actingAs($user)->get(route('idea.index'));
    //     $ideaWithVotes = $response['ideas']->items()[0];

    //     // dd($ideaWithVotes);

    //     Livewire::actingAs($user)
    //         ->test(IdeaShow::class,[
    //             'idea' => $ideaWithVotes,
    //             'votes' => 5,
    //         ])
    //         ->assertSet('hasVoted', true)
    //         ->assertSee('Voted');
    // }

    public function test_user_is_logged_in_can_vote_for_idea()
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

        $this->assertDatabaseMissing('votes',[
            'idea_id' => $idea->id,
            'user_id' => $user->id,
        ]);

        Livewire::actingAs($user)
            ->test(IdeaIndex::class,[
                'idea' => $idea,
                'votes' => 5,
            ])
            ->call('vote')
            ->assertSet('votes', 6)
            ->assertSet('hasVoted', true)
            ->assertSee('Voted');

            $this->assertDatabaseHas('votes',[
                'idea_id' => $idea->id,
                'user_id' => $user->id,
            ]);
    }
}
