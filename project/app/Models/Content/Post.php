<?php

namespace App\Models\Content;

use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes, Sluggable;

    public function sluggable(): array
    {
        return[
            'slug' =>[
                'source' => 'title'
            ]
        ];
    }

    protected $casts = ['image' => 'array'];


    protected $fillable = ['title','slug','summary','body','image','status','commentable','tags','published_at','author_id','category_id'];

    public function PostCategory()
    {
      
      return $this->belongsTo(PostCategory::class,'category_id');
    }

    public function User()
    {
      return $this->belongsTo(User::class,'author_id');
    }

    public function comments(){
      return $this->morphMany('App\Modele\Content\Comment','commentable');
    }
}
