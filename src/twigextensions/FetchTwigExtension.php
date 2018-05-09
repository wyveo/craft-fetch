<?php
/**
 * Fetch plugin for Craft CMS 3.x
 *
 * Utilise the Guzzle HTTP client from within your Craft templates.
 *
 * @link      https://github.com/wyveo
 * @copyright Copyright (c) 2018 wyveo
 */

namespace wyveo\fetch\twigextensions;

use wyveo\fetch\Fetch;

use Craft;

/**
* @author    Colin Wilson
* @package   Fetch
* @since     1.0.0
*/
class FetchTwigExtension extends \Twig_Extension
{
  public function getName()
  {
      return 'Fetch';
  }

  public function getFunctions()
  {
      return [
          new \Twig_SimpleFunction('fetch', [$this, 'fetch']),
      ];
  }

  public function fetch($client, $method, $destination, $request = [], $format = 'json')
  {
      $client = new \GuzzleHttp\Client($client);

      try {

        $response = $client->request($method, $destination, $request);

        if ($format == 'raw') {
          $body = (string) $response->getBody();
        } else {
          $body = json_decode($response->getBody(), true);
        }

        return [
          'statusCode' => $response->getStatusCode(),
          'reason' => $response->getReasonPhrase(),
          'body' => $body
        ];

      } catch (\Exception $e) {

        return [
          'error' => true,
          'reason' => $e->getMessage()
        ];

      }
  }
}
