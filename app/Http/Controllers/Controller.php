<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $data = array();
    protected $current_time = '';
    protected $current_date_time = '';
    protected $repository;
    protected $ajax_response;

    public function __construct(){
        $this->data['current_time'] = $this->current_time = time();
        $this->data['current_date_time'] = $this->current_date_time = date('Y-m-d H:i:s', $this->current_time);

        if (!defined('BASE_URL')) define('BASE_URL', \URL::to('/').'/');
        
        $this->ajax_response = [
            'status' => 'error',
            'message' => __('errors.generic_error')
        ];
    }
}