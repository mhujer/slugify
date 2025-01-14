<?php

/**
 * This file is part of cocur/slugify.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocur\Slugify\Tests\Bridge\Silex;

use Cocur\Slugify\Bridge\Silex\SlugifyServiceProvider;
use Cocur\Slugify\Bridge\Twig\SlugifyExtension;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * SlugifyServiceProviderTest
 *
 * @category   test
 * @package    cocur/slugify
 * @subpackage bridge
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2012-2014 Florian Eckerstorfer
 * @license    http://www.opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class SlugifySilexProviderTest extends MockeryTestCase
{
    /**
     * @covers \Cocur\Slugify\Bridge\Silex\SlugifyServiceProvider
     */
    public function testRegister()
    {
        // it seems like Application is not mockable.
        $app = new Application();
        $app->register(new SlugifyServiceProvider());
        $app->boot();

        $this->assertArrayHasKey('slugify', $app);
        $this->assertArrayHasKey('slugify.provider', $app);
        $this->assertArrayHasKey('slugify.options', $app);
        $this->assertInstanceOf('Cocur\Slugify\Slugify', $app['slugify']);
    }

    
    public function testRegisterWithTwig()
    {
        if (!class_exists('\Twig_Environment')) {
            $this->markTestSkipped('Silex is not compatible with Twig 3');
        }

        $app = new Application();
        $app->register(new TwigServiceProvider());
        $app->register(new SlugifyServiceProvider());

        $this->assertTrue($app['twig']->hasExtension(SlugifyExtension::class));
    }
}
