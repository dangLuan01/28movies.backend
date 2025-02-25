<?php

namespace App\Http\Controllers\Movie;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Models\Movie\ProductModel;
use Illuminate\Http\Request;

class ProductController extends AdminController
{
    
    protected $data = [];
    public $model;
    public function __construct(Request $request)
    {
        $this->model = new ProductModel();
        parent::__construct($request);
    }
    public function index(Request $request)
    {
        //$this->_params["item-per-page"]     = $this->getCookie('-item-per-page', 25);
        $this->_params['model']             = $this->model->listItem($this->_params, ['task' => "admin-index"]);
         return view($this->_viewAction, ['params' => $this->_params]);
    }
}
