<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * @copyright  Intelligent Spark 2017
 * @author     Fred Bliss <fred.bliss@intelligentspark.com>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Table tl_iso_payment_modules
 */
$GLOBALS['TL_DCA']['tl_iso_product_collection']['palettes']['default'] .= ',po_number';

$GLOBALS['TL_DCA']['tl_iso_product_collection']['fields']['po_number'] = array
(
    'label'		=> &$GLOBALS['TL_LANG']['tl_iso_product_collection']['po_number'],
    'inputType'	=> 'text',
    'eval'		=> array('disabled'=>true)
);