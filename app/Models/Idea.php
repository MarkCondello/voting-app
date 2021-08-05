<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Idea extends Model
{
    use HasFactory, Sluggable;

    const PAGINATION_COUNT = 10;
    
    protected $guarded = [];

    public function sluggable(): array
    {
       return [
           'slug' => [
               'source' => 'title',
           ]
        ];
    }

    
    public function isVotedByUser(?User $user)
    {
        if(!$user){
            return false;
        } else {
            return Vote::where('user_id', $user->id)
                ->where('idea_id', $this->id)
                ->exists();
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category( )
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function votes()
    {
        return $this->belongsToMany(User::class, 'votes');
        //'votes' is the pivot table for both users and ideas, so this relationship is a vote belongs to many
    }
    public function vote(User $user)
    {
        Vote::create([
            'idea_id' => $this->id,
            'user_id' => $user->id,
        ]);
    }

    public function removeVote(User $user)
    {
        Vote::where('idea_id',$this->id)
            ->where('user_id', $user->id)
            ->first()
            ->delete();
     }
}
