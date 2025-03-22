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
    public function listItem($params = null, $options = null){
        $result = null;
        if ($options['task'] == 'get-info') {
            $result = self::select($this->table . '.id', $this->table . '.name')->get();
            if ($result) {
                $result = $result->toArray();
            }
        }
        return $result;
    }
}
