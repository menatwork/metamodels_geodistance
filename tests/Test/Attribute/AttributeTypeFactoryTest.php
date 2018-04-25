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
 * @author     Stefan Heimes <stefan_heimes@hotmail.com>
 * @author     Sven Baumann <baumann.sv@gmail.com>
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
     * @covers \MetaModels\AttributeGeoDistanceBundle\Attribute\AttributeTypeFactory::__construct
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(AttributeTypeFactory::class, $this->mockFactory());
    }

    public function testTypeName()
    {
        $factory = $this->mockFactory();

        $this->assertSame('geodistance', $factory->getTypeName());
    }

    public function testTypeIcon()
    {
        $factory = $this->mockFactory();

        $this->assertSame('system/modules/metamodelsattribute_geodistance/html/numeric.png', $factory->getTypeIcon());
    }

    public function testTypeClass()
    {
        $driver           = $this->getMockBuilder(Driver::class)->getMock();
        $connection       = $this->getMockBuilder(Connection::class)->setConstructorArgs([[], $driver])->getMock();
        $tableManipulator =
            $this->getMockBuilder(TableManipulator::class)->setConstructorArgs([$connection, []])->getMock();

        $originalFactory = new AttributeTypeFactory($connection, $tableManipulator);

        $reflectionProperty = new \ReflectionProperty(\get_class($originalFactory), 'typeClass');
        $reflectionProperty->setAccessible(true);

        $this->assertSame(GeoDistance::class, $reflectionProperty->getValue($originalFactory));
    }

    private function mockFactory()
    {
        $driver           = $this->getMockBuilder(Driver::class)->getMock();
        $connection       = $this->getMockBuilder(Connection::class)->setConstructorArgs([[], $driver])->getMock();
        $tableManipulator =
            $this->getMockBuilder(TableManipulator::class)->setConstructorArgs([$connection, []])->getMock();

        $originalFactory = new AttributeTypeFactory($connection, $tableManipulator);

        $reflectionProperty = new \ReflectionProperty(\get_class($originalFactory), 'typeClass');
        $reflectionProperty->setAccessible(true);

        $factory = $this->getMockBuilder(AttributeTypeFactory::class)
            ->setConstructorArgs(
                [
                    $connection,
                    $tableManipulator
                ]
            )->getMock();

        $factory->method('getTypeName')->willReturn($originalFactory->getTypeName());
        $factory->method('getTypeIcon')->willReturn($originalFactory->getTypeIcon());

        return $factory;
    }
}
