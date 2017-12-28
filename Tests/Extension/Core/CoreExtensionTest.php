<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DefaultValue\Tests\Extension\Core;

use Fxp\Component\DefaultValue\Extension\Core\CoreExtension;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class CoreExtensionTest extends TestCase
{
    /**
     * @var CoreExtension
     */
    protected $extension;

    protected function setUp()
    {
        $this->extension = new CoreExtension();
    }

    protected function tearDown()
    {
        $this->extension = null;
    }

    public function testCoreExtension()
    {
        $this->assertInstanceOf('Fxp\Component\DefaultValue\ObjectExtensionInterface', $this->extension);
        $this->assertFalse($this->extension->hasType('default'));
        $this->assertFalse($this->extension->hasTypeExtensions('default'));
    }
}
