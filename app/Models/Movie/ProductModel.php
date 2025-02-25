<?php

namespace App\Models\Movie;

use App\Models\BackendModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductModel extends BackendModel
{
    public function __construct()
    {
        $this->table = config('constants.TABLE_MOVIE');
        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {
        if ($options['task'] == "admin-index") {
            $query = self::with('category:id,title')->orderByDesc('id')->paginate(10);
            $this->_data['items'] = $query;
        }
        return $this->_data;
    }
    public function category(){
        return $this->hasOne(CategoryModel::class,'id', 'category_id');
    }
}
