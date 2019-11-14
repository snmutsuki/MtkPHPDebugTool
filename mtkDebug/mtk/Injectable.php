<?php
namespace mtk;

interface Injectable{
    /**
     * 获取允许使用注入的字段的数组
     * @return Array
     */
    public function getInjectFields();

    public function setInjectFields(Array $fields , bool $merge);
    /**
     * @return Array
     */
    public function getInjectFieldsEnum();
}