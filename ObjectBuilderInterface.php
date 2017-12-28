<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DefaultValue;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface ObjectBuilderInterface extends ObjectConfigBuilderInterface
{
    /**
     * Returns the associated block factory.
     *
     * @return ObjectFactoryInterface The factory
     */
    public function getObjectFactory();

    /**
     * Creates the block.
     *
     * @return object The object instance
     */
    public function getObject();
}
