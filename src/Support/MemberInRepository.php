<?php
/**
 * Created by PhpStorm.
 * User: fanxinyu
 * Date: 2020-11-11
 * Time: 16:39
 */

namespace Daviswwang\MemberIn\Support;

use ArrayAccess;
use Daviswwang\MemberIn\Facades\MemberInRepository as Repository;
use Daviswwang\MemberIn\MemberIn;

class MemberInRepository implements ArrayAccess, Repository
{
    protected $instance;

    protected function __construct(MemberIn $memberIn)
    {
        $this->instance = $memberIn;
    }

    public function search(array $body)
    {
        // TODO: Implement search() method.

        return $this->instance->search($body);

    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }
}