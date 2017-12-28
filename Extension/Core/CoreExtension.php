<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DefaultValue\Extension\Core;

use Fxp\Component\DefaultValue\AbstractExtension;

/**
 * Represents the main object extension extension, which loads the core functionality.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
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
