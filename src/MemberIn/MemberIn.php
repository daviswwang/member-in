<?php
/**
 * Created by PhpStorm.
 * User: fanxinyu
 * Date: 2020-11-11
 * Time: 10:11
 */

namespace Daviswwang\MemberIn;

class MemberIn
{
    protected $instance;

    public function __construct($key)
    {
        $this->instance = new ElasticSearch($key);
    }

    public function search($body)
    {
        return $this->instance->search($body);
    }


}