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
use GuzzleHttp\RequestOptions;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Guzzle\ClientFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class HttpFactory
 * @noinspection PhpUnused
 * @package App\Factory
 */
class HttpFactory
{
    /**
     * @Inject
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * 初始化客户端
     * @param array $options
     * @return Client
     */
    public static function init($options = []): Client
    {
        $onRedirect = function (
            RequestInterface $request,
            ResponseInterface $response,
            UriInterface $uri
        ) {
            if ($response->getStatusCode() !== 200) {
                echo 'Redirecting! ' . $request->getUri() . ' to ' . $uri . "\n";
                LoggerFactory::interface()->debug('跳转', [
                    $request->getUri(),
                    $uri
                ]);
            }
        };

        $default = [
            RequestOptions::DEBUG => true,
            RequestOptions::TIMEOUT => 60,
            RequestOptions::HEADERS => [
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36',
                'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'Accept-Encoding' => 'gzip, deflate',
                'Accept' => '*/*',
            ],
            // 跳转
            RequestOptions::ALLOW_REDIRECTS => [
                'max' => 10,
                'strict' => true,
                'referer' => true,
                'protocols' => ['http', 'https'],
                'on_redirect' => $onRedirect,
                // 开启后可以在getHeaderLine('X-Guzzle-Redirect-History')调用
                'track_redirects' => true,
            ],
            // 代理
            // RequestOptions::PROXY => 'http://127.0.0.1:8888',
        ];

        if (empty($options)) {
            $options = $default;
        } else {
            $options = array_merge($default, $options);
        }

        // curl模式
        // $options['handler'] = new CurlHandler();

        return (new self())->clientFactory->create($options);
    }
}
