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

namespace MetaModels\AttributeGeoDistanceBundle\Test;

use MetaModels\AttributeGeoDistanceBundle\MetaModelsAttributeGeoDistanceBundle;
use PHPUnit\Framework\TestCase;

/**
 * Class MetaModelsAttributeGeoDistanceBundleTest
 *
 * @covers  \MetaModels\AttributeGeoDistanceBundle\MetaModelsAttributeGeoDistanceBundle
 */
class MetaModelsAttributeGeoDistanceBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new MetaModelsAttributeGeoDistanceBundle();

        $this->assertInstanceOf(MetaModelsAttributeGeoDistanceBundle::class, $bundle);
    }
}
