<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    // если куки не найдены, устанавливаем город по умолчанию
    public function isCookie()
    {
        if (is_null(Cookie::get('city'))) Cookie::queue('city', 'moscow', time() + 86400);
    }

    // смена города в куках
    public function changeCity()
    {
        if (Cookie::get('city') == 'moscow') Cookie::queue('city', 'nalchik', time() + 86400);
        if (Cookie::get('city') == 'nalchik') Cookie::queue('city', 'moscow', time() + 86400);

        return redirect()->route('allNews');
    }

    // все новости
    public function allNews(Request $request)
    {
        $this->isCookie();
        $title = 'Все новости';
        $active = 'allNews'; // для активации текущего пункта меню

        $news = DB::table('news')->paginate(20);

        return view('welcome', compact(['title', 'active', 'news']));
    }

    // новости в избранном
    public function favorites($city)
    {
        $this->isCookie();
        $title = 'Избранное';
        $active = 'favorites'; // для активации текущего пункта меню

        $news = DB::table('news')
            ->where('city', $city)
            ->where('favorite', true)
            ->paginate(20);

        return view('welcome', compact(['title', 'active', 'news']));
    }

    // избранные новости пользователем
    public function myFavorites()
    {
        $this->isCookie();
        $title = 'Мои избранные новости';
        $active = 'myFavorites'; // для активации текущего пункта меню

        // массив избранного из кук
        $cookie = unserialize(Cookie::get('news'));
        $search = [];

        // если данных нет, вернем пустой массив
        // если есть, поочереди вытаскиваем записи из БД и добавляем в результирующий массив
        if ($cookie && count($cookie) > 0) {
            foreach ($cookie as $item) {
                $search[] = News::findOrFail($item);
            }
        } else $news = [];

        foreach ($search as $item) {
            $news[] = [
                'id'        => $item->id,
                'title'     => $item->title,
                'about'     => $item->about,
                'text'      => $item->text,
                'picture'   => $item->picture,
                'city'      => $item->city,
                'favorite'  => $item->favorite
            ];
        }

        return view('myfavorites', compact(['title', 'active', 'news']));
    }

    // просмотр новости
    public function newsShow($id)
    {
        $news = News::findOrFail($id);
        $title = $news->title;
        $similarNews = [];

        //разбиваем заголовок на слова
        $similar = explode(' ', $title);

        // ищем в бд записи на совпадения слов
        foreach ($similar as $item) {
            $search = DB::table('news')
                ->where('title', 'LIKE', "%{$item}%")
                ->first();

            // результат в массив
            if ($search && $search->id != $id) {
                $similarNews[] = [
                    'id'        => $search->id,
                    'title'     => $search->title,
                    'about'     => $search->about,
                    'text'      => $search->text,
                    'picture'   => $search->picture,
                    'city'      => $search->city,
                    'favorite'  => $search->favorite
                ];
            }
        }

        // убираем повторяющиеся значения
        $similarNews = array_unique($similarNews, SORT_REGULAR);

        // массив кук с id для проверки, была ли запись уже добавлена в избранное пользователя
        $cookie = unserialize(Cookie::get('news'));

        if (!$cookie) $cookie = [];

        return view('show', compact(['title', 'news', 'similarNews', 'cookie']));
    }

    // поиск по новостям
    public function searchNews(Request $request)
    {
        $title = 'Результат поиска';

        $validated = $request->validate([
            'searchNews' => 'required|string|max:255'
        ]);

        if (!$validated) return;

        $news = DB::table('news')
            ->where('title', 'LIKE', "%{$request->searchNews}%")
            ->paginate(20);

        return view('search', compact(['title', 'news']));
    }

    // добавление новости в мои избранные
    public function addMyFavorites($id)
    {
        $news = unserialize(Cookie::get('news'));
        $news[] = $id;
        Cookie::queue('news', serialize($news), time() + 2592000); // на месяц

        return redirect()->back();
    }
}
