<?php
/**
 * Created by PhpStorm.
 * User: fanxinyu
 * Date: 2020-11-11
 * Time: 10:13
 */

namespace Daviswwang\MemberIn;

use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\BadRequest400Exception;
use Elasticsearch\Common\Exceptions\Curl\CouldNotResolveHostException;

class ElasticSearch
{
    CONST CLIENT = ['client' => ['ignore' => [400, 404]]];

    protected static $instances = [];

    protected $index;

    protected $instance;

    protected $connectionPool = '\Elasticsearch\ConnectionPool\StaticNoPingConnectionPool';


    public function __construct($key)
    {
        $this->instance = $this->getInstance(...$key);
    }

    public function getInstance($host, $index)
    {
        $this->index = $index;

        if (!isset(self::$instances[$index])) {

            self::$instances[$index] = ClientBuilder::create()->setHosts($host)
                ->setConnectionPool($this->connectionPool)
                ->build();
        }
        $client = self::$instances[$index];
        return $client;
    }

    public function search($body)
    {
        $esResult = $this->instance->search(['index' => $this->index, 'type' => '_doc', 'body' => $body,]);
        return $esResult;
    }

    /**
     * 创建一个doc
     * @param $body
     * @param string $index
     * @return mixed
     * @author: fanxinyu
     */
    public function index($body)
    {
        $esResult = $this->instance->index(['index' => $this->index, 'type' => '_doc', 'body' => $body]);
        return $esResult;
    }

    /**
     * 根据_id获取 array
     * @param $id
     * @param string $index
     * @return mixed
     * @author: fanxinyu
     */
    public function getSource($id)
    {
        $esResult = $this->instance->getSource(['index' => $this->index, 'type' => '_doc', 'id' => $id]);
        return $esResult;
    }

    /**
     * 根据_id删除doc
     * @param $id
     * @param string $index
     * @return mixed
     * @author: fanxinyu
     */
    public function delete($id)
    {
        $esResult = $this->instance->delete(['index' => $this->index, 'type' => '_doc', 'id' => $id]);
        return $esResult;
    }

    public function mget($id)
    {
        try {
            $esResult = $this->instance->mget(['index' => $this->index, 'type' => '_doc', 'id' => $id]);
            return $esResult;
        } catch (CouldNotResolveHostException $e) {
            $e->getPrevious();

            return false;
        }

    }

    public function putMapping($body)
    {
        $esResult = $this->instance->indices()->putMapping(['index' => $this->index, 'type' => '_doc', 'body' => $body]);

        return $esResult;
    }

    public function getMapping()
    {
        try {

            $esResult = $this->instance->indices()->getMapping(array_merge(['index' => $this->index, 'type' => '_doc'], self::CLIENT));

            return $esResult;
        } catch (CouldNotResolveHostException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * 更新部分文档（如更改现存字段，或添加新字段）
     * @param $id
     * @param array $body
     * @param string $index
     * @return mixed
     * @author: fanxinyu
     */
    public function update($id, array $body)
    {
        $esResult = $this->instance->update(array_merge(['index' => $this->index, 'type' => '_doc', 'id' => $id, 'body' => ['doc' => $body]], self::CLIENT));

        return $esResult;
    }

    public function getScrolling()
    {
        //游标查询

    }

    /**
     * 获取数据集
     * @param $body
     * @param string $index
     * @return array
     * @throws \Exception
     * @author: fanxinyu
     */
    public function searchData($body)
    {
        try {

            $esResult = $this->instance->search(['index' => $this->index, 'type' => '_doc', 'body' => $body,]);
            return $esResult['hits']['hits'] ?? [];
        } catch (BadRequest400Exception $badRequest400Exception) {
            throw new \Exception($badRequest400Exception->getMessage());
        }

    }

    public function searchOne($body, $index = 'member_use')
    {
        try {

            $esResult = $this->instance->search(['index' => $this->index, 'type' => '_doc', 'body' => $body,]);
            return $esResult['hits']['hits'] ?? [];
        } catch (BadRequest400Exception $badRequest400Exception) {
            throw new \Exception($badRequest400Exception->getMessage());
        }

    }

    /**
     * 根据条件更新数据
     * @param $body
     * @param string $index
     * @return mixed
     * @throws \Exception
     * @author: fanxinyu
     */
    public function updateByQuery($body)
    {
        try {

            $esResult = $this->instance->updateByQuery(array_merge(['index' => $this->index, 'type' => '_doc', 'body' => ['doc' => $body]], self::CLIENT));
            return $esResult;
        } catch (BadRequest400Exception $badRequest400Exception) {
            throw new \Exception($badRequest400Exception->getMessage());
        }
    }

    /**
     * 查询更新(临时)
     * @param $body
     * @param $update
     * @param string $index
     * @return bool
     * @author: fanxinyu
     */
    public function updateByWhere($body, $update, $index = 'member_use')
    {
        $esResult = $this->instance->search(['index' => $this->index, 'type' => '_doc', 'body' => $body,]);

        if (isset($esResult['hits']['hits'])) {
            foreach ($esResult['hits']['hits'] as $hit) {
                self::update($hit['_id'], $update, $this->index);
            }
            return true;
        }
        return false;
    }

    /**
     * 查询语句删除数据
     * @param $body
     * @param string $index
     * @return bool
     * @author: fanxinyu
     */
    public function deleteByQuery($body)
    {
        $esResult = $this->instance->deleteByQuery(['index' => $this->index, 'type' => '_doc', 'body' => $body]);

        if (isset($esResult['deleted'])) {
            return $esResult['deleted'];
        }
        return false;
    }

    /**
     * 批量插入数据
     * @param $body
     * @param string $index
     * @return bool
     * @author: fanxinyu
     */
    public function bulk($body)
    {
        $esResult = $this->instance->bulk(['index' => $this->index, 'type' => '_doc', 'body' => $body]);

        return true;
    }
}