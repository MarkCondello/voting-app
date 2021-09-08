<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Idea;
use App\Models\Vote;
use Livewire\WithPagination;
use App\Models\Status;
use App\Models\Category;

class IdeasIndex extends Component
{
    use WithPagination;

    public $status = 'All';
    public $category;

    //how does this $queryString array work to populate the url???
    protected $queryString = [
        'status',
        'category',
    ];

    protected $listeners = ['queryStringUpdatedStatus'];//listener which is emitted from StatusFilters

    public function queryStringUpdatedStatus($newStatus)
    {
        $this->status = $newStatus;
        $this->resetPage(); // reset pagination when Status filter is changed
    }

    public function mount( )
    {
        $this->status = request()->status ?? 'All';// set default status from query string or All
        $this->category = request()->category ?? 'All Categories';// set default category from query string or All Categories
    }

    public function render()
    {
        $statuses = Status::all()->pluck('id', 'name');
        $categories = Category::all();

         //dd($statuses);
        return view('livewire.ideas-index', [
            'ideas' => Idea::with('user', 'category', 'status')
                ->when($this->status && $this->status !== 'All', function($query) use ($statuses){
                    return $query->where('status_id', $statuses->get($this->status));
                })
                ->when($this->category && $this->category !== 'All Categories', function($query) use ($categories){
                    return $query->where('category_id', $categories->pluck('id', 'name')->get($this->category));
                })
                ->addSelect(['voted_by_user' => Vote::select('id')
                    ->where('user_id', auth()->id())
                    ->whereColumn('idea_id', 'ideas.id')
                ])
                ->withCount('votes as votes')
                ->orderBy('id', 'desc')
                ->simplePaginate(Idea::PAGINATION_COUNT),
            'categories' => $categories,
        ]);
    }
}
