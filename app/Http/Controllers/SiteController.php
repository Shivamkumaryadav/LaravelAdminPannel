<?php
namespace App\Http\Controllers;

use App\Models\Image;

class SiteController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index() {
        $this->data['images'] = Image::get()->toArray();
        return view('index', $this->data);
    }
}
