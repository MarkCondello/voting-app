<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Idea;
use Illuminate\Http\Response;

class CreateIdea extends Component
{
    public $title;
    public $category = 1;
    public $description;
    public $status = 1;

    protected $rules = [
        'title' => 'required|min:4',
        'category' => 'required|integer',
        'description' => 'required|min:4',
    ];

    public function render()
    {
        $categories = Category::all();
        return view('livewire.create-idea')->with(compact('categories'));
    }

    public function createIdea()
    {
        if(auth()->check()){
            $this->validate();
            
            Idea::create([
                'user_id' => auth()->id(),
                'category_id' => $this->category,
                'title' => $this->title,
                'description' => $this->description,
                'status_id' => $this->status,
                ]
            );
            session()->flash('success_message', 'Idea was added successfully');
            $this->reset();
            return redirect()->route('idea.index');
        } 
        abort(Response::HTTP_FORBIDDEN);
    }
}
