@extends('layouts.app')

@section('content')

    @if(count($news) > 0)
        <h3 class="search__h3">Результат поиска</h3>

        @foreach($news as $item)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->title }}</h5>
                    <p class="card-text">{{ $item->about }}</p>
                    <a href="{{ route('newsShow', $item->id) }}" class="card-link">Читать далее</a>
                </div>
            </div>
        @endforeach

        {{ $news->links() }}
    @else
        <h3 class="search__h3">Поиск не дал результатов</h3>
    @endif

@endsection
