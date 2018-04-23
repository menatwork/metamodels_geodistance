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
 * @author     Ingolf Steinhardt <info@e-spin.de>
 * @copyright  2012-2018 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_geodistance/blob/master/LICENSE LGPL-3.0
 * @filesource
 */

/**
 * Table tl_metamodel_attribute
 */
$GLOBALS['TL_DCA']['tl_metamodel_attribute']['metapalettes']['geodistance extends _simpleattribute_'] = array
(
    '+parameter' => array('get_geo', 'get_land'),
    '+data'      => array('datamode', 'lookupservice'),
);

// Subpalettes.
$GLOBALS['TL_DCA']['tl_metamodel_attribute']['metasubselectpalettes']['datamode']['single'] =
    array('single_attr_id');
$GLOBALS['TL_DCA']['tl_metamodel_attribute']['metasubselectpalettes']['datamode']['multi']  =
    array(
        'first_attr_id',
        'second_attr_id'
    );

// Fields.
$GLOBALS['TL_DCA']['tl_metamodel_attribute']['fields']['get_geo'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['get_geo'],
    'exclude'   => true,
    'inputType' => 'text',
    'sql'       => 'varchar(255) NOT NULL default \'\'',
    'eval'      => array
    (
        'tl_class' => 'w50'
    ),
);

$GLOBALS['TL_DCA']['tl_metamodel_attribute']['fields']['get_land'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['get_land'],
    'exclude'   => true,
    'inputType' => 'text',
    'sql'       => 'varchar(255) NOT NULL default \'\'',
    'eval'      => array
    (
        'tl_class' => 'w50'
    ),
);

$GLOBALS['TL_DCA']['tl_metamodel_attribute']['fields']['lookupservice'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['lookupservice'],
    'exclude'   => true,
    'inputType' => 'multiColumnWizard',
    'sql'       => 'text NULL',
    'eval'      => array
    (
        'tl_class'     => 'clr',
        'columnFields' => array
        (
            'lookupservice' => array
            (
                'label'     => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['lookupservice'],
                'exclude'   => true,
                'inputType' => 'select',
                'eval'      => array
                (
                    'includeBlankOption' => true,
                    'mandatory'          => true,
                    'chosen'             => true,
                    'style'              => 'width:250px',
                )
            ),
        ),
    )
);

$GLOBALS['TL_DCA']['tl_metamodel_attribute']['fields']['datamode'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['datamode'],
    'exclude'   => true,
    'inputType' => 'select',
    'options'   => array('single', 'multi'),
    'reference' => $GLOBALS['TL_LANG']['tl_metamodel_attribute']['datamode_options'],
    'sql'       => 'varchar(255) NOT NULL default \'\'',
    'eval'      => array
    (
        'doNotSaveEmpty'     => true,
        'alwaysSave'         => true,
        'submitOnChange'     => true,
        'includeBlankOption' => true,
        'mandatory'          => true,
        'tl_class'           => 'clr',
    )
);


$GLOBALS['TL_DCA']['tl_metamodel_attribute']['fields']['single_attr_id'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['single_attr_id'],
    'exclude'   => true,
    'inputType' => 'select',
    'sql'       => 'varchar(255) NOT NULL default \'\'',
    'eval'      => array
    (
        'doNotSaveEmpty'     => true,
        'alwaysSave'         => true,
        'submitOnChange'     => true,
        'includeBlankOption' => true,
        'mandatory'          => true,
        'tl_class'           => 'w50',
        'chosen'             => true
    )
);

$GLOBALS['TL_DCA']['tl_metamodel_attribute']['fields']['first_attr_id'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['first_attr_id'],
    'exclude'   => true,
    'inputType' => 'select',
    'sql'       => 'varchar(255) NOT NULL default \'\'',
    'eval'      => array
    (
        'doNotSaveEmpty'     => true,
        'alwaysSave'         => true,
        'submitOnChange'     => true,
        'includeBlankOption' => true,
        'mandatory'          => true,
        'tl_class'           => 'w50',
        'chosen'             => true
    )
);

$GLOBALS['TL_DCA']['tl_metamodel_attribute']['fields']['second_attr_id'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['second_attr_id'],
    'exclude'   => true,
    'inputType' => 'select',
    'sql'       => 'varchar(255) NOT NULL default \'\'',
    'eval'      => array
    (
        'doNotSaveEmpty'     => true,
        'alwaysSave'         => true,
        'submitOnChange'     => true,
        'includeBlankOption' => true,
        'mandatory'          => true,
        'tl_class'           => 'w50',
        'chosen'             => true
    )
);

