<?php
/**
 * Elasticsearch PHP client
 *
 * @link      https://github.com/elastic/elasticsearch-php/
 * @copyright Copyright (c) Elasticsearch B.V (https://www.elastic.co)
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license   https://www.gnu.org/licenses/lgpl-2.1.html GNU Lesser General Public License, Version 2.1 
 * 
 * Licensed to Elasticsearch B.V under one or more agreements.
 * Elasticsearch B.V licenses this file to you under the Apache 2.0 License or
 * the GNU Lesser General Public License, Version 2.1, at your option.
 * See the LICENSE file in the project root for more information.
 */
declare(strict_types = 1);

namespace Elasticsearch\Endpoints\Ml;

use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class GetDataFrameAnalyticsStats
 * Elasticsearch API name ml.get_data_frame_analytics_stats
 * Generated running $ php util/GenerateEndpoints.php 7.9
 */
class GetDataFrameAnalyticsStats extends AbstractEndpoint
{

    public function getURI(): string
    {
        $id = $this->id ?? null;

        if (isset($id)) {
            return "/_ml/data_frame/analytics/$id/_stats";
        }
        return "/_ml/data_frame/analytics/_stats";
    }

    public function getParamWhitelist(): array
    {
        return [
            'allow_no_match',
            'from',
            'size'
        ];
    }

    public function getMethod(): string
    {
        return 'GET';
    }
}
