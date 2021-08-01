<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\CreateIdea;
use App\Models\Category;
use App\Models\Status;

class CreateIdeaTest extends TestCase
{
    use RefreshDatabase;

    public function test_idea_form_does_not_show_when_not_logged_out()
    {
        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee('Please log in to add an idea.
        ');
        $response->assertDontSee('Let us know what you would like and we\'ll take a look over!', false);
    }

    public function test_idea_form_does_show_when_logged_in()
    {
        $response = $this->actingAs(User::factory()->create())
        ->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertDontSee('Please log in to add an idea.
        ');
        $response->assertSee('Let us know what you would like and we\'ll take a look over!', false);
    }
    public function test_see_livewire_component_when_logged_in()
    {
        $this->actingAs(User::factory()->create())
        ->get(route('idea.index'))
        ->assertSeeLivewire('create-idea');
    }

    public function test_create_idea_form_validation_works()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateIdea::class) // tests the create idea livewire component
            ->set('title', '')
            ->set('category', '')
            ->set('description', '')
            ->call('createIdea')
            ->assertHasErrors('title', 'category', 'description')
            ->assertSee('The title field is required');
    }

    public function test_creating_an_idea_works_correctly()
    {
        $user = User::factory()->create();
        $catOne = Category::factory()->create(['name' => 'Cat 1']);
        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);

        Livewire::actingAs($user)
            ->test(CreateIdea::class)
            ->set('title', 'My First Idea')
            ->set('category', $catOne->id)
            ->set('description', 'This is my first idea')
            ->call('createIdea')
            ->assertRedirect('/');

        $response = $this->actingAs($user)->get(route('idea.index')); 
        $response->assertSuccessful();
        $response->assertSee('My First Idea');   
        $response->assertSee('This is my first idea');   

        $this->assertDatabaseHas('ideas', [
            'title' => 'My First Idea',
        ]);
    }

    public function test_creating_two_ideas_works_and_creates_unique_slugs()
    {
        $user = User::factory()->create();
        $catOne = Category::factory()->create(['name' => 'Cat 1']);
        $catTwo = Category::factory()->create(['name' => 'Cat 2']);
        $statusImplementing = Status::factory()->create(['name' => 'Implementing', 'classes' => 'bg-green text-white']);

        Livewire::actingAs($user)
            ->test(CreateIdea::class)
            ->set('title', 'My First Idea')
            ->set('category', $catOne->id)
            ->set('description', 'This is my first idea')
            ->set('status', $statusImplementing->id)
            ->call('createIdea')
            ->assertRedirect('/');
 
        $this->assertDatabaseHas('ideas', [
            'title' => 'My First Idea',
            'slug' => 'my-first-idea',
        ]);

        Livewire::actingAs($user)
        ->test(CreateIdea::class)
        ->set('title', 'My First Idea')
        ->set('category', $catTwo->id)
        ->set('description', 'This is my first idea')
        ->set('status', $statusImplementing->id)
        ->call('createIdea')
        ->assertRedirect('/');

        $this->assertDatabaseHas('ideas', [
            'title' => 'My First Idea',
            'slug' => 'my-first-idea-2',
        ]);
    }
}
