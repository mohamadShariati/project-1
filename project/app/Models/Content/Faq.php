<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory,Sluggable,SoftDeletes;

    public function sluggable(): array
    {
        return ['slug' => ['source' => 'question']];
    }

    protected $fillable = ['question','answer','slug','status','tags'];

    
}
