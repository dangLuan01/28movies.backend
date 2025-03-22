<?php

namespace App\Models\Movie;

use App\Models\BackendModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductModel extends BackendModel
{
    protected $fillable = ['id'];
    public $crudNotAccepted = ['genre'];    
    public function __construct()
    {
        $this->table = config('constants.TABLE_MOVIE');
        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {
        if ($options['task'] == "admin-index") {
            $query = self::with('poster')->paginate(10);
            $this->_data['items'] = $query;
        }
        return $this->_data;
    }
    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item-info') {
            
            $result = self::with('images', 'genres')->where($this->table . '.id', $params['id'])->first();
            // if ($result) {
            //     $result = $result->toArray();
            // }
        }
        return $result;
    }
    public function saveItem($params = null, $options = null){
        if ($options['task'] == 'add-item') {
            // $params['created_at'] = date('Y-m-d H:i:s');

            // $this->genres()->sync($params['genre']);
            // $this->insert($this->prepareParams($params));
            return response()->json(array('success' => true, 'msg' => 'Thêm yêu cầu thành công!'));
        }
        if ($options['task'] == 'edit-item') {
          
           $params['updated_at'] = date('Y-m-d H:i:s');
           $this->genres()->sync($params['genre']);
           $this->where($this->primaryKey, $params[$this->primaryKey])
                ->update($this->prepareParams($params));
           return response()->json(array('success' => true, 'msg' => 'Cập nhật yêu cầu thành công!'));
        }
        if ($options['task'] == 'change-status') {
            $status = ($params['status'] == "1") ? '0' : '1';
            self::where($this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])->update(['status' => $status]);
        }
    }
    public function category(){
        return $this->hasOne(CategoryModel::class,'id', 'category_id');
    }
    public function poster(){
        return $this->hasMany(ImageModel::class,'movie_id', 'id')->where('is_thumbnail', 0);
    }
    public function images(){
        return $this->hasMany(ImageModel::class,'movie_id', 'id');
    }
    public function genres(){
       return $this->belongsToMany(GenreModel::class, config('constants.TABLE_MOVIE_GENRE'), 'movie_id', 'genre_id');
    }
}
