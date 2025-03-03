<?php

namespace App\Models\Movie;

use App\Models\BackendModel;
use Illuminate\Database\Eloquent\Model;

class ServerModel extends BackendModel
{
    public function __construct()
    {
        $this->table = config('constants.TABLE_SERVER');
        parent::__construct();
    }
}
