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

namespace MetaModels\AttributeGeoDistanceBundle\EventListener;

use ContaoCommunityAlliance\DcGeneral\Contao\View\Contao2BackendView\Event\GetPropertyOptionsEvent;
use ContaoCommunityAlliance\DcGeneral\Data\ModelId;
use MenAtWork\MultiColumnWizard\Event\GetOptionsEvent;
use MetaModels\DcGeneral\Events\BaseSubscriber;

/**
 * Handle events for tl_metamodel_attribute.alias_fields.attr_id.
 */
class Subscriber extends BaseSubscriber
{
    use BaseTrait;

    /**
     * {@inheritdoc}
     */
    protected function registerEventsInDispatcher()
    {
        $this
            ->addListener(
                GetPropertyOptionsEvent::NAME,
                [$this, 'getAttributeIdOptions']
            )
            ->addListener(
                GetOptionsEvent::NAME,
                [$this, 'getResolverClass']
            );
    }


    /**
     * Prepares a option list with alias => name connection for all attributes.
     *
     * This is used in the attr_id select box.
     *
     * @param GetPropertyOptionsEvent $event The event.
     *
     * @return void
     */
    public function getAttributeIdOptions(GetPropertyOptionsEvent $event)
    {
        // Check the context.
        $allowedProperties = ['first_attr_id', 'second_attr_id', 'single_attr_id'];
        if (!BaseTrait::isAllowedProperty($event, 'tl_metamodel_attribute', $allowedProperties)
        ) {
            return;
        }


        $result      = [];
        $model       = $event->getModel();
        $metaModelId = $model->getProperty('pid');
        if (!$metaModelId) {
            $metaModelId = ModelId::fromSerialized(
                $event->getEnvironment()->getInputProvider()->getValue('pid')
            )->getId();
        }

        $factory       = $this->getServiceContainer()->getFactory();
        $metaModelName = $factory->translateIdToMetaModelName($metaModelId);
        $metaModel     = $factory->getMetaModel($metaModelName);

        if (!$metaModel) {
            return;
        }

        $typeFactory = $this
            ->getServiceContainer()
            ->getFilterFactory()
            ->getTypeFactory($model->getProperty('type'));

        $typeFilter = [];
        if ($typeFactory) {
            $typeFilter = $typeFactory->getKnownAttributeTypes();
        }

        if ($event->getPropertyName() === 'single_attr_id') {
            $typeFilter = ['geolocation'];
        } else {
            $key = \array_search('geolocation', $typeFilter);
            if ($key !== null) {
                unset($typeFilter[$key]);
            }
        }

        foreach ($metaModel->getAttributes() as $attribute) {
            $typeName = $attribute->get('type');
            if ($typeFilter && (!\in_array($typeName, $typeFilter))) {
                continue;
            }
            $strSelectVal          = $attribute->getColName();
            $result[$strSelectVal] = $attribute->getName() . ' [' . $typeName . ']';
        }
        $event->setOptions($result);
    }

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
        if (!BaseTrait::isAllowedProperty($event, 'tl_metamodel_attribute', $allowedProperties)
            || 'lookupservice' !== $event->getSubPropertyName()
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
