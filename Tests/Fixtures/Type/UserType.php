<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DefaultValue\Tests\Fixtures\Type;

use Fxp\Component\DefaultValue\AbstractType;
use Fxp\Component\DefaultValue\ObjectBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
        $resolver->setDefaults([
                'username' => 'test',
                'password' => 'password',
            ]);
    }

    public function getClass()
    {
        return 'Fxp\Component\DefaultValue\Tests\Fixtures\Object\User';
    }
}
