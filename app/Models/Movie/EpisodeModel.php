<?php

namespace App\Models\Movie;

use App\Jobs\ProccessAutoSaveEpisode;
use App\Models\BackendModel;
use Illuminate\Database\Eloquent\Model;

class EpisodeModel extends BackendModel
{
    protected $fillable = ['id'];
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
        if ($options['task'] == 'get-item') {
            $episodes = $this->where($this->table . '.movie_id', $params['id'])->get();
            $result = [
                'server' => $episodes->groupBy('server_id')->map(function ($serverGroup, $serverId) {
                    return [
                        'server_id' => $serverId,
                        'episodes' => [
                            'episode' => $serverGroup->pluck('episode')->toArray(),
                            'hls' => $serverGroup->pluck('hls')->toArray(),
                        ]
                    ];
                })->values()->toArray(),
            ];

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
        if ($options['task'] == 'add-item') {
            $movieId    = $params['movie_id'];
            $episodes   = $params['episodes'];
            $server_id  = $params['server_id'];
            $ep         = array_map(function ($episode, $hls) use ($movieId, $server_id) {
                return [
                    'movie_id'  => $movieId,
                    'episode'   => $episode,
                    'hls'       => $hls,
                    'server_id' => $server_id,
                ];
            }, $episodes['episode'], $episodes['hls']);
            self::insert($ep);
            $this->movie = new ProductModel();
            $this->movie->saveItem($params['movie_id'], ['task' => 'update-time']);
        }
        if ($options['task'] == 'edit-item') {
            $movieId = $params['id'];
            foreach ($params['server'] as $server) {
                // Ánh xạ episode và hls thành mảng bản ghi
                $episodes = array_map(function ($episode, $hls) use ($movieId, $server) {
                    return [
                        'movie_id'  => $movieId,
                        'server_id' => $server['server_id'],
                        'episode'   => $episode,
                        'hls'       => $hls,
                    ];
                }, $server['episodes']['episode'], $server['episodes']['hls']);
                
                foreach ($episodes as $value) {
                    // Kiểm tra bản ghi tồn tại dựa trên movie_id, server_id và episode
                    $exists = $this->where('movie_id', $value['movie_id'])
                        ->where('server_id', $value['server_id'])
                        ->where('episode', $value['episode'])
                        ->first();

                    if ($exists) {
                        // Cập nhật bản ghi nếu tồn tại
                        $exists->update([
                            'hls' => $value['hls'], // Chỉ cập nhật hls, các trường khác giữ nguyên
                        ]);
                    } else {
                        // Thêm mới bản ghi nếu không tồn tại
                        $this->insert($value);
                    }
                }
            }
            return response()->json(['message' => 'Episodes updated successfully']);

        }
    }
}
