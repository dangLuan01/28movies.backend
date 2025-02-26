<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
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
         return view('dashboard.index', ['params' => $this->_params]);
    }
}
