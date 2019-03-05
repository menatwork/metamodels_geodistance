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

use ContaoCommunityAlliance\DcGeneral\Contao\View\Contao2BackendView\Event\GetPropertyOptionsEvent;
use MenAtWork\MultiColumnWizard\Event\GetOptionsEvent;

/**
 * This trait provide common methods and properties for the event listener.
 */
trait BaseTrait
{
    /**
     * Check if the current context is valid.
     *
     * @param GetPropertyOptionsEvent|GetOptionsEvent $event              The event.
     *
     * @param string                                  $dataDefinitionName The allowed name of the data definition.
     *
     * @param array                                   $properties         A list of allowed properties.
     *
     * @return bool
     */
    protected function isAllowedProperty($event, $dataDefinitionName, $properties)
    {
        if ($event->getEnvironment()->getDataDefinition()->getName() !== $dataDefinitionName) {
            return false;
        }

        if (!\in_array($event->getPropertyName(), $properties)) {
            return false;
        }

        return true;
    }
}
