<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\DashboardModel;
use Illuminate\Http\Request;

class DashboardController extends AdminController
{
    protected $data = [];
    public $model;
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    public function index()
    {
        $this->model                    = new DashboardModel();
        $this->_params['listOption']    = $this->model->data;
       
        return view('dashboard.index', ['params' => $this->_params]);
    }
    public function getMovieTmdb(Request $request){
        $this->model            = new DashboardModel();
        $this->_params['items'] = $this->model->getItem($this->_params, ['task' => 'get-movie-list']);
        return response()->json(['params' => $this->_params]);
    }
}
