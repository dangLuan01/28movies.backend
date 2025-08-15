<?php

namespace App\Models\Streaming;

use App\Models\BackendModel;
use Tes\LaravelGoogleDriveStorage\GoogleDriveService;

class StreamingModel extends BackendModel
{
    public function __construct()
    {
        $this->table = config('constants.TABLE_STREAMING');
        parent::__construct();
    }

    public function listItem($params = null, $options = null){
        if ($options['task'] == 'admin-index') {
            $result = $this->paginate(20);
            if ($result) {
                $this->_data['items']   = $result;
                $this->_data['total']   = $result->total();
            }
        }
        return $this->_data;
    }

    public function getItem($params = null, $options = null) {
        if ($options['task'] == 'get-info') {
            $result = $this->find($params['id']);
            if ($result) {
                $this->_data = $result->toArray();
            }
        }
        return $this->_data;
    }

    public function saveItem ($params = null, $options = null){
        
        $result = null;
        if ($options['task'] == 'add-item') {

            $file   = request()->file('hls');
           
            $reponse = GoogleDriveService::uploadFile($file, env('GOOGLE_DRIVE_FOLDER_ID_STREAMING'));
            if (!$reponse->id) {
                return response()->json(array('success' => false, 'msg' => 'Thêm yêu cầu thất bại!'));
            }

            $result = [
                'name'  =>  $params['name'],
                'url'   =>  $reponse->id,
            ];
            $this->insert($result);

            return response()->json(array('success' => true, 'msg' => 'Thêm yêu cầu thành công!'));
        }
        if ($options['task'] == 'edit-item') {
            $file       = request()->file('hls');
            $reponse    = GoogleDriveService::uploadFile($file, env('GOOGLE_DRIVE_FOLDER_ID_STREAMING'));
            if (!$reponse->id) {
                return response()->json(array('success' => false, 'msg' => 'Thêm yêu cầu thất bại!'));
            }

            $result = [
                'name'  =>  $params['name'],
                'url'   =>  $reponse->id,
            ];

            $this->where($this->table . '.id', $params['id'])->update($result);
            return response()->json(array('success' => true, 'msg' => 'Thêm yêu cầu thành công!'));
        }
    }
}
