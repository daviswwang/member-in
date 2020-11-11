<?php
/**
 * Created by PhpStorm.
 * User: fanxinyu
 * Date: 2020-11-11
 * Time: 17:11
 */

namespace Daviswwang\MemberIn\Facades;

use Illuminate\Support\Facades\Facade;

class MemberIn extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'memberIn';
    }
}