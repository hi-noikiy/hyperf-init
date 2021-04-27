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

use Exception;
use Hyperf\Di\Annotation\Inject;
use Psr\Log\LoggerInterface;

/**
 * Class JobFactory
 * @noinspection PhpUnused
 * @package App\Factory
 */
class LoggerFactory
{
    /**
     * @Inject
     * @var \Hyperf\Logger\LoggerFactory
     */
    protected $loggerFactory;

    public static function interface(): LoggerInterface
    {
        return (new self())->loggerFactory->get('log');
    }

    public static function debug($trace): array
    {
        $trace = explode("\n", $trace);
        array_pop($trace);
        $result = [];
        for ($i = 0; $i < count($trace); ++$i) {
            $result[] = ($i + 1) . ')' . substr($trace[$i], strpos($trace[$i], ' '));
        }

        return $result;
    }

    public static function error($message)
    {
        $e = new Exception();
        $trace = $e->getTraceAsString();
        self::interface()->error($message, self::debug($trace));
    }
}
