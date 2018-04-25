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

use MetaModels\Attribute\Events\CreateAttributeFactoryEvent;
use MetaModels\AttributeGeoDistanceBundle\Attribute\AttributeTypeFactory;
use MetaModels\AttributeGeoDistanceBundle\EventListener\Subscriber;
use MetaModels\Events\MetaModelsBootEvent;
use MetaModels\MetaModelsEvents;

return array
(
    MetaModelsEvents::SUBSYSTEM_BOOT_BACKEND   => array(
        function (MetaModelsBootEvent $event) {
            new Subscriber($event->getServiceContainer());
        }
    ),
    MetaModelsEvents::ATTRIBUTE_FACTORY_CREATE => array(
        function (CreateAttributeFactoryEvent $event) {
            $factory = $event->getFactory();
            $factory->addTypeFactory(new AttributeTypeFactory());
        }
    )
);
