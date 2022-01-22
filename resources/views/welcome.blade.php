@extends('layouts.app')

@section('content')

    @foreach($news as $item)
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-3" style="text-align: center; padding: 10px;">
                    <img src="{{ asset('storage/' . $item->picture) }}" class="img-fluid rounded-start img-thumb" />
                </div>
                <div class="col-md-9" style="padding: 10px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <p class="card-text">{{ $item->about }}</p>
                        <a href="{{ route('newsShow', $item->id) }}" class="card-link">Читать далее</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{ $news->links() }}

@endsection
