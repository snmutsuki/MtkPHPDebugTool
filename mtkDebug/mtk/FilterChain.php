<?php
namespace mtk;

class FilterChain{
    private $chainConfig = [];
    private $filterParams = [];
    

    public function __construct($chainConfig,$filterParams = []){
        $this->chainConfig = $chainConfig;
        $this->filterParams = $filterParams;
    }

    /**
     * @return bool
     */
    public function startFilter(){
        foreach($this->chainConfig as $value){
            $filter = new $value;
            if(!$filter->doFilter($this->filterParams))return false;
        }
        return true;
    }
}