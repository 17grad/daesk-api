<?php

namespace Daesk\Api;

use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use Daesk\Api\Exceptions\ConnectionException;
use Daesk\Api\Exceptions\AuthorizationException;
use Daesk\Api\Contracts\Client as ClientInterface;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;

class Client implements ClientInterface
{
  private $apiUrl = '';
  private $token = '';

  public function __construct()
  {

  }

  private function setApiUrl($apiUrl)
  {
    $this->apiUrl = $apiUrl;
  }

  /*
   * Manually set a token if authorization has been gained in a different way
   */
  public function setToken($token)
  {
    $this->token = $token;
  }

  /*
   * Call an API method on the external service
   */
  public function request($method, $endpoint, $body = null)
  {
    $client = new GuzzleHttpClient();

    if (!$this->token) {
      throw new AuthorizationException('Token hasn\'t been set.');
    }

    $result = $client->request($method, $this->apiUrl . $endpoint, [
      'json' => $body,
      'headers' => [
        'Authorization' => 'Bearer ' . $this->token,
        'Accept' => 'application/json'
      ]
    ]);


    if ($res->getStatusCode() === 401 || $res->getStatusCode() === 403) {
      throw new AuthorizationException('Unauthorized');
    } elseif ($res->getStatusCode() !== 200) {
      $exception = new ConnectionException('Wrong Response Code');
      $exception->setStatusCode($res->getStatusCode());
      $exception->body = json_decode((string) $res->getBody(), true);
      throw $exception;
    }

    return json_decode((string) $res->getBody(), true);
  }
}
