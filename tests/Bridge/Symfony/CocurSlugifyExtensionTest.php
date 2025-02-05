<?php

/**
 * This file is part of cocur/slugify.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocur\Slugify\Tests\Bridge\Symfony;

use Cocur\Slugify\Bridge\Symfony\CocurSlugifyExtension;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * CocurSlugifyExtensionTest
 *
 * @category   test
 * @package    cocur/slugify
 * @subpackage bridge
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2012-2014 Florian Eckerstorfer
 * @license    http://www.opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class CocurSlugifyExtensionTest extends MockeryTestCase
{
    protected function setUp()
    {
        $this->extension = new CocurSlugifyExtension();
    }

    /**
     * @covers \Cocur\Slugify\Bridge\Symfony\CocurSlugifyExtension::load()
     */
    public function testLoad()
    {
        $twigDefinition = m::mock('Symfony\Component\DependencyInjection\Definition');
        $twigDefinition
            ->shouldReceive('addTag')
            ->with('twig.extension')
            ->once()
            ->andReturn($twigDefinition);
        $twigDefinition
            ->shouldReceive('setPublic')
            ->with(false)
            ->once();

        $container = m::mock('Symfony\Component\DependencyInjection\ContainerBuilder');
        $container
            ->shouldReceive('setDefinition')
            ->with('cocur_slugify', m::type('Symfony\Component\DependencyInjection\Definition'))
            ->once();
        $container
            ->shouldReceive('setDefinition')
            ->with('cocur_slugify.twig.slugify', m::type('Symfony\Component\DependencyInjection\Definition'))
            ->once()
            ->andReturn($twigDefinition);
        $container
            ->shouldReceive('setAlias')
            ->with('slugify', 'cocur_slugify')
            ->once();

        $this->extension->load([], $container);
    }
}
