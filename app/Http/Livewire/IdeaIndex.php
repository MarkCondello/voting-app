<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Idea;

class IdeaIndex extends Component
{
    public $idea;
    public $votes;
    public $hasVoted;
    
    public function mount(Idea $idea, $votes)
    {
        $this->idea = $idea;
        $this->votes = $votes;
        $this->hasVoted = $idea->isVotedByUser(auth()->user());
    }

    public function vote()
    {
        if(! auth()->check()){
            return redirect(route('login'));
        }
        if($this->hasVoted){
            $this->idea->removeVote(auth()->user());
            $this->votes--;
            $this->hasVoted = false;
        } else {
            $this->idea->vote(auth()->user());
            $this->votes++;
            $this->hasVoted = true;
        }
    }

    public function render()
    {
        return view('livewire.idea-index');
    }
}
