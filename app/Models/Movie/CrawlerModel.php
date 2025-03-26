<?php

namespace App\Models\Movie;

use App\Models\BackendModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class CrawlerModel extends BackendModel
{
    public function __construct()
    {
        $this->table = config('constants.TABLE_MOVIE');
        parent::__construct();
    }
    public function listItem($params = null, $options = null){
        $result = null;
        if ($options['task'] == 'crawler-data') {
            if (!empty($params['page_from']) && !empty($params['page_to'])) {
                $responses = Http::pool(fn ($pool) => 
                    array_map(fn ($i) => $pool->get($params['url'] . '?page=' . $i), range($params['page_from'], $params['page_to']))
                );
                $result = array_merge(...array_map(fn ($response) => 
                    array_column(optional($response->json())['items'] ?? [], '_id'), $responses
                ));
            }
            
            $baseUrl    = 'https://ophim1.com/phim/id/';
            $responses  = Http::pool(fn ($pool) => 
                collect($result)->map(fn ($id) => $pool->get($baseUrl . $id))->all()
            );
            $movies = collect($responses)->map(fn ($response) => [
                'id'        => optional($response->json())['movie']['_id'] ?? null,
                'name'      => optional($response->json())['movie']['name'] ?? null,
                'slug'      => optional($response->json())['movie']['slug'] ?? null,
                'existed'   => 0,
            ])->filter(fn ($movie) => !empty($movie['id']) && !empty($movie['slug']))->values()->all();
            
            $existingSlugs = self::whereIn('slug', array_column($movies, 'slug'))->pluck('slug')->toArray();
            $existingSlugs = array_flip($existingSlugs);
            
            foreach ($movies as &$movie) {
                if (isset($existingSlugs[$movie['slug']])) {
                    $movie['existed'] = 1;
                }
            }
            $result = $movies;
        }
        return $result;
    }
}
