<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreNewsapiArticleRequest;
use App\Http\Requests\UpdateNewsapiArticleRequest;
use App\Models\NewsapiArticle;

class NewsapiArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $yesterday = date('Y-m-d',strtotime("-1 days"));
        if ($request->date) {
            $sortByPublishDate = NewsapiArticle::orderBy('publication_date', $request->date)->latest()->paginate(10);
            return $sortByPublishDate;
        }
        if ($request->search) {
            $previous_search = NewsapiArticle::where('keyword', '=', $request->search)->latest()->first();
            if (!empty($previous_search) && $yesterday === date('Y-m-d', strtotime($previous_search->publication_date))) {
                return $articles = NewsapiArticle::where('keyword', '=', $request->search)->latest()->paginate(10);
            } else {
                $new_date = !empty($previous_search) && $previous_search->publication_date ? date ('Y-m-d',strtotime('+1 day', strtotime($previous_search->publication_date))) : $yesterday;
                $news= Http::get("https://newsapi.org/v2/everything?q={$request->search}&from={$yesterday}&to={$yesterday}&pageSize=100&apiKey=f883497940c148dfb8a60dfb4d384d79");
                $news = json_decode($news);
                $filtered = array_filter($news->articles, fn($item) => !empty($item) && isset($item->content) && $item->content !== "[Removed]");
                foreach ($filtered as $key => $article) {
                    $newsApiArticle = new NewsapiArticle([
                        'keyword' => $request->search,
                        'author' => $article->author ?? "No Author",
                        'title' => $article->title,
                        'description' => $article->description,
                        'web_url' => $article->url,
                        'image_url' => $article->urlToImage,
                        'content' => $article->content,
                        'publication_date' => $article->publishedAt,
                    ]);
                    $newsApiArticle->save();
                }
                $new_data = NewsapiArticle::where('keyword', '=', $request->search)->latest()->paginate(10);
                return $new_data;
            }
        } else {
            $last_record = NewsapiArticle::latest()->first();
            if ($last_record && $yesterday === date('Y-m-d', strtotime($last_record->publication_date))) {
                return $articles = NewsapiArticle::latest()->paginate(10);
            } else {
                $news= Http::get("https://newsapi.org/v2/top-headlines?category=sport&pageSize=100&apiKey=f883497940c148dfb8a60dfb4d384d79");
                $news = json_decode($news);
                $filtered = array_filter($news->articles, fn($item) => !empty($item) && isset($item->content) && $item->content !== "[Removed]");
                foreach ($filtered as $key => $article) {
                    $newsApiArticle = new NewsapiArticle([
                        'keyword' => 'sport',
                        'author' => $article->author ?? "No Author",
                        'title' => $article->title,
                        'description' => $article->description,
                        'web_url' => $article->url,
                        'image_url' => $article->urlToImage,
                        'content' => $article->content,
                        'publication_date' => $article->publishedAt,
                    ]);
                    $newsApiArticle->save();
                }
                $new_data = NewsapiArticle::where('keyword', '=', 'sport')->latest()->paginate(10);
                return $new_data;
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsapiArticleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsapiArticle $newsapiArticle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsapiArticleRequest $request, NewsapiArticle $newsapiArticle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsapiArticle $newsapiArticle)
    {
        //
    }
}
