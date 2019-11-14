<?php
namespace mtk;

class HttpResponseSender extends ResponseSender{
    public function send(){
        foreach($this->response->getHeader() as $key => $value){
            header($key.":".$value);
        }
        echo $this->response->getData();
    }
}