<?php
namespace mtk;

use \Exception;

abstract class HttpFilter implements Filter{
    /**
     * 本方法只过滤request和response两个参数
     * @return bool
     */
    public function doFilter($params){
        if(isset($params['request']) && isset($params['response'])){
            return $this->doHttpFilter($params['request'],$params['response']);
        }
        throw new Exception("HttpFilter need param called 'request' and 'response'");      
    }
    /**
     * @return bool
     */
    protected abstract function doHttpFilter(HttpRequest $request , HttpResponse $response); 
}