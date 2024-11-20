<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreGuardianArticleRequest;
use App\Http\Requests\UpdateGuardianArticleRequest;
use App\Models\GuardianArticle;

class GuardianArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $today = date("Y-m-d");
        if ($request->date) {
            $sortByPublishDate = GuardianArticle::orderBy('publication_date', $request->date)->latest()->paginate(10);
            return $sortByPublishDate;
        }
        if ($request->search) {
            $previous_search = GuardianArticle::where('keyword', '=', $request->search)->latest()->first();
            if (!empty($previous_search) && $today === date('Y-m-d', strtotime($previous_search->publication_date))) {
                return $articles = GuardianArticle::where('keyword', '=', $request->search)->latest()->paginate(10);
            } else {
                $new_date = !empty($previous_search) && $previous_search->publication_date ? date ('Y-m-d',strtotime('+1 day', strtotime($previous_search->publication_date))) : $today;
                $news= Http::get("https://content.guardianapis.com/search?from-date={$new_date}&order-by=newest&page-size=100&q={$request->search}&api-key=d01371ac-b5fd-4802-9e94-27ad04cdc29b");
                $news = json_decode($news);
                foreach ($news->response->results as $key => $article) {
                    $guardianArticle = new GuardianArticle([
                        'keyword' => $request->search,
                        'origin_id' => $article->id,
                        'type' => $article->type,
                        'section_name' => $article->sectionName,
                        'title' => $article->webTitle,
                        'web_url' => $article->webUrl,
                        'api_url' => $article->apiUrl,
                        'is_hosted' => $article->isHosted,
                        'pillar_name' => $article->pillarName,
                        'publication_date' => $article->webPublicationDate,
                    ]);
                    $guardianArticle->save();
                }
                $new_data = GuardianArticle::where('keyword', '=', $request->search)->latest()->paginate(10);
                return $new_data;
            }
        } else {
            $last_record = GuardianArticle::latest()->first();
            if ( !empty($last_record) && $last_record && $today === date('Y-m-d', strtotime($last_record->publication_date))) {
                return $articles = GuardianArticle::latest()->paginate(10);

            } else {
                $news= Http::get("https://content.guardianapis.com/search?from-date={$today}&order-by=newest&page-size=100&q=sport&api-key=d01371ac-b5fd-4802-9e94-27ad04cdc29b");
                $news = json_decode($news);
                foreach ($news->response->results as $key => $article) {
                    $guardianArticle = new GuardianArticle([
                        'keyword' => 'sport',
                        'origin_id' => $article->id,
                        'type' => $article->type,
                        'section_name' => $article->sectionName,
                        'title' => $article->webTitle,
                        'web_url' => $article->webUrl,
                        'api_url' => $article->apiUrl,
                        'is_hosted' => $article->isHosted,
                        'pillar_name' => $article->pillarName,
                        'publication_date' => $article->webPublicationDate,
                    ]);
                    $guardianArticle->save();
                }
                $new_data = GuardianArticle::where('keyword', '=', 'sport')->latest()->paginate(10);
                return $new_data;
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuardianArticleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GuardianArticle $guardianArticle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuardianArticleRequest $request, GuardianArticle $guardianArticle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuardianArticle $guardianArticle)
    {
        //
    }
}
