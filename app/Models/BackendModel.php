<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BackendModel extends Model
{
    protected $table            = '';
    protected $folderUpload     = '' ;
    protected $connection       = 'mysql';
    protected $crudNotAccepted  = [
                                    '_token',
                                    'prefix',
                                    'controller',
                                    'action',
                                    'as',
                                    '_method',
                                    'ID',
                                    ];
    protected $_data        = [];
    public $timestamps      = false;
    public $checkall        = true;

    public function __construct($connection = 'mysql')
    {
        $this->connection = $connection;
        $this->primaryKey = $this->columnPrimaryKey();
    }
    public function columnPrimaryKey($key = 'id')
    {
        return $key;
    }
    public function prepareParams($params)
    {
        $crudNotAccepted = [
            '_token',
            'prefix',
            'controller',
            'action',
            'as',
            '_method',
            'totalItemsPerPage'
        ];
        $crudNotAccepted = array_merge($this->crudNotAccepted, $crudNotAccepted);
        
        return array_diff_key($params, array_flip($crudNotAccepted));
    }

     public function uploadToR2($params, $r2FilePath, $image) {
       
        $fileContents = file_get_contents($image);
       
        $upload = Storage::disk('r2-' . $params['prefix'])->put($r2FilePath, $fileContents);
        
        if ($upload != 1) {
            return response()->json(array('success' => false, 'msg' => 'Upload to R2 failed!'));
        }
    
        return [
            'is_thumbnail'  => $params['media'] == 'poster' ? 0 : 1,
            'path'          => env('R2_MOVIE_URL'),
            'image'         => $r2FilePath,
        ];
    }
}

