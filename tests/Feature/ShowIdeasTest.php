<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Idea;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_of_ideas_shows_on_main_page()
    {
        $idea1 = Idea::factory()->create([
            'title' => "My first Idea",
            'description' => "Description of my first idea.",
        ]);
        $idea2 = Idea::factory()->create([
            'title' => "My second Idea",
            'description' => "Description of my second idea.",
        ]);

        $response = $this->get(route('idea.index'));
        $response->assertSuccessful();
        $response->assertSee($idea1->title);
        $response->assertSee($idea1->description);
        $response->assertSee($idea2->title);
        $response->assertSee($idea2->description);
    }

    public function test_single_ideas_shows_on_show_page()
    {
        $idea = Idea::factory()->create([
            'title' => "My first Idea",
            'description' => "Description of my first idea.",
        ]);
 
        $response = $this->get(route('idea.show', $idea));
        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
    }


    public function test_slugs_are_unique( )
    {
        # code...
        $ideaOne = Idea::factory()->create([
            'title' => "First idea",
            'description' => "This is the first ideas description",
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => "First idea",
            'description' => "This is the second ideas description",
        ]);

        $response = $this->get(route('idea.show', $ideaOne));
        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/first-idea');

        $response = $this->get(route('idea.show', $ideaTwo));
        $response->assertSuccessful();
        // dd($ideaTwo->slug);
        $this->assertTrue(request()->path() === 'ideas/first-idea-2');
        $this->assertTrue( $ideaTwo->slug === 'first-idea-2');

    }
    // public function test_ideas_pagination_works( )
    // {
    //     # code...
    //     Idea::factory(Idea::PAGINATION_COUNT + 1)->create();

    //     $idea1 = Idea::find(1);

    //     // $idea1->title = "My first idea";
    //     // $idea1->save();
    //     // dd($idea1);
    //     $idea11 = Idea::find(11);
    //     // $idea11->title = "My eleventh idea";
    //     // $idea11->save();

    //     $response = $this->get('/');
    //     $response->assertSee($idea1->title);
    //     $response->assertDontSee($idea11->title);

    //     $response = $this->get('/?page=2');
    //     $response->assertDontSee($idea1->title);
    //     $response->assertSee($idea11->title);
    // }

}
