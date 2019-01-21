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

namespace MetaModels\Attribute\GeoDistance\Helper;

use Contao\Database;
use MetaModels\Helper\TableManipulation;

/**
 * Upgrade handler class that changes structural changes in the database.
 * This should rarely be necessary but sometimes we need it.
 */
class UpgradeHandler
{
    /**
     * Update the database table "tl_metamodel_attribute".
     * - Create the new column "countrymode".
     * - Create the new column "country_get".
     * - If exists entries in the old field "get_land",
     *   then switch the "countrymode" to the option "get"
     *   and store the data from the old field to the new field "country_get".
     *
     * @return void
     */
    private static function updateCountryMode()
    {
        $database = Database::getInstance();

        if (!$database->tableExists('tl_metamodel_attribute')) {
            return;
        }

        $fields = $database->getFieldNames('tl_metamodel_attribute');
        if (\in_array('countrymode', $fields)
            || \in_array('country_get', $fields)
            || !\in_array('get_land', $fields)
        ) {
            return;
        }

        $result = $database->prepare('SELECT id, get_land FROM tl_metamodel_attribute WHERE get_land!=""')
            ->execute();

        if (!$result->count()) {
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

        while ($result->next()) {
            $data = [
                'countrymode' => 'get',
                'country_get' => $result->get_land
            ];

            $database->prepare('UPDATE tl_metamodel_attribute %s WHERE id=?')
                ->set($data)
                ->execute($result->id);
        }
    }

    /**
     * Perform all upgrade steps.
     *
     * @return void
     */
    public static function perform()
    {
        self::updateCountryMode();
    }
}
