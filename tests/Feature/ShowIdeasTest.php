<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Idea;
use App\Models\Category;
use App\Models\Status;
use App\Models\User;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_of_ideas_shows_on_main_page()
    {
        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $catOne = Category::factory()->create(['name' => 'Cat 1']);
        $catTwo = Category::factory()->create(['name' => 'Cat 2']);

        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);
        $statusClosed = Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);
        
        $idea1 = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My first Idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);
        $idea2 = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "My second Idea",
            'description' => "Description of my second idea.",
            'category_id' => $catTwo->id,
            'status_id' => $statusClosed->id,
        ]);
   
        $response = $this->get(route('idea.index'));
        $response->assertSuccessful();
        $response->assertSee($idea1->title);
        $response->assertSee($idea1->description);
        $response->assertSee($catOne->name);
        $response->assertSee($idea2->title);
        $response->assertSee($idea2->description);
        $response->assertSee($catTwo->name);
// More specific assertSee to prevent false positives, because there are other status labels on the page
        $response->assertSee('<div class="bg-green text-white text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">Implementing</div>', false);
        $response->assertSee('<div class="bg-red text-white text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">Closed</div>', false);
    }

    public function test_single_ideas_shows_on_show_page()
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
 
        $response = $this->get(route('idea.show', $idea));
        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($catOne->name);

        $response->assertSee('<div class="bg-green text-white text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">Implementing</div>', false);
    }

    public function test_slugs_are_unique( )
    {
        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        $catOne = Category::factory()->create(['name' => 'Cat 1']);
        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "First idea",
            'description' => "This is the first ideas description",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => "First idea",
            'description' => "This is the second ideas description",
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);

        $response = $this->get(route('idea.show', $ideaOne));
        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/first-idea');

        $response = $this->get(route('idea.show', $ideaTwo));
        $response->assertSuccessful();
        //  dd($ideaTwo->slug);
        $this->assertTrue(request()->path() === 'ideas/first-idea-2');
        $this->assertTrue( $ideaTwo->slug === 'first-idea-2');

    }
    public function test_ideas_pagination_works( )
    {
        $user = User::factory()->create([
            'name' => 'MarkCond',
            'email' => 'condellomark@gmail.com',
        ]);
        # code...
        $catOne = Category::factory()->create(['name' => 'Cat 1']);
        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);

        // dd($catOne, $statusImplementing);
        Idea::factory(Idea::PAGINATION_COUNT + 1)->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusImplementing->id,
        ]);

        $idea1 = Idea::first();
        $idea11 = Idea::find(11);
 
        $response = $this->get('/');
        $response->assertSee($idea11->title);
        $response->assertDontSee($idea1->title);

        $response = $this->get('/?page=2');
        $response->assertDontSee($idea11->title);
        $response->assertSee($idea1->title);
    }

}
