<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Menu extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    protected $fillable = [
        'id', 'title', 'slug', 'order', 'parent_id'
    ];

}