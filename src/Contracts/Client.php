<?php

namespace Daesk\Api\Contracts;

interface Client
{
  public function request($method, $endpoint, $body = null);
}
