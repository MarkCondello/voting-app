<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function getAvatar()
    {
        $firstCharacter = $this->email[0];
        $integerToUse = is_numeric($firstCharacter) ? ord(strToLower($firstCharacter)) - 21 : ord(strToLower($firstCharacter)) - 96;
    
        return 'https://www.gravatar.com/avatar/'
        . md5( strtolower( trim( $this->email ))) 
        . '?s=200'
        . '&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-'
        . $integerToUse 
        . '.png';
     }

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

    public function votes()
    {
        return $this->belongsToMany(Idea::class, 'votes');
        //'votes' is the pivot table for both users and ideas, so this relationship is a vote belongs to many
    }
}
