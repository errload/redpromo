@if(!isset($active))
    {{ $active = '' }}
@endif

<ul class="nav nav-tabs">

    <li class="nav-item">
        <div class="dropdown">
            @if(is_null(\Illuminate\Support\Facades\Cookie::get('city')) || \Illuminate\Support\Facades\Cookie::get('city') == 'moscow')
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Москва
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="{{ route('changeCity') }}">Нальчик</a></li>
                </ul>
            @else
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Нальчик
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="{{ route('changeCity') }}">Москва</a></li>
                </ul>
            @endif
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ $active == 'allNews' ? 'active' : '' }}" aria-current="page" href="{{ route('allNews') }}">Все новости</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ $active == 'favorites' ? 'active' : '' }}"
           href="{{ route('favorites', \Illuminate\Support\Facades\Cookie::get('city') ?: 'moscow') }}">Избранные</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ $active == 'myFavorites' ? 'active' : '' }}" href="{{ route('myFavorites') }}">Мои</a>
    </li>

    <li class="nav-item nav-form">
        <div class="row g-3 align-items-center">
            <form action="{{ route('searchNews') }}" method="POST">
                @csrf
                <div class="col-auto">
                    <input type="text" name="searchNews" class="form-control input-search" placeholder="Поиск по новостям">
                    <button type="submit" class="btn btn-secondary btn-search">Поиск</button>
                </div>
            </form>
        </div>
    </li>

</ul>
