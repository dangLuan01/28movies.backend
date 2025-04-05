<?php

namespace App\Http\Controllers\Movie;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Models\Movie\CrawlerModel;
use App\Models\Movie\EpisodeModel;
use App\Models\Movie\ProductModel;
use Illuminate\Http\Request;

class EpisodeController extends AdminController
{
    protected $data = [];
    public $model;
    public function __construct(Request $request)
    {
        $this->model   = new EpisodeModel();
        parent::__construct($request);
    }
    public function create(){
        $this->movie = new ProductModel();
        $this->_params['movie'] = $this->movie->listItem($this->_params, ['task' => 'list-item']);
        
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function crawler(){
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function crawlerData(Request $request){
        $this->crawler = new CrawlerModel();
        $this->_params['movies']  = $this->crawler->listItem($this->_params, ['task' => 'crawler-data-episode']);
        
        return response()->json(['data' => $this->_params['movies']]);
    }
    public function storeCrawler(Request $request){
        $this->model->saveItem($this->_params, ['task' => 'add-item-crawler']);
        return response()->json(array('success' => true, 'message' => 'Thêm thành công'));
        
    }
}
