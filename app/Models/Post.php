<?php

namespace App\Models;

use App\Models\Like;
use App\Models\PostImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){//relation entre Table users et post: un post appartient à un seul user
        return $this->belongsTo('App\Models\User');
    }

    //la relation entre posts et likes
    Public function likes(){
	    return $this->hasmany(Like::class);
    }

    public function getImageUrl(){
        if($this->image && Storage::disk('public')->exists($this->image)){
            return asset('storage/' . $this->image);
        }
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }

    public function userReaction(){
        if (!auth()->check()){
            return null;
        }

        $like = $this->likes()->where('user_id', auth()->id())->first();

        return $like ? $like->type : null ;
    }

    public function userLike(){
        return $this->likes()->where('user_id', auth()->id())->first();
    }

    public function images(){
        return $this->hasMany(PostImage::class);
    }
}
