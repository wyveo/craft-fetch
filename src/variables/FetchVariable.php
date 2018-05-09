<?php
/**
 * Fetch plugin for Craft CMS 3.x
 *
 * Utilise the Guzzle HTTP client from within your Craft templates.
 *
 * @link      https://github.com/wyveo
 * @copyright Copyright (c) 2018 wyveo
 */

namespace wyveo\fetch\variables;

use wyveo\fetch\Fetch;

use Craft;

/**
 * @author    Colin Wilson
 * @package   Fetch
 * @since     1.0.0
 */
class FetchVariable
{
    // Public Methods
    // =========================================================================

    /**
     * @param null $optional
     * @return string
     */
    public function request($client, $method, $destination, $request = [])
    {

        $client = new \GuzzleHttp\Client($client);

        try {

          $response = $client->request($method, $destination, $request);

          return [
            'statusCode' => $response->getStatusCode(),
            'reason' => $response->getReasonPhrase(),
            'body' => json_decode($response->getBody(), true)
          ];

        } catch (\Exception $e) {

          return [
            'error' => true,
            'reason' => $e->getMessage()
          ];

        }

    }
}
