<?php

// app/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use AsSource, Attachable, Filterable;

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'body',
        'author',
        'slug',
        'hero'
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'title',
        'created_at',
        'updated_at'
    ];

    /**
     * Name of columns to which http filter can be applied
     *
     * @var array
     */
    protected $allowedFilters = [
        'title',
    ];
}
