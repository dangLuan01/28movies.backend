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
    public function saveItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'add-item') {
           
            if ($params['is_thumbnail'] == 0) {
                $image_poster   = request()->file('image_poster');
                $image_name     = $params['slug'] . '-poster-' . time() . '.' . $image_poster->getClientOriginalExtension();
            }
            else {
                $image_poster   = request()->file('image_thumb');
                $image_name     = $params['slug'] . '-thumb-' . time() . '.' . $image_poster->getClientOriginalExtension();
            }
            $image_poster->move(public_path('uploads/movies/'), $image_name);
            $params['image'] = $image_name;
            $result          = [
                'movie_id'      => $params['insert_id'],
                'image'         => $params['image'],
                'path'          => '/uploads/movies/',
                'is_thumbnail'  => $params['is_thumbnail'],
            ];
            $this->insert($result);
            return response()->json(array('success' => true, 'msg' => 'Thêm yêu cầu thành công!'));
        }  
    }
}
