<?php

class Application {

    private $defaultController = 'site';
    private $defaultActionFix = 'action';
    private $defaultAction = 'index';

    public function __construct($param = array()) {
        foreach ($param as $key => $value) {
            $this->$key = $value;
        }
    }

    public function run() {
        $route = null;
        $param = array();
        if (isset($_GET['c'])) {
            $route = $_GET['c'];
            foreach ($_GET as $key => $value) {
                $key !== 'c' ? $param[$key] = $value : null;
            }
        }
        $routeArr = $this->processRoute($route);
        $this->runController($routeArr, $param);
    }

    private function processRoute($route = null) {
        $routeArr = explode('/', $route);
        $routeArr[0] = !empty($routeArr[0]) ? ucwords($routeArr[0]) : ucwords($this->defaultController);
        $routeArr[1] = $this->defaultActionFix . (!empty($routeArr[1]) ? $routeArr[1] : $this->defaultAction);
        return $routeArr;
    }

    private function runController($routeArr = array(), $param = array()) {
        if (class_exists($routeArr[0])) {
            $controller = new $routeArr[0];
            $action = $routeArr[1];
            return call_user_func_array(array($controller,$action),$param);
        }else{
            throw new Exception('Sorry,Controller not exists!',404);
        }
    }

}
