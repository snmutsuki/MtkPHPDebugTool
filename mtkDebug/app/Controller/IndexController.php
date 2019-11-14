<?php
namespace app\Controller;

use mtk\HttpResponse;

class IndexController{
    public function index(HttpResponse $response){
        $response->redirect('hello',true);
    }
}