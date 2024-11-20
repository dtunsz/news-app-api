<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreNytArticleRequest;
use App\Http\Requests\UpdateNytArticleRequest;
use App\Models\NytArticle;

class NytArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $today = date("Ymd");
        if ($request->date) {
            $sortByPublishDate = NytArticle::orderBy('publication_date', $request->date)->latest()->paginate(10);
            return $sortByPublishDate;
        }
        if ($request->search) {
            $previous_search = NytArticle::where('keyword', '=', $request->search)->latest()->first();
            if (!empty($previous_search) && $today === date('Ymd', strtotime($previous_search->publication_date))) {
                return $articles = NytArticle::where('keyword', '=', $request->search)->latest()->paginate(10);
            } else {
                $new_date = !empty($previous_search) && $previous_search->publication_date ?  date ('Ymd',strtotime('+1 day', strtotime($previous_search->publication_date))) : $today;
                $news= Http::get("https://api.nytimes.com/svc/search/v2/articlesearch.json?q={$request->search}&begin_date={$new_date}&sort=newest&api-key=GGplDVJijNyZY7lbLFGsLkZoU3WG38PM");
                $news = json_decode($news);
                foreach ($news->response->docs as $key => $article) {
                    $nytArticle = new NytArticle([
                        'keyword' => $request->search,
                        'abstract' => $article->abstract,
                        'web_url' => $article->web_url,
                        'lead_paragraph' => $article->lead_paragraph,
                        'uri' => $article->uri,
                        'section_name' => $article->section_name,
                        'subsection_name' => $article->subsection_name,
                        'publication_date' => $article->pub_date,
                    ]);
                    $nytArticle->save();
                }
                $new_data = NytArticle::where('keyword', '=', $request->search)->latest()->paginate(10);
                return $new_data;
            }
        } else {
            $last_record = NytArticle::latest()->first();
            if ($last_record && $today === date('Ymd', strtotime($last_record->publication_date))) {
                # code...
                return $articles = NytArticle::latest()->paginate(10);

            } else {
                # code...
                $news= Http::get("https://api.nytimes.com/svc/search/v2/articlesearch.json?q=sport&begin_date={$today}&sort=newest&api-key=GGplDVJijNyZY7lbLFGsLkZoU3WG38PM");
                $news = json_decode($news);
                foreach ($news->response->docs as $key => $article) {
                    $nytArticle = new NytArticle([
                        'keyword' => 'sport',
                        'abstract' => $article->abstract,
                        'web_url' => $article->web_url,
                        'lead_paragraph' => $article->lead_paragraph,
                        'uri' => $article->uri,
                        'section_name' => $article->section_name,
                        'subsection_name' => $article->subsection_name,
                        'publication_date' => $article->pub_date,
                    ]);
                    $nytArticle->save();
                }
                $new_data = NytArticle::where('keyword', '=', 'sport')->latest()->paginate(10);
                return $new_data;
            }
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNytArticleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NytArticle $nytArticle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNytArticleRequest $request, NytArticle $nytArticle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NytArticle $nytArticle)
    {
        //
    }
}
