<?php

namespace App\Orchid\Screens\Category;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class CategoryEditScreen extends Screen
{
    /**
     * @var Categories
     */
    public $category;

    /**
     * Query data.
     *
     * @param Categories $category
     *
     * @return array
     */
    public function query(Categories $category): array
    {
        $category->load('attachment');

        return [
            'category' => $category
        ];
    }

    /**
     * The name is displayed on the user's screen and in the headers
     */
    public function name(): ?string
    {
        return $this->category->exists ? 'Edit category' : 'Creating a new category';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Category";
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create category')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->category->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->category->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->category->exists),
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
            Layout::rows([
                Input::make('category.title')
                    ->title('Title')
                    ->placeholder('Attractive but mysterious title')
                    ->help('Specify a short descriptive title for this category.'),

                Input::make('category.slug')
                    ->title('Slug')
                    ->placeholder('Url category'),


                TextArea::make('category.description')
                    ->title('Description')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Brief description for preview'),

                Relation::make('category.author')
                    ->title('Author')
                    ->fromModel(User::class, 'name'),

                Quill::make('category.body')
                    ->title('Main text'),

            ])
        ];
    }

    /**
     * @param Categories $category
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Categories $category, Request $request)
    {

        $request->validate([
            'category.title' => 'required',
            'category.slug' => 'required',
            'category.description' => 'required',
            'category.author' => 'required',
            'category.body' => 'required',
        ]);


        $category->fill($request->get('category'))->save();

        $category->attachment()->syncWithoutDetaching(
            $request->input('category.attachment', [])
        );

        Alert::info('You have successfully created a post.');

        return redirect()->route('platform.category.list');
    }

    /**
     * @param Categories $category
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Categories $category)
    {
        $category->delete();

        Alert::info('You have successfully deleted the category.');

        return redirect()->route('platform.category.list');
    }
}
