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

namespace MetaModels\AttributeGeoDistanceBundle\EventListener;

use MenAtWork\MultiColumnWizard\Event\GetOptionsEvent;

/**
 * This class provides the attribute options and encodes and decodes the attribute id.
 */
class LookUpServiceListener
{
    use BaseTrait;

    /**
     * Get a list with all supported resolver class for a geo lookup.
     *
     * @param GetOptionsEvent $event The event.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    public function getResolverClass(GetOptionsEvent $event)
    {
        // Check the context.
        $allowedProperties = ['lookupservice'];
        if (!$this->isAllowedProperty($event, 'tl_metamodel_attribute', $allowedProperties)
            || ('lookupservice' !== $event->getSubPropertyName())
        ) {
            return;
        }

        $arrClasses = (array) $GLOBALS['METAMODELS']['filters']['perimetersearch']['resolve_class'];
        $arrReturn  = [];
        foreach (\array_keys($arrClasses) as $name) {
            $arrReturn[$name] = (isset($GLOBALS['TL_LANG']['tl_metamodel_attribute']['perimetersearch'][$name]))
                ? $GLOBALS['TL_LANG']['tl_metamodel_attribute']['perimetersearch'][$name]
                : $name;
        }

        $event->setOptions($arrReturn);
    }
}
