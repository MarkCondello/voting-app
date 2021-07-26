<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Idea;
use App\Models\Category;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_of_ideas_shows_on_main_page()
    {
        $catOne = Category::factory()->create(['name' => 'Cat 1']);
        $catTwo = Category::factory()->create(['name' => 'Cat 2']);

        $idea1 = Idea::factory()->create([
            'title' => "My first Idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
        ]);
        $idea2 = Idea::factory()->create([
            'title' => "My second Idea",
            'description' => "Description of my second idea.",
            'category_id' => $catTwo->id,
        ]);

        $response = $this->get(route('idea.index'));
        $response->assertSuccessful();
        $response->assertSee($idea1->title);
        $response->assertSee($idea1->description);
        $response->assertSee($catOne->name);
        $response->assertSee($idea2->title);
        $response->assertSee($idea2->description);
        $response->assertSee($catTwo->name);
    }

    public function test_single_ideas_shows_on_show_page()
    {
        $catOne = Category::factory()->create(['name' => 'Cat 1']);

        $idea = Idea::factory()->create([
            'title' => "My first Idea",
            'description' => "Description of my first idea.",
            'category_id' => $catOne->id,
        ]);
 
        $response = $this->get(route('idea.show', $idea));
        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($catOne->name);
    }


    public function test_slugs_are_unique( )
    {
        $catOne = Category::factory()->create(['name' => 'Cat 1']);

        $ideaOne = Idea::factory()->create([
            'title' => "First idea",
            'description' => "This is the first ideas description",
            'category_id' => $catOne->id,
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => "First idea",
            'description' => "This is the second ideas description",
            'category_id' => $catOne->id,
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
