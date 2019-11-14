<?php
namespace mtk;

interface Filter{
    /**
     * @return bool
     */
    public function doFilter($params);
}