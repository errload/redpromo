@extends('layouts.app')

@section('content')

    <div class="card mb-3">
        <div class="row g-0 showNews">
            <div class="col-md-12" style="text-align: center; padding: 10px;">
                <img src="{{ asset('storage/' . $news->picture) }}" class="img-fluid rounded-start img-original" />
            </div>
            <div class="col-md-12" style="padding: 10px;">
                <div class="card-body">
                    <h5 class="card-title">{{ $news->title }}</h5>
                    <p class="card-text">{{ $news->text }}</p>

                    @if($news->favorite && $news->city == \Illuminate\Support\Facades\Cookie::get('city'))

                        @if(in_array($news->id, $cookie))
                            <h6 class="card-subtitle mb-2 text-muted">Новость в моем избранном</h6>
                        @else
                            <a href="{{ route('addMyFavorites', $news->id) }}" class="btn btn-secondary">Добавить в мои новости</a>
                        @endif

                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(count($similarNews) > 0)
        <h4 class="search__h4">Похожие новости</h4>

        @if(count($similarNews) > 5)
            {{ array_slice($similarNews, 5) }}
        @endif

        @foreach($similarNews as $item)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $item['title'] }}</h5>
                    <p class="card-text">{{ $item['about'] }}</p>
                    <a href="{{ route('newsShow', $item['id']) }}" class="card-link">Читать далее</a>
                </div>
            </div>
        @endforeach
    @endif

@endsection
