<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\DefaultValue\Tests\Fixtures\Type;

use Sonatra\Component\DefaultValue\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sonatra\Component\DefaultValue\ObjectBuilderInterface;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function newInstance(ObjectBuilderInterface $builder, array $options)
    {
        $class = $this->getClass();

        return new $class($options['username'], $options['password']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'username' => 'test',
                'password' => 'password',
            ));
    }

    public function getClass()
    {
        return 'Sonatra\Component\DefaultValue\Tests\Fixtures\Object\User';
    }
}
