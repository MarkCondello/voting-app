<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Idea;

class IdeaShow extends Component
{
    public $idea;
    public $votes;

    public function mount(Idea $idea, $votes){
        $this->idea = $idea;
        $this->votes = $votes;
    }

    public function render()
    {
        return view('livewire.idea-show');
    }
}
