<?php
namespace mtk;

class Response{
    private $type = '';
    private $data = '';

    /**
     * @param string $type
     * @param mixed $data
     */
    private function __construct($type , $data){
        $this->type = $type;
        $this->data = $data;
    }
    /**
     * @param mixed $message
     */
    public static function createEchoResponse($message){
        $instance = new Response('echo',$message);
        return $instance;
    }

    /**
     * @param string $path
     */
    public static function createRenderResponse($path){
        $instance = new Response('render',WEBSITE_NAME."static/".$path."/index.html");
        return $instance;
    }

    public static function createNoneResponse(){
        $instance = new Response('none',"");
        return $instance;
    }

    /**
     * @param Response $response
     */
    public static function parseResponse($response){
        switch($response->type){
            case 'echo':self::execEchoResponse($response->data);break;
            case 'render':self::execRenderResponse($response->data);break;
            default:;
        }
    }

    /**
     * @param mixed $data
     */
    protected static function execEchoResponse($data){
        echo $data;
    }

    protected static function execRenderResponse($path){
        header("Location:$path");
    }

}