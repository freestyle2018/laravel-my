<?php

namespace App\Orchid\Screens\Menu;

use Illuminate\Support\Facades\App;
use App\Models\Menu;
use App\Orchid\Layouts\MenuListLayout;
use App\View\Components\Hello;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;

class MenuListScreen extends Screen
{

    public $menu = '';
    public $adress_platform = '';


    public function __construct()
    {
        $menus = Menu::orderby('order', 'asc')->get();

        $this->menu = $this->getHTML($menus);
    }


    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'menu' => $this->menu
        ];
    }

    /**
     * The name is displayed on the user's screen and in the headers
     */
    public function name(): ?string
    {
        return 'Menu';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "edit menu";
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Create new')
                ->icon('pencil')
                ->route('platform.menu.new')
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            //MenuListLayout::class
            Layout::component(Hello::class),
        ];
    }

    public function buildMenu($menu, $parentid = 0)
    {
        $this->adress_platform = config('platform.prefix');

        $result = null;
        foreach($menu as $item)
            if ($item->parent_id == $parentid) {
                $result .= "<li class='dd-item nested-list-item' data-order='{$item->order}' data-id='{$item->id}'>
                    <div class='dd-handle'>
                        <div class='nested-list-handle'>
                              <i class='fas fa-arrows-alt'></i>
                        </div>
                        <div class='nested-list-content'>
                            {$item->title}
                        </div>
                    </div>
                    <div class='float-right'>
                            <a href='/{$this->adress_platform}/menus/edit/{$item->id}'>Edit</a> |
                            <a target='_self' href='/{$this->adress_platform}/menus/delete/{$item->id}' class='delete_toggle text-danger'>Delete</a>
                          </div>

                    ".$this->buildMenu($menu, $item->id) . "</li>";


            }
        return $result ?  "\n<ol class=\"dd-list\">\n$result</ol>\n" : null;
    }


    // Getter for the HTML menu builder
    public function getHTML($items)
    {
        return $this->buildMenu($items);
    }


}
