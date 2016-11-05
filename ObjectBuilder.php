<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\DefaultValue;

/**
 * A builder for creating {@link Block} instances.
 *
 * @author Francois Pluchino
 */
class ObjectBuilder extends ObjectConfigBuilder implements ObjectBuilderInterface
{
    /**
     * The object default value factory.
     *
     * @var ObjectFactoryInterface
     */
    private $factory;

    /**
     * Creates a new object default value builder.
     *
     * @param ObjectFactoryInterface $factory
     * @param array                  $options
     */
    public function __construct(ObjectFactoryInterface $factory, array $options = array())
    {
        parent::__construct($options);

        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectFactory()
    {
        return $this->factory;
    }

    /**
     * {@inheritdoc}
     */
    public function getObject()
    {
        if (null === $this->getData()) {
            $this->setData($this->getType()->newInstance($this, $this->getOptions()));
        }

        $this->getType()->buildObject($this, $this->getOptions());
        $this->getType()->finishObject($this, $this->getOptions());

        $this->getObjectConfig();

        return $this->data;
    }
}
