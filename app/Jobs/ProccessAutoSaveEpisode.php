<?php

namespace App\Jobs;

use App\Models\Movie\EpisodeModel;
use App\Models\Movie\ProductModel;
use App\Models\Movie\ServerModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProccessAutoSaveEpisode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $params;
    protected $movie_id;
    public $tries = 3;
    public function __construct($params, $movie_id)
    {
        $this->params       = $params;
        $this->movie_id     = $movie_id;
        $this->episode      = new EpisodeModel();
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $item = Http::get($this->params)->json();

        if (empty($item['movie'])) {
            return;
        }

        // $serverData = $item['episodes'][0]['server_data'] ?? [];
        // $existingEpisodes = EpisodeModel::where('movie_id', $this->movie_id)
        //                     ->pluck('episode')
        //                     ->toArray();

        // $newEpisodes = [];
        // foreach ($serverData as $episode) {
        //     if (!in_array($episode['slug'], $existingEpisodes)) {
        //         $newEpisodes[] = [
        //             'movie_id'  => $this->movie_id,
        //             'episode'   => $episode['slug'],
        //             'hls'       => data_get($episode, 'link_m3u8', ''),
        //             'server_id' => 1,
        //         ];
        //     }
        //     else {
        
        //         // Update existing episode if needed
        //         EpisodeModel::where('movie_id', $this->movie_id)
        //             ->where('episode', $episode['slug'])
        //             ->update([
        //                 'hls' => data_get($episode, 'link_m3u8', ''),
        //                 'server_id' => 1,
        //             ]);
        //         ProductModel::where('id', $this->movie_id)
        //             ->update([
        //                 'updated_at' => date('Y-m-d H:i:s')
        //             ]);
        //     }
        // }
        // if (!empty($newEpisodes)) {
        //     EpisodeModel::insert($newEpisodes);
        // }
        $episodesArray = $item['episodes'] ?? [];

        foreach ($episodesArray as $server) {
            $serverName = $server['server_name'] ?? 'Unknown';

            $existingServer = ServerModel::where('name', $serverName)->first();
            if ($existingServer) {
                $serverId = $existingServer->id;
            } else {
                $serverId = ServerModel::insertGetId([
                    'name' => $serverName,
                ]);
            }

            $serverData = $server['server_data'] ?? [];

            $existingEpisodes = EpisodeModel::where('movie_id', $this->movie_id)->where('server_id', $serverId)
                                ->pluck('episode')
                                ->toArray();

            $newEpisodes = [];

            foreach ($serverData as $episode) {
                if (!in_array($episode['slug'], $existingEpisodes)) {

                    $newEpisodes[] = [
                        'movie_id'   => $this->movie_id,
                        'episode'    => $episode['slug'],
                        'hls'        => data_get($episode, 'link_m3u8', ''),
                        'server_id'  => $serverId,
                    ];
                } else {

                    EpisodeModel::where('movie_id', $this->movie_id)
                        ->where('episode', $episode['slug'])
                        ->where('server_id', $serverId)
                        ->update([
                            'hls'       => data_get($episode, 'link_m3u8', ''),
                            'server_id' => $serverId,
                        ]);

                    ProductModel::where('id', $this->movie_id)
                        ->update([
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                }
            }

            if (!empty($newEpisodes)) {
                EpisodeModel::insert($newEpisodes);
            }
        }

    }

}
