<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * @copyright  Intelligent Spark 2017
 * @author     Fred Bliss <fred.bliss@intelligentspark.com>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Table tl_iso_payment_modules
 */
$GLOBALS['TL_DCA']['tl_iso_payment']['palettes']['purchaseorder'] = '{type_legend},name,label,type;{note_legend:hide},note;{config_legend},new_order_status,,quantity_mode,minimum_quantity,maximum_quantity,minimum_total,maximum_total,countries,shipping_modules,product_types,product_types_condition,config_ids;{price_legend:hide},price,tax_class;{expert_legend:hide},guests,protected;{enabled_legend},enabled';

