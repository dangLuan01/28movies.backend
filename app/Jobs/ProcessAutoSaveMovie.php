<?php

namespace App\Jobs;

use App\Models\Movie\EpisodeModel;
use App\Models\Movie\ImageModel;
use App\Models\Movie\ProductModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProcessAutoSaveMovie implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $params;
    public function __construct($params)
    {
        $this->params   = $params;
        $this->movie    = new ProductModel();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {  
        foreach($this->params as $url){
            $item = Http::get($url)->json();
            if (preg_match('/(\d+)/', $item['movie']['episode_total'], $matchess)) {
                $episode_total = $matchess[0];
            }
            $insertGetId = ProductModel::insertGetId([
                'name'              =>  $item['movie']['name'] ?? '',
                'origin_name'       =>  $item['movie']['origin_name'] ?? '',
                'slug'              =>  $item['movie']['slug'] ?? '',
                'type_movie'        =>  $item['movie']['type'] ?? '',
                'runtime'           =>  $item['movie']['time'] ?? '',
                'quality'           =>  $item['movie']['quality'] ?? '',
                'imdb'              =>  $item['movie']['imdb']['id'] ?? '',
                'rating'            =>  $item['movie']['tmdb']['vote_average'] ?? '',
                'episode_total'     =>  $episode_total ?? '',
                //'season'            =>  $item['movie']['original_title'] ?? '',
                'trailer'           =>  $item['movie']['trailer_url'] ?? '',
                'release_date'      =>  $item['movie']['year'] ?? '',
            ]);
            ImageModel::insert([
                    'movie_id' => $insertGetId,
                    'image' => $item['movie']['thumb_url'],
            ]);  
            ImageModel::insert([
                'movie_id'      => $insertGetId,
                'image'         => $item['movie']['poster_url'],
                'is_thumbnail'  => 1
            ]);  
            foreach ($item['episodes'] as $episode) {
               foreach($episode['server_data'] as $ep){
                    EpisodeModel::insert([
                        'movie_id'      => $insertGetId,
                        'hls'           => $ep['link_m3u8'],
                        'episode'       => $ep['name'],
                        'server_name'   => $episode['server_name']
                    ]);
               } 
            }
        }
       
    }
}
