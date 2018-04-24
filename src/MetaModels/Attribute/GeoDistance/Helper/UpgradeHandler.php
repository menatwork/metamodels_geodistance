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
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2012-2018 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_geodistance/blob/master/LICENSE LGPL-3.0
 * @filesource
 */

namespace MetaModels\Attribute\GeoDistance\Helper;

use Contao\Database;
use MetaModels\Helper\TableManipulation;

/**
 * Upgrade handler class that changes structural changes in the database.
 * This should rarely be necessary but sometimes we need it.
 */
class UpgradeHandler
{
    private static function updateCountryMode()
    {
        $database = Database::getInstance();

        if ($database->tableExists('tl_metamodel_attribute')) {
            return;
        }

        TableManipulation::dropColumn('tl_metamodel_attribute', 'countrymode');
        TableManipulation::dropColumn('tl_metamodel_attribute', 'country_get');

        $fields = $database->getFieldNames('tl_metamodel_attribute');
        if (\in_array('countrymode', $fields)
            || \in_array('country_get', $fields)
            || !\in_array('get_geo', $fields)
        ) {
            return;
        }

        TableManipulation::createColumn(
            'tl_metamodel_attribute',
            'countrymode',
            'varchar(255) NOT NULL default \'\''
        );
        TableManipulation::createColumn(
            'tl_metamodel_attribute',
            'country_get',
            'text NULL'
        );

        $result = $database->prepare('SELECT id, get_geo FROM tl_metamodel_attribute WHERE get_geo!=""')
                            ->execute();

        if (!$result->count()) {
            TableManipulation::dropColumn('tl_metamodel_attribute', 'get_geo');

            return;
        }

        while ($result->next()) {
            $data = [

            ];

            echo "";
        }
    }

    /**
     * Perform all upgrade steps.
     *
     * @return void
     */
    public static function perform()
    {
        return;
        self::updateCountryMode();
    }
}
