<?php

namespace App\Orchid\Screens\Menu;


use App\Models\Menu;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;


class MenuNewScreen extends Screen
{

    /**
     * @var Menu
     */
    public $menu;


    /**
     * Query data.
     *
     * @return array
     */
    public function query(Menu $menu): array
    {
        $menu->load('attachment');

        return [
            'menu' => $menu
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
        return $this->menu->exists ? 'Edit menu' : 'Creating a new menu';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Save')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee(!$this->menu->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->menu->exists),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('menu.title')
                    ->title('Title'),

                Input::make('menu.slug')
                    ->title('Slug'),
            ])
        ];
    }


    /**
     * @param Menu    $menu
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Menu $menu, Request $request)
    {
        $menu->fill($request->get('menu'))->save();


        Alert::info('You have successfully created a post.');

        return redirect()->route('platform.menu.list');
    }
}
