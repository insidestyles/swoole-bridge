<?php

namespace Insidestyles\SwooleBridge\Tests\Base;

use Insidestyles\SwooleBridge\Tests\Traits\ObjectCreatorTrait;
use Insidestyles\SwooleBridge\Tests\Traits\ServiceMocksTrait;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    use ServiceMocksTrait;
    use ObjectCreatorTrait;
    
    public static $testPath = '';

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$testPath = __DIR__ . '/../';
    }
}