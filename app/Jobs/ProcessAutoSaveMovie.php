<?php

namespace App\Jobs;

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
        $this->table    = config('constants.TABLE_MOVIE');
        $this->movie    = new ProductModel();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $list = Http::withHeaders([
            'Authorization' => env('TMDB_TOKEN'),
            'accept' => 'application/json'
        ])->get($this->params['url'])->json();
       
        foreach($list['results'] as $movie){
           $exiting =  $this->movie->where($this->table . '.name_english',$movie['original_title'])->first();
           if ($exiting != null) {
                $this->movie->insert([
                        'name'=>$movie['original_title'],
                        'release_date' => $movie['release_date'],
                        'rating' => $movie['vote_average'],
                ]);
           }
            // ProductModel::insert([
            //     'name'=>$movie['original_title'],
            //     'release_date' => $movie['release_date'],
            //     'rating' => $movie['vote_average'],
            // ]);
            
        }
    }
}
