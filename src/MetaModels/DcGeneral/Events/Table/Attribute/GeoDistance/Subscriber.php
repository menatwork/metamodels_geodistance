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
 * @subpackage AttributeGeoDistance
 * @author     Stefan Heimes <stefan_heimes@hotmail.com>
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2012-2018 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_geodistance/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

namespace MetaModels\DcGeneral\Events\Table\Attribute\GeoDistance;

use ContaoCommunityAlliance\DcGeneral\Contao\View\Contao2BackendView\Event\GetPropertyOptionsEvent;
use ContaoCommunityAlliance\DcGeneral\Data\ModelId;
use ContaoCommunityAlliance\DcGeneral\Data\ModelInterface;
use MenAtWork\MultiColumnWizard\Event\GetOptionsEvent;
use MetaModels\DcGeneral\Events\BaseSubscriber;

/**
 * Handle events for tl_metamodel_attribute.alias_fields.attr_id.
 */
class Subscriber extends BaseSubscriber
{
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
        if (!$this->isAllowedProperty($event, 'tl_metamodel_attribute', $allowedProperties)
        ) {
            return;
        }

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

        $event->setOptions($this->fetchAttributeIdOptions($model, $event->getPropertyName(), $metaModelId));
    }

    /**
     * Fetch the options for the attribute id.
     *
     * @param ModelInterface $model        The model.
     * @param string         $propertyName The name of the property.
     * @param string         $metaModelId  The id of the metamodel.
     *
     * @return array
     */
    private function fetchAttributeIdOptions(ModelInterface $model, $propertyName, $metaModelId)
    {
        $factory       = $this->getServiceContainer()->getFactory();
        $metaModelName = $factory->translateIdToMetaModelName($metaModelId);
        $metaModel     = $factory->getMetaModel($metaModelName);
        $result        = [];

        $typeFactory = $this
            ->getServiceContainer()
            ->getFilterFactory()
            ->getTypeFactory($model->getProperty('type'));

        $typeFilter = [];
        if ($typeFactory) {
            $typeFilter = $typeFactory->getKnownAttributeTypes();
        }

        if ($propertyName === 'single_attr_id') {
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

        return $result;
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
        if (!$this->isAllowedProperty($event, 'tl_metamodel_attribute', $allowedProperties)
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
