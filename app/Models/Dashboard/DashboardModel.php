<?php

namespace App\Models\Dashboard;

use App\Models\BackendModel;
use Illuminate\Database\Eloquent\Model;

class DashboardModel extends BackendModel
{
    public function __construct()
    {
        $this->table        = TABLE_MOVIE;
        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {

        // if ($options['task'] == "admin-index") {
        //     $query = self::get();
        //     $this->_data['items'] = $query;
        // }
        return $this->_data;
    }
}
