<?php
namespace Report\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        echo $_SERVER['SERVER_NAME'];
    }
}