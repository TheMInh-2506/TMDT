<?php
    class App{
        protected $controller = 'TrangChu';
        protected $method = 'display';
        protected $params = array();

        function __construct(){
            $url = $this->parseURL();
            
            if(isset($url[0]) && file_exists('./mvc/controller/'.$url[0].'.php')){
                $this->controller = $url[0];
                unset($url[0]);
            }
            
            require_once('./mvc/controller/'.$this->controller.'.php');
            
            $this->controller = new $this->controller;

            if(isset($url[1])){
                if(method_exists($this->controller,$url[1])){
                    $this->method = $url[1];
                }
                unset($url[1]);
            }


            $this->params = $url ? array_values($url):array();

            call_user_func_array([$this->controller,$this->method],$this->params);
        }

        function parseURL(){
            if(isset($_GET['url'])){
                return explode('/',trim($_GET['url']));
            }
        }
    }

?>