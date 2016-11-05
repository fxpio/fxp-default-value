<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\DefaultValue\Exception;

/**
 * Base UnexpectedTypeException for the Object Default Value component.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class UnexpectedTypeException extends InvalidArgumentException
{
    /**
     * @param object|string $value
     * @param int           $expectedType
     */
    public function __construct($value, $expectedType)
    {
        parent::__construct(sprintf('Expected argument of type "%s", "%s" given', $expectedType, is_object($value) ? get_class($value) : gettype($value)));
    }
}
