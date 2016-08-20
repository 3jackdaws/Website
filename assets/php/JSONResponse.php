<?php

/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/20/16
 * Time: 1:39 PM
 */
class JSONResponse
{
    private $j_array;
    public function __construct()
    {

    }

    public function createArray($key){
        $this->j_array[$key] = [];
    }

    public function append($key, $value){
        $this->j_array[$key][] = $value;
    }

    public function appendAll($key, array $collection){
        if(is_array($this->j_array[$key])){
            foreach ($collection as $item){
                $this->j_array[$key][] = $item;
            }
            return true;
        }else{
            return false;
        }
    }

    public function set($key, $value){
        $this->j_array[$key] = $value;
    }

    public function __toString()
    {
        return json_encode($this->j_array);
    }

    public function deset($key){
        unset($this->j_array[$key]);
    }
    public function clear(){
        $this->j_array = null;
    }

    public function error($message){
        $this->j_array['error'][] = $message;
    }

    public function info($message){
        $this->j_array['info'][] = $message;
    }

}