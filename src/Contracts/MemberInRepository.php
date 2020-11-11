<?php
/**
 * Created by PhpStorm.
 * User: fanxinyu
 * Date: 2020-11-11
 * Time: 16:32
 */

namespace Daviswwang\MemberIn\Facades;

interface MemberInRepository
{
    public function search(array $body);
}