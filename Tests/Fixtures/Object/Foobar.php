<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\DefaultValue\Tests\Fixtures\Object;

/**
 * Foo class test.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class Foobar extends Foo
{
    /**
     * @var string
     */
    private $customField;

    /**
     * @param string $value
     */
    public function setCustomField($value)
    {
        $this->customField = $value;
    }

    /**
     * @return string
     */
    public function getCustomField()
    {
        return $this->customField;
    }
}
