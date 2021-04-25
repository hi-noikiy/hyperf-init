<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Factory;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Guzzle\ClientFactory;
use Psr\Http\Message\ResponseInterface;

/**
 * Class HttpFactory
 * @noinspection PhpUnused
 * @package App\Factory
 */
class HttpFactory
{
    protected $headers = [];

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function setHeaders($headers): HttpFactory
    {
        $this->headers = $headers;

        return $this;
    }

    public function post()
    {
    }

    /**
     * @param $url
     * @param array $options
     * @throws GuzzleException
     * @return ResponseInterface
     */
    public function get($url, $options = []): ResponseInterface
    {
        return $this->createClient($options)->get($url);
    }

    public function createClient($options = []): Client
    {
        return $this->clientFactory->create($options);
    }
}
