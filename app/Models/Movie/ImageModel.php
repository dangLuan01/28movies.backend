<?php

namespace App\Models\Movie;

use App\Models\BackendModel;
use Illuminate\Database\Eloquent\Model;
use Tes\LaravelGoogleDriveStorage\GoogleDriveService;

class ImageModel extends BackendModel
{
    public function __construct()
    {
        $this->table = config('constants.TABLE_MOVIE_IMAGE');
        parent::__construct();
    }
       
    
    public function saveItem($params = null, $options = null)
    {
        $path = 'https://drive.google.com/uc?id=';
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
            $image_poster->move(public_path('uploads/files/'), $image_name);
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
        if ($options['task'] == 'edit-item') {
            $result = [];
            $images   = request()->file('image');
           
            foreach ($images as $params['media'] => $image) {
                $r2FilePath = '/' . $params['controller'] . '/' . $params['media'] . '/' . $params['slug'] . '-' . time() . '.' . $image->extension();
                $result[] =  $this->uploadToR2($params, $r2FilePath, $image);
            }
            
            if ($result != []) {
                foreach ($result as $re) {
                    $this->where('movie_id', $params['id'])->where('is_thumbnail', $re['is_thumbnail'])
                        ->update([
                            'image' => $re['image'], 
                            'path'  => $re['path']
                        ]);
                }    
            }
            
            if ($result[0]['is_thumbnail'] == 0) {
                $url = $result[0]['path'] . $result[0]['image'];    

                return $url;
            }
        }  
    }
}
