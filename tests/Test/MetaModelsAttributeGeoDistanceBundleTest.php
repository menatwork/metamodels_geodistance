<?php

/**
 * This file is part of MetaModels/attribute_geodistance.
 *
 * (c) 2012-2019 The MetaModels team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    MetaModels/attribute_geodistance
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2012-2019 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_geodistance/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

namespace MetaModels\AttributeGeoDistanceBundle\Test;

use MetaModels\AttributeGeoDistanceBundle\DependencyInjection\MetaModelsAttributeGeoDistanceExtension;
use MetaModels\AttributeGeoDistanceBundle\MetaModelsAttributeGeoDistanceBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Resource\ComposerResource;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class MetaModelsAttributeGeoDistanceBundleTest
 *
 * @covers \MetaModels\AttributeGeoDistanceBundle\MetaModelsAttributeGeoDistanceBundle
 */
class MetaModelsAttributeGeoDistanceBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new MetaModelsAttributeGeoDistanceBundle();

        $this->assertInstanceOf(MetaModelsAttributeGeoDistanceBundle::class, $bundle);
    }

    public function testReturnsTheContainerExtension()
    {
        $extension = (new MetaModelsAttributeGeoDistanceBundle())->getContainerExtension();

        $this->assertInstanceOf(MetaModelsAttributeGeoDistanceExtension::class, $extension);
    }

    /**
     * @covers \MetaModels\AttributeGeoDistanceBundle\DependencyInjection\MetaModelsAttributeGeoDistanceExtension::load
     */
    public function testLoadExtensionConfiguration()
    {
        $extension = (new MetaModelsAttributeGeoDistanceBundle())->getContainerExtension();
        $container = new ContainerBuilder();

        $extension->load([], $container);

        $this->assertInstanceOf(ComposerResource::class, $container->getResources()[0]);
        $this->assertInstanceOf(FileResource::class, $container->getResources()[1]);
        $this->assertSame(
            \dirname(\dirname(__DIR__)) . '/src/Resources/config/attribute-settings.yml',
            $container->getResources()[1]->getResource()
        );
        $this->assertInstanceOf(FileResource::class, $container->getResources()[2]);
        $this->assertSame(
            \dirname(\dirname(__DIR__)) . '/src/Resources/config/listeners.yml',
            $container->getResources()[2]->getResource()
        );
    }
}
