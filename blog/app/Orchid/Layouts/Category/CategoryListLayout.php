<?php

namespace App\Orchid\Layouts\Category;

use App\Models\Categories;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;

class CategoryListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'categories';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('title', 'Title')
                ->sort()
                ->filter(Input::make())
                ->render(function (Categories $category) {
                    return Link::make($category->title)
                        ->route('platform.category.edit', $category);
                }),

            TD::make('created_at', 'Created')
                ->sort(),

            TD::make('updated_at', 'Last edit')
                ->sort(),
        ];
    }
}
