<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class BaseController extends Controller{
    public function seo($titre="Lumimories",$meta_description="Lumimories",$meta_keywords="Lumimories",$meta_image=""){
        View::share('title',$titre);
        View::share('meta_description',$meta_description);
        View::share('meta_keywords',$meta_keywords);
        View::share('meta_image',$meta_image);
    }
}
