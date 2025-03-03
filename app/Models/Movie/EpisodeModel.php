<?php

namespace App\Models\Movie;

use App\Models\BackendModel;
use Illuminate\Database\Eloquent\Model;

class EpisodeModel extends BackendModel
{
    public function __construct()
    {
        $this->table = config('constants.TABLE_EPISODE');
        parent::__construct();
    }
}
