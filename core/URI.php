<?php

class PzkURI {

    public $rsegments;
    public $segments;
    public $uri;
    public static $inst = false;
    public $dispatchMode = 'directed'; // cms, default

    public function PzkURI($uri = false) {
        if (!REQUEST_MODE)
            $this->set($uri);
    }

    /**
     * Thiet lap duong dan cho uri
     * @return void 
     */
    public function set($uri = false) {
        if ($uri) {
            $this->uri = $uri;
        } else {
            if (isset($_SERVER['REQUEST_URI']))
                $this->uri = $_SERVER['REQUEST_URI'];
            else
                $this->uri = $_SERVER['ORIG_PATH_INFO'];
        }

        $uries = explode('?', $this->uri);
        $this->uri = $uries[0];
        $this->rsegments = explode('/', $this->uri);
        $this->segments = array_slice($this->rsegments, ROUTE_START_INDEX);
    }

    /**
     * Quyet dinh ung dung can chay
     * Chay he thong
     * @return void;
     */
    public function dispatch() {
        require_once BASE_DIR . '/lib/condition.php';
        // neu dang chay trong che do duong dan than thien
        if (!REQUEST_MODE) {

            // neu dang chay duong dan goc
            if (!@$this->segments[0]) {
                array_unshift($this->segments, PZK_DEFAULT_APP);
            }

            // neu chua co tham so ve ung dung dang chay
            if (!$this->existsSource(@$this->segments[0])) {
                array_unshift($this->segments, PZK_DEFAULT_APP);
            }

            // lay thong tin ung dung
            $this->app = $_REQUEST['app'] = pzk_or(@$_REQUEST['app'], @$this->segments[0]);

            $segs = array_slice($this->segments, 1);
            $segCount = count($segs);
            // tim xem co phan trang khong
            if ($segCount) {
                $lastSeg = $segs[$segCount - 1];
                $match = array();
                if (preg_match('/trang-([\d]+)/', $lastSeg, $match)) {
                    array_pop($segs);
                    $_REQUEST['pageNum'] = $match[1];
                }
            }
            $_REQUEST['route'] = implode('/', $segs);
        }
    }

    /**
     * Kiem tra xem app hoac page co ton tai ko
     */
    public function existsSource($app, $page = false) {
        if ($page) {
            $fileName = "app/$app/pages/$page.php";
        } else {
            $fileName = "app/$app";
        }
        return file_exists(BASE_DIR . '/' . $fileName) || is_dir($fileName);
    }

    /**
     * @return PzkURI
     */
    public static function instance() {
        if (!self::$inst) {
            self::$inst = new PzkURI();
        }
        return self::$inst;
    }

}

?>