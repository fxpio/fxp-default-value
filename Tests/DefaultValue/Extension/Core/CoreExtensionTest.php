<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Extension\Core;

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\Extension\Core\CoreExtension;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class CoreExtensionTest extends \PHPUnit_Framework_TestCase
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
        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectExtensionInterface', $this->extension);
        $this->assertFalse($this->extension->hasType('default'));
        $this->assertFalse($this->extension->hasTypeExtensions('default'));
    }
}
