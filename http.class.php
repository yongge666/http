<?php
/**
 * Created by PhpStorm.
 * User: liyong
 * Date: 2016/3/7
 * Time: 21:21
 * php+socket编程 发送http请求
 * 模拟下载，登录，批量发帖
 */

//http请求类的接口
interface proto{
    //分析url
    public function connect();

    //发送get请求
    public function get();

    //发送post请求
    public function post();

    //关闭连接
    public function close();

}

class http implements proto{
    //保存相关属性值
    protected $urlInfo=array();
    protected $line=array();
    protected $header=null;
    protected $body=null;

    //写请求行
    protected function setLine($method){
        $this->line[0]=$method.' ';

    }

    //写头信息
    protected function setHeader(){

    }

    //写主体信息
    protected function setBody(){

    }

    //分析url
    public function connect($url){

        $this->urlInfo=parse_url($url);
    }

    //发送get请求
    public function get(){
        $this->setLine('GET');

    }

    //发送post请求
    public function post(){

    }

    //关闭连接
    public function close(){

    }
}