<?php
namespace Daesk\Api\Exceptions;

use Exception;

class ConnectionException extends Exception
{
  private $statusCode;

  public $body;

  public function getStatusCode()
  {
    return $this->statusCode;
  }

  public function setStatusCode($statusCode)
  {
    $this->statusCode = $statusCode;
  }
}
