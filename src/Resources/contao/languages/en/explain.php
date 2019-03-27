<?php

/**
 * This file is part of MetaModels/core.
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
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2012-2018 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_geodistance/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

$GLOBALS['TL_LANG']['XPL']['attribute_lookupservice'][0][0] = 'Coordinates input';
$GLOBALS['TL_LANG']['XPL']['attribute_lookupservice'][0][1] =
    'This service uses existing latitude and longitude values of a geopoint without further lookup.<br>
   A comma separated signed decimal pair of latitude and longitude is expected - e.g. "52.520008,13.404954" or "-31.950527,115.860458".';
$GLOBALS['TL_LANG']['XPL']['attribute_lookupservice'][1][0] = 'GoogleMaps lookup';
$GLOBALS['TL_LANG']['XPL']['attribute_lookupservice'][1][1] =
    'GoogleMap lookup service to determine the geocoordinates of an address.<br>
   If you use this service, you must add the API token usage.<br>
   <strong><a href="https://developers.google.com/maps/documentation/javascript/usage">Google Maps API</a></strong>';
$GLOBALS['TL_LANG']['XPL']['attribute_lookupservice'][2][0] = 'OpenStreetMap lookup';
$GLOBALS['TL_LANG']['XPL']['attribute_lookupservice'][2][1] =
    'OpenStreetMap lookup service to determine the geocoordinates of an address.';
