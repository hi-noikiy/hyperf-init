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

use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;

/**
 * Class JobFactory
 * @noinspection PhpUnused
 * @package App\Factory
 */
class JobFactory
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    public function __construct(DriverFactory $driverFactory)
    {
        $this->driver = $driverFactory->get('default');
    }

    /**
     * 生产消息.
     * @param $job
     * @param int $delay 延时时间 单位秒
     * @return bool
     */
    public function push($job, $delay = 0): bool
    {
        return $this->driver->push($job, $delay);
    }
}
