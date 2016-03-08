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
interface Proto{
    //分析url
    public function connect($url);//子类必须带参数

    //发送get请求
    public function get();

    //发送post请求
    public function post();

    //关闭连接
    public function close();

}

class Http implements Proto{
    //声明换行符
    const CRLF = '\r\n'; //(carriage return line feed)
    //保存相关属性值
    protected $urlInfo=array();
    protected $version = 'HTTP/1.1';
    protected $line=array();
    protected $header=null;
    protected $body=null;
    protected $fh=null;

    protected $errno=null;
    protected $errstr=null;
    protected $outtime=3;

    protected $response;

    public function __construct($url)
    {
        $this->connect($url);
        $this->setHeader('Host: '.$this->urlInfo['host']);
    }

    //构造请求行
    protected function setLine($method){
        $this->line[0]=$method.' '.$this->urlInfo['path'].' '.$this->version;

    }

    //构造头信息
    protected function setHeader($headerLine){
        $this->header[]=$headerLine;
    }

    //构造主体信息
    protected function setBody(){

    }

    //分析和连接url
    public function connect($url){

        $this->urlInfo=parse_url($url);
        //scheme - 如 http,host,port,user,pass,path,query - 在问号 ? 之后,fragment - 在散列符号 # 之后
        //判断端口
        if(!isset($this->urlInfo['port'])){
            $this->urlInfo['port'] = 80;
        }
        //连接url
        $this->fh = fsockopen($this->urlInfo['host'],$this->urlInfo['port'],$this->errno,$this->errstr,$this->outtime);
    }

    //构造get请求发送的数据
    public function get(){
        $this->setLine('GET');
        $this->request();
        return $this->response;
        echo $this->setLine('GET');

    }

    //构造post请求发送的数据
    public function post(){

    }

    //发送请求
    public function request(){
        //把请求行，头信息，实体信息，放在一个数组里，便于拼接
        $req = array_merge($this->line,$this->header,array(),$this->body,array());
        $req = implode(self::CRLF,$req);
        fwrite($this->fh,$req);
        while(!feof($this->fh)){
           $this->response .= fread($this->fh,1024);
        }

        $this->close();
        //return $this->response;
        print_r($req);
    }
  //关闭连接
    public function close(){

    }


}

$url = 'http://news.163.com/16/0308/19/BHLJJ94H00014PRF.html';
$http = new Http($url);
echo $http->get();
var_dump($http);
