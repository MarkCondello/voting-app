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

class SearchFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_searching_works_with_more_than_three_characters()
    {
        $userA = User::factory()->create();

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

        Livewire::test(IdeasIndex::class)
            ->set('search', 'Second')
            ->assertViewHas('ideas', function($ideas){
                return $ideas->count() === 1
                && $ideas->first()->title = "My second idea";
             });
    }

    public function test_does_not_perform_search_if_less_than_three_characters()
    {
        $userA = User::factory()->create();

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

        Livewire::test(IdeasIndex::class)
            ->set('search', 'se')
            ->assertViewHas('ideas', function($ideas){
                return $ideas->count() === 2;             
            });
    }

    public function test_perform_search_with_other_filters()
    {
        $userA = User::factory()->create();

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
            'category_id' => $catTwo->id,
            'status_id' => $statusImplementing->id,
        ]);
        Livewire::test(IdeasIndex::class)
            ->set('search', 'idea')
            ->set('category', 'Category 1')
            ->assertViewHas('ideas', function($ideas){
                return $ideas->count() === 2;             
            });
    }

}
