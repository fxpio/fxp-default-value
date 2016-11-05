<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\DefaultValue\Extension\Core\Type;

use Sonatra\Component\DefaultValue\AbstractSimpleType;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class DefaultType extends AbstractSimpleType
{
    /**
     * Constructor.
     *
     * @param string $class The class name
     */
    public function __construct($class = 'default')
    {
        parent::__construct($class);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
    }
}
