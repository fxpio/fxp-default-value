<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DefaultValue\Tests\Fixtures\Object;

/**
 * Foo class test.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class Foo
{
    /**
     * @var string
     */
    private $bar;

    /**
     * @var bool
     */
    private $privateProperty = false;

    /**
     * @param string $value
     */
    public function setBar($value)
    {
        $this->bar = $value;
    }

    /**
     * @return string
     */
    public function getBar()
    {
        return $this->bar;
    }

    /**
     * @return bool
     */
    public function getPrivateProperty()
    {
        return $this->privateProperty;
    }
}
