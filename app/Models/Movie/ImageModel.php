<?php

namespace App\Models\Movie;

use App\Models\BackendModel;
use Illuminate\Database\Eloquent\Model;

class ImageModel extends BackendModel
{
    public function __construct()
    {
        $this->table = config('constants.TABLE_MOVIE_IMAGE');
        parent::__construct();
    }
}
