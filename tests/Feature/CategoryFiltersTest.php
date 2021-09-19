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

class CategoryFiltersTest extends TestCase
{
    use RefreshDatabase;

    public function test_selecting_a_category_filters_correctly()
    {
        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);
        $statusClosed = Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My first Idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My second Idea",
            'description' => "Description of my second idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My third Idea",
            'description' => "Description of my third idea.",
            'category_id' => $catTwo->id,
            'status_id' => $statusImplementing->id,
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('category', 'Category 1')
            ->assertViewHas('ideas', function($ideas){
                return $ideas->count() === 2
                && $ideas->first()->category->name === 'Category 1';

            });
    }

    public function test_category_query_string_updates_correctly()
    {
        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);
        $statusClosed = Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My first Idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My second Idea",
            'description' => "Description of my second idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My third Idea",
            'description' => "Description of my third idea.",
            'category_id' => $catTwo->id,
            'status_id' => $statusImplementing->id,
        ]);

        Livewire::withQueryParams(['category' => 'Category 1'])
            ->test(IdeasIndex::class)
            ->assertViewHas('ideas', function($ideas){
                return $ideas->count() === 2
                && $ideas->first()->category->name === 'Category 1';
            });
    }

    public function test_selecting_a_status_and_a_category_filters_correctly()
    {
        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);
        $statusClosed = Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My first Idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My second Idea",
            'description' => "Description of my second idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My third Idea",
            'description' => "Description of my third idea.",
            'category_id' => $catTwo->id,
            'status_id' => $statusClosed->id,
        ]);
        $ideaFour = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My fourth Idea",
            'description' => "Description of my Fourth idea.",
            'category_id' => $catTwo->id,
            'status_id' => $statusClosed->id,
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('category', 'Category 1')
            ->set('status', 'Implementing')

            ->assertViewHas('ideas', function($ideas){
                return $ideas->count() === 2
                && $ideas->first()->category->name === 'Category 1'
                && $ideas->first()->status->name === 'Implementing';
            });
    }


    public function test_category_query_string_filters_correctly_with_status_and_category()
    {
        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);
        $statusClosed = Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My first Idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My second Idea",
            'description' => "Description of my second idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My third Idea",
            'description' => "Description of my third idea.",
            'category_id' => $catTwo->id,
            'status_id' => $statusImplementing->id,
        ]);

        Livewire::withQueryParams(['category' => 'Category 1', 'status' => 'Implementing'])
            ->test(IdeasIndex::class)
            ->assertViewHas('ideas', function($ideas){
                return $ideas->count() === 2
                && $ideas->first()->category->name === 'Category 1'
                && $ideas->first()->status->name === 'Implementing';

            });
    }


    public function test_selecting_all_categories_filters_correctly()
    {
        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);
        $statusClosed = Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My first Idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My second Idea",
            'description' => "Description of my second idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My third Idea",
            'description' => "Description of my third idea.",
            'category_id' => $catTwo->id,
            'status_id' => $statusImplementing->id,
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('category', 'All Categories')
            ->assertViewHas('ideas', function($ideas){
                return $ideas->count() === 3;
        });
    }
}
