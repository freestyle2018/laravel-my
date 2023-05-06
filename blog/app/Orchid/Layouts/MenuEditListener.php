<?php

namespace App\Orchid\Layouts;

use App\Models\Post;
use App\Models\Categories;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;

class MenuEditListener extends Listener
{
    /**
     * List of field names for which values will be joined with targets' upon trigger.
     *
     * @var string[]
     */
    protected $extraVars = [];

    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        'menu.essence',
    ];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asynsSelect';

    /**
     * @return Layout[]
     */
    protected function layouts(): iterable
    {

        //var_dump($this->query);

        //echo "001\r\n";
        //var_dump($this->query["menu"]);

        return [
            Layout::rows([
                Select::make('menu.essence')
                    ->options([
                        '/post/'   => 'Статья',
                        '/category/' => 'Категория',
                    ])
                    ->empty('Не выбрано')
                    ->title('Select tags')
                    ->help('Allow search bots to index'),

                Relation::make('menu.slug')
                    ->fromModel(Post::class, 'title', 'slug')
                    ->canSee($this->query->has('see_post'))
                    ->canSee($this->query["menu"]["essence"] == "/post/")
                    ->title('Выберите статью'),

                Relation::make('menu.slug')
                    ->fromModel(Categories::class, 'title', 'slug')
                    ->canSee($this->query->has('see_category'))
                    ->canSee($this->query["menu"]["essence"] == "/category/")
                    ->title('Выберите статью'),
            ])
        ];
    }
}
