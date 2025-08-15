<?php

namespace App\Http\Controllers\Streaming;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Streaming\StreamingModel;

class StreamingController extends AdminController
{
    public $model;
    
    public function __construct(Request $request)
    {
        $this->model   = new StreamingModel();
        parent::__construct($request);
    }
    public function index(Request $request)
    {
        //$this->_params["item-per-page"]     = $this->getCookie('-item-per-page', 25);
        $this->_params['model']             = $this->model->listItem($this->_params, ['task' => "admin-index"]);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
     public function create(){
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(Request $request){
        $this->model->saveItem($this->_params, ['task' => 'add-item']);
        return response()->json(array('success' => true, 'message' => 'Thêm thành công'));
    }

    public function edit($id){
        $this->_params['id'] = $id;
        $this->_params['item'] = $this->model->getItem($this->_params, ['task'=> 'get-info']);
        return(view($this->_viewAction, ['params' => $this->_params]));
    }

    public function update(Request $request){
        if (isset($this->_params['_method']) && $this->_params['_method'] == 'PUT') {
            $this->model->saveItem($this->_params, ['task' => 'edit-item']);
        }
        
        return response()->json(array('success' => true, 'message' => 'Thêm thành công'));
    }
}
