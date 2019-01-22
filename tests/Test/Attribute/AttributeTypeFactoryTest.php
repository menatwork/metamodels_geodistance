<?php

/**
 * This file is part of MetaModels/attribute_alias.
 *
 * (c) 2012-2018 The MetaModels team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    MetaModels
 * @subpackage AttributeGeoDistanceBundle
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright  2012-2018 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_geodistance/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

namespace MetaModels\AttributeGeoDistanceBundle\Test\Attribute;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use MetaModels\AttributeGeoDistanceBundle\Attribute\AttributeTypeFactory;
use MetaModels\AttributeGeoDistanceBundle\Attribute\GeoDistance;
use MetaModels\Helper\TableManipulator;
use MetaModels\IMetaModel;
use PHPUnit\Framework\TestCase;

/**
 * Class AttributeTypeFactoryTest
 *
 * @covers \MetaModels\AttributeGeoDistanceBundle\Attribute\AttributeTypeFactory
 */
class AttributeTypeFactoryTest extends TestCase
{
    /**
     * Test the constructor.
     *
     * @return void
     *
     * @covers \MetaModels\AttributeGeoDistanceBundle\Attribute\AttributeTypeFactory::__construct
     */
    public function testConstructor()
    {
        $driver           = $this->getMockBuilder(Driver::class)->getMock();
        $connection       = $this->getMockBuilder(Connection::class)->setConstructorArgs([[], $driver])->getMock();
        $tableManipulator = new TableManipulator($connection, []);

        $this->assertInstanceOf(AttributeTypeFactory::class, new AttributeTypeFactory($connection, $tableManipulator));
    }

    /**
     * Test getTypeName().
     *
     * @return void
     */
    public function testTypeName()
    {
        $factory = $this->mockFactory();

        $this->assertSame('geodistance', $factory->getTypeName());
    }

    /**
     * Test getTypeIcon().
     *
     * @return void
     */
    public function testTypeIcon()
    {
        $factory = $this->mockFactory();

        $this->assertSame('bundles/metamodelsattributegeodistance/image/numeric.png', $factory->getTypeIcon());
    }

    /**
     * Test create instance.
     *
     * @return void
     */
    public function testTypeClass()
    {
        $factory   = $this->mockFactory();
        $metaModel = $this->getMockForAbstractClass(IMetaModel::class);

        $this->assertInstanceOf(GeoDistance::class, $factory->createInstance([], $metaModel));
    }

    /**
     * Create a factory.
     *
     * @return AttributeTypeFactory
     */
    private function mockFactory(): AttributeTypeFactory
    {
        $driver           = $this->getMockBuilder(Driver::class)->getMock();
        $connection       = $this->getMockBuilder(Connection::class)->setConstructorArgs([[], $driver])->getMock();
        $tableManipulator = new TableManipulator($connection, []);

        $factory = new AttributeTypeFactory($connection, $tableManipulator);

        return $factory;
    }
}
