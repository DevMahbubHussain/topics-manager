<?php 

namespace TopicsManager\MVC;

use TopicsManager\MVC\Controller\BookController;
use TopicsManager\MVC\Models\BookModel;
use TopicsManager\MVC\Services\BookService;

class Bootstrap{
 public static function init(){
    $model = new BookModel();
    $service = new BookService($model);
    $controller = new BookController($service);

 }

}