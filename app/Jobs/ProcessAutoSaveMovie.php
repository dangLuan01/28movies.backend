<?php

namespace App\Jobs;

use App\Models\Movie\EpisodeModel;
use App\Models\Movie\GenreModel;
use App\Models\Movie\ImageModel;
use App\Models\Movie\MovieGenreModel;
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
    public $tries = 3;
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
            $item = Http::get($this->params)->json();
            if (empty($item['movie'])) {
                return;
            }
            $movie = $item['movie'];
            $episode_total = !empty($movie['episode_total']) && preg_match('/(\d+)/', $movie['episode_total'], $matches)
                ? $matches[0]
                : 0;
            $insertGetId = ProductModel::insertGetId([
                'name'          => data_get($movie, 'name', ''),
                'origin_name'   => data_get($movie, 'origin_name', ''),
                'slug'          => data_get($movie, 'slug', ''),
                'type_movie'    => data_get($movie, 'type', ''),
                'runtime'       => data_get($movie, 'time', ''),
                'quality'       => data_get($movie, 'quality', ''),
                'imdb'          => data_get($movie, 'imdb.id', ''),
                'tmdb'          => data_get($movie, 'tmdb.id', ''),
                'rating'        => data_get($movie, 'tmdb.vote_average', ''),
                'episode_total' => $episode_total,
                'season'        => data_get($movie, 'tmdb.season', ''),
                'trailer'       => data_get($movie, 'trailer_url', ''),
                'release_date'  => data_get($movie, 'year', ''),
            ]);
            if (!empty($movie['category'])) {
                $categorySlugs  = collect($movie['category'])->pluck('slug')->toArray();
                $existingGenres = GenreModel::whereIn('slug', $categorySlugs)->pluck('id', 'slug');
                $newGenres      = [];
                $movieGenres    = [];
    
                foreach ($movie['category'] as $genre) {
                    if (isset($existingGenres[$genre['slug']])) {
                        $movieGenres[] = [
                            'movie_id' => $insertGetId,
                            'genre_id' => $existingGenres[$genre['slug']],
                        ];
                    } else {
                        $newGenres[] = [
                            'name' => $genre['name'],
                            'slug' => $genre['slug'],
                        ];
                    }
                }
    
                if (!empty($newGenres)) {
                    GenreModel::insert($newGenres);
                    $insertedGenres = GenreModel::whereIn('slug', collect($newGenres)->pluck('slug'))->pluck('id', 'slug');
    
                    foreach ($newGenres as $genre) {
                        $movieGenres[] = [
                            'movie_id' => $insertGetId,
                            'genre_id' => $insertedGenres[$genre['slug']],
                        ];
                    }
                }
    
                MovieGenreModel::insert($movieGenres);
            }
            $images = [
                ['movie_id' => $insertGetId, 'image' => data_get($movie, 'thumb_url', '')],
                ['movie_id' => $insertGetId, 'image' => data_get($movie, 'poster_url', ''), 'is_thumbnail' => 1],
            ];
            ImageModel::insert($images);
            if (!empty($item['episodes'])) {
                $episodes = [];
                foreach ($item['episodes'] as $episode) {
                    if (!empty($episode['server_data'])) {
                        foreach ($episode['server_data'] as $ep) {
                            $episodes[] = [
                                'movie_id'   => $insertGetId,
                                'hls'        => data_get($ep, 'link_m3u8', ''),
                                'episode'    => data_get($ep, 'name', ''),
                                'server_id'  => 1,
                            ];
                        }
                    }
                }
    
                if (!empty($episodes)) {
                    EpisodeModel::insert($episodes);
                }
            }
            // $item = Http::get($this->params)->json();
            // if (preg_match('/(\d+)/', $item['movie']['episode_total'], $matchess)) {
            //     $episode_total = $matchess[0];
            // }
            // $insertGetId = ProductModel::insertGetId([
            //     'name'              =>  $item['movie']['name'] ?? '',
            //     'origin_name'       =>  $item['movie']['origin_name'] ?? '',
            //     'slug'              =>  $item['movie']['slug'] ?? '',
            //     'type_movie'        =>  $item['movie']['type'] ?? '',
            //     'runtime'           =>  $item['movie']['time'] ?? '',
            //     'quality'           =>  $item['movie']['quality'] ?? '',
            //     'imdb'              =>  $item['movie']['imdb']['id'] ?? '',
            //     'tmdb'              =>  $item['movie']['tmdb']['id'] ?? '',
            //     'rating'            =>  $item['movie']['tmdb']['vote_average'] ?? '',
            //     'episode_total'     =>  $episode_total ?? '',
            //     'season'            =>  $item['movie']['tmdb']['season'] ?? '',
            //     'trailer'           =>  $item['movie']['trailer_url'] ?? '',
            //     'release_date'      =>  $item['movie']['year'] ?? '',
            // ]);
            // foreach($item['movie']['category'] as $genre){
            //     $exitingGenre = GenreModel::where('slug', $genre['slug'])->first();
            //     if ($exitingGenre) {
            //         MovieGenreModel::insert([
            //             'movie_id' => $insertGetId,
            //             'genre_id' => $exitingGenre['id']
            //         ]);
            //     }else{
            //         $newGenre = GenreModel::insertGetId([
            //             'name'  => $genre['name'],
            //             'slug'  => $genre['slug']
            //         ]);
            //         MovieGenreModel::insert([
            //             'movie_id' => $insertGetId,
            //             'genre_id' => $newGenre
            //         ]);
            //     }
            // }
            // ImageModel::insert([
            //     'movie_id'  => $insertGetId,
            //     'image'     => $item['movie']['thumb_url'] ?? '',
            // ]);  
            // ImageModel::insert([
            //     'movie_id'      => $insertGetId,
            //     'image'         => $item['movie']['poster_url'] ?? '',
            //     'is_thumbnail'  => 1
            // ]);  
            // foreach ($item['episodes'] as $episode) {
            //    foreach($episode['server_data'] as $ep){
            //         EpisodeModel::insert([
            //             'movie_id'      => $insertGetId,
            //             'hls'           => $ep['link_m3u8'] ?? '',
            //             'episode'       => $ep['name'] ?? '',
            //             'server_id'     => 1
            //         ]);
            //    } 
            // }
    }
}
