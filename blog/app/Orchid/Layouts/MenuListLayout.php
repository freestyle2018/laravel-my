<?php

namespace App\Orchid\Layouts;

use App\Models\Menu;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;

class MenuListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'menus';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('title', 'Title')
                ->sort(),

            TD::make('slug', 'Slug')
                ->sort(),
        ];
    }
}
