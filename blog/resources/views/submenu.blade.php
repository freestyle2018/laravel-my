@if ((count($menu->children) > 0) AND ($menu->parent_id > 0))
    <li class="nav-item dropdown">
        <a href="{{ url($menu->slug) }}" class="nav-link" role="button" data-toggle="dropdown">
            {{ $menu->title }}
            @if(count($menu->children) > 0)
                <i class="fa fa-caret-right fa-lg"></i>
            @endif
        </a>
@else
    <li class="dropdown-toggle nav-item @if($menu->parent_id === 0 && count($menu->children) > 0) dropdown @endif">
        <a href="{{ url($menu->slug) }}" class="nav-link dropdown-toggle" data-toggle="dropdown">
            {{ $menu->title }}
            @if(count($menu->children) > 0)
                <i class="fa fa-caret-down fa-lg"></i>
            @endif
        </a>
        @endif
        @if (count($menu->children) > 0)
            <ul class="@if($menu->parent_id !== 0 && (count($menu->children) > 0)) submenu @endif dropdown-menu" aria-labelledby="dropdownBtn">
                @foreach($menu->children as $menu)
                    @include('submenu', $menu)
                @endforeach
            </ul>
        @endif
    </li>
