<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Menu;

class Hello extends Component
{
    /**
     * @var string
     */
    public $name;
    public $adress_platform;

    public $menu = '';


    /**
     * Create a new component instance.
     *
     * @param string $menu
     */
    public function __construct(string $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return <<<'blade'
            <div class="cf nestable-lists">
                <div class="dd navbarf" id="nestable">
                    {!! $menu !!}
                </div>
            </div>
            <script src="{{asset('js/jquery.js')}}"></script>
            <script src="{{asset('js/jquery.nestable.js')}}"></script>
            <script src="{{asset('js/script.js')}}"></script>
            <link rel="stylesheet" href="{{asset('css/style.css')}}">
        blade;
    }
}
