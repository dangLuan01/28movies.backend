<?php

namespace App\Models\Movie;

use App\Jobs\ProccessAutoSaveEpisode;
use App\Models\BackendModel;
use Illuminate\Database\Eloquent\Model;

class EpisodeModel extends BackendModel
{
    public function __construct()
    {
        $this->table = config('constants.TABLE_EPISODE');
        parent::__construct();
    }
    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item-info') {
           
            $result = $this->where('movie_id', $params)->count();
        }
        return $result;
    }
    public function saveItem($params = null, $options = null){
        if ($options['task'] == 'add-item-crawler') {
           
            if (!empty($params['movies'])) {
                $params['movies']   = json_decode($params['movies'], true);
                $params['urls']     = array_map(function ($movie) {
                    return [
                        'url'       => 'https://ophim1.com/phim/' . $movie['slug'],
                        'movie_id'  => $movie['movie_id'],
                    ];
                }, $params['movies']);
                foreach ($params['urls'] as $url) {
                    ProccessAutoSaveEpisode::dispatch($url['url'], $url['movie_id']);
                }  
            }
        }
    }
}
