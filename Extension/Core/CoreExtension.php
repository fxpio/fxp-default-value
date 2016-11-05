<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\DefaultValue\Extension\Core;

use Sonatra\Component\DefaultValue\AbstractExtension;

/**
 * Represents the main object extension extension, which loads the core functionality.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class CoreExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function loadTypes()
    {
        return array();
    }
}
