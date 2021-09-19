<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Status;
use App\Models\Idea;
use Livewire\Livewire;
use App\Http\Livewire\StatusFilters;
use App\Http\Livewire\IdeasIndex;

class StatusFiltersTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_contains_status_filters_liewire_component()
    {
        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $catOne = Category::factory()->create(['name' => 'Cat 1']);
        $statusOpen= Status::factory()->create(['id' => 1, 'name' => 'Open']);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOpen->id,
            'title' => "My first Idea",
            'description' => "My first Idea's desc",
        ]);

        $response = $this->get(route('idea.index'))
            ->assertSeeLivewire('status-filters');
    }

    public function test_show_page_contains_status_filters_liewire_component()
    {
        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $catOne = Category::factory()->create(['name' => 'Cat 1']);
        $statusOpen= Status::factory()->create(['id' => 1, 'name' => 'Open']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOpen->id,
            'title' => "My first Idea",
            'description' => "My first Idea's desc",
        ]);

        $response = $this->get(route('idea.show', $idea))
            ->assertSeeLivewire('status-filters');
    }

    public function test_shows_correct_status_count()
    {
        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $catOne = Category::factory()->create(['name' => 'Cat 1']);
        $statusImplemented = Status::factory()->create(['id' => 4, 'name' => 'Implemented']);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusImplemented->id,
            'title' => "My first Idea",
            'description' => "My first Idea's desc",
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusImplemented->id,
            'title' => "My first Idea",
            'description' => "My first Idea's desc",
        ]);

        Livewire::test(StatusFilters::class)
        ->assertSee("All Ideas (2)")
        ->assertSee("Implemented (2)");
    }


    public function test_filter_works_when_query_string_in_place()
    {
        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $catOne = Category::factory()->create(['name' => 'Cat 1']);

        $statusImplemented = Status::factory()->create(['id' => 1, 'name' => 'Implemented',]);
        $statusConsidering = Status::factory()->create(['id' => 2, 'name' => 'Considering',  'classes' => 'bg-purple text-white']);
        $statusInProgress = Status::factory()->create(['id' => 3, 'name' => 'In Progress',  'classes' => 'bg-yellow text-white']);
        $statusImplementing = Status::factory()->create(['id' => 4, 'name' => 'Implementing']);
        $statusClosed = Status::factory()->create(['id' => 5, 'name' => 'Closed']);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusConsidering->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusConsidering->id,
        ]);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusInProgress->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusInProgress->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusInProgress->id,
        ]);

        Livewire::withQueryParams(['status' => 'In Progress'])
            ->test(IdeasIndex::class)
            ->assertViewHas('ideas', function($ideas){
                return $ideas->count() === 3
                 && $ideas->first()->status->name === 'In Progress';
            });
            // It is better to not test against html responses
        // $response = $this->get(route('idea.index', ['status' => 'In Progress']));
        // $response->assertSuccessful();
        // //check that there is a button show with In Progress
        // $response->assertSee('<div class="bg-yellow text-white text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">In Progress</div>', false);

        // //check that there is no button show with Considering
        // $response->assertDontSee('<div class="bg-purple text-white text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">Considering</div>', false);
    }



    public function test_show_page_does_not_show_selected_status()
    {
        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $catOne = Category::factory()->create(['name' => 'Cat 1']);

        $statusInProgress = Status::factory()->create(['id' => 3, 'name' => 'In Progress',  'classes' => 'bg-yellow text-white']);
 
        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusInProgress->id,
        ]);

        $response = $this->get(route('idea.show',$idea));
        $response->assertSuccessful();

        //check that there is no selected filter
        $response->assertDontSee('border-blue text-gray-900', false);
    }

    public function test_index_page_shows_selected_status()
    {
        $response = $this->get(route('idea.index'));
        $response->assertSuccessful();

        //check that there is no selected filter
        $response->assertSee('border-blue text-gray-900', false);
    }
}
