<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PzkXml {
    public static function parse($doc) {
        // neu obj la mot dom document
        if (is_a($obj, 'DOMDocument')) {
            return self::parse($obj->documentElement);

            // neu obj la mot dom node
        } else if (is_a($obj, 'DOMElement')) {
            return self::parseNode($obj);

            // neu obj la mot string
        } else if (is_string($obj)) {
            // neu obj la mot duong dan den file
            if (!preg_match('/[\<\>]/', $obj) && $filePath = self::getFilePath($obj . '.php')) {
                return self::parseFile($obj);
            }
            return self::parseDocument($obj);
        } else if (is_array($obj)) {
            return self::parseArray($obj);
        }
    }
    
    public static function getFilePath($obj, $dirs = '.') {
        if (strpos($obj, '<') !== FALSE) {
            return false;
        }
        foreach (explode('|', $dirs) as $dir) {
            $filePath = BASE_DIR . '/' . $dir . '/' . $obj;
            if (isset($_REQUEST['showParse']) && $_REQUEST['showParse'])
                echo $filePath . '<br />';
            if (file_exists($filePath)) {
                return $filePath;
            }
        }
    }
}