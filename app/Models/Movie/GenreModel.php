<?php

namespace App\Models\Movie;

use App\Models\BackendModel;
use Illuminate\Database\Eloquent\Model;

class GenreModel extends BackendModel
{
    public function __construct()
    {
        $this->table = config('constants.TABLE_GENRE');
        parent::__construct();
    }
    public function getItem($params = null, $options = null){
        $result = null;
        if ($options['task'] == 'get-all-genre') {
            
            $result = self::select($this->table . '.id', $this->table . '.name')->get();
        }
        return $result;
    }
}
