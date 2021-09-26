<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeasIndex;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Status;
use App\Models\Idea;
use Livewire\Livewire;
use App\Models\Vote;

class FiltersTest extends TestCase
{
    use RefreshDatabase;

    public function test_top_voted_filters_works()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $userC = User::factory()->create();

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);
        $statusClosed = Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $userA->id,
            'title' => "My first Idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $userA->id,
            'title' => "My second Idea",
            'description' => "Description of my second idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);

        Vote::factory()->create([
            'idea_id' => $ideaOne->id,
            'user_id' => $userA->id,
        ]);

        Vote::factory()->create([
            'idea_id' => $ideaOne->id,
            'user_id' => $userB->id,
        ]);

        Vote::factory()->create([
            'idea_id' => $ideaTwo->id,
            'user_id' => $userC->id,
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('filter', 'Top Voted')
            ->assertViewHas('ideas', function($ideas){
                return $ideas->count() === 2
                && $ideas->first()->votes()->count() === 2
                && $ideas->get(1)->votes()->count() === 1;
            });
    }

    public function test_my_ideas_filter_works_correctly_when_user_is_logged_in()
    {
        $userA = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $userB = User::factory()->create();

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);
        $statusClosed = Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);
        
        $ideaOne = Idea::factory()->create([
            'user_id' => $userA->id,
            'title' => "My first idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $userA->id,
            'title' => "My second idea",
            'description' => "Description of my second idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaThree = Idea::factory()->create([
            'user_id' => $userB->id,
            'title' => "My third Idea",
            'description' => "Description of my third idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);

        Vote::factory()->create([
            'idea_id' => $ideaOne->id,
            'user_id' => $userA->id,
        ]);
        Vote::factory()->create([
            'idea_id' => $ideaTwo->id,
            'user_id' => $userA->id,
        ]);
        Vote::factory()->create([
            'idea_id' => $ideaTwo->id,
            'user_id' => $userB->id,
        ]);

        Livewire::actingAs($userA)
            ->test(IdeasIndex::class)
            ->set('filter', 'My Ideas')
            ->assertViewHas('ideas', function($ideas){
                // dd($ideas->first()->title);
                return $ideas->count() === 2
                && $ideas->first()->title === "My second idea"
                && $ideas->get(1)->title === "My first idea";
            });
    }

    public function test_my_ideas_filter_works_correctly_when_user_is_not_logged_in()
    {
        $userA = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $userB = User::factory()->create();

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);
        $statusClosed = Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);
        
        $ideaOne = Idea::factory()->create([
            'user_id' => $userA->id,
            'title' => "My first idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $userA->id,
            'title' => "My second idea",
            'description' => "Description of my second idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaThree = Idea::factory()->create([
            'user_id' => $userB->id,
            'title' => "My third Idea",
            'description' => "Description of my third idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);

        Vote::factory()->create([
            'idea_id' => $ideaOne->id,
            'user_id' => $userA->id,
        ]);
        Vote::factory()->create([
            'idea_id' => $ideaTwo->id,
            'user_id' => $userA->id,
        ]);
        Vote::factory()->create([
            'idea_id' => $ideaTwo->id,
            'user_id' => $userB->id,
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('filter', 'My Ideas')
            ->assertRedirect(route('login'));
    }

    public function test_my_ideas_filter_works_correctly_with_categories_filter()
    {
        $userA = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $userB = User::factory()->create();

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);
        $statusClosed = Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);
        
        $ideaOne = Idea::factory()->create([
            'user_id' => $userA->id,
            'title' => "My first idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $userA->id,
            'title' => "My second idea",
            'description' => "Description of my second idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaThree = Idea::factory()->create([
            'user_id' => $userB->id,
            'title' => "My third Idea",
            'description' => "Description of my third idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);

        Vote::factory()->create([
            'idea_id' => $ideaOne->id,
            'user_id' => $userA->id,
        ]);
        Vote::factory()->create([
            'idea_id' => $ideaTwo->id,
            'user_id' => $userA->id,
        ]);
        Vote::factory()->create([
            'idea_id' => $ideaTwo->id,
            'user_id' => $userB->id,
        ]);

        Livewire::actingAs($userA)
            ->test(IdeasIndex::class)
            ->set('category', 'Category 1')
            ->set('filter', 'My Ideas')
            ->assertViewHas('ideas', function($ideas){
                return $ideas->count() === 2
                && $ideas->first()->votes()->count() === 2
                && $ideas->get(1)->votes()->count() === 1;            
            });
    }


    public function test_null_filter_works_correctly()
    {
        $userA = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $userB = User::factory()->create();

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);
        $statusClosed = Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);
        
        $ideaOne = Idea::factory()->create([
            'user_id' => $userA->id,
            'title' => "My first idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $userA->id,
            'title' => "My second idea",
            'description' => "Description of my second idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaThree = Idea::factory()->create([
            'user_id' => $userA->id,
            'title' => "My third idea",
            'description' => "Description of my third idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('filter', 'No Filter')
            ->assertViewHas('ideas', function($ideas){

                //dd($ideas->get(1)->title, $ideas->count());
                return $ideas->count() === 3
                && $ideas->first()->title === "My third idea"
                && $ideas->get(1)->title === "My second idea";           
            });
    }
}
