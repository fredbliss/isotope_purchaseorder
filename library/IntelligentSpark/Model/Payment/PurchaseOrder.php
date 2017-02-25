<?php

namespace IntelligentSpark\Model\Payment;

use Isotope\Model\Payment;
use Isotope\Interfaces\IsotopePayment;
use Isotope\Interfaces\IsotopeProductCollection;
use Isotope\Isotope;
use Isotope\Model\Product;
use Isotope\Model\OrderStatus;
use Isotope\Model\ProductCollection\Order;
use Isotope\Module\Checkout;
use Isotope\Module\OrderDetails as ModuleIsotopeOrderDetails;

class PurchaseOrder extends Payment implements IsotopePayment
{

    protected $strTemplate = 'iso_payment_purchaseorder';

    /**
     * Cart object - Able to handle other cart types than just IsotopeCart
     *
     * @access protected
     * @var IsotopeProductCollection
     */
    protected $objCart;

    /**
     * Order object
     *
     * @access protected
     * @var IsotopeOrder
     */
    protected $objOrder;

    /**
     * Cart field - could vary according to collection type
     *
     * @access protected
     * @var string
     */
    protected $strCartField = 'cart_id';

    /**
     * Proceed to complete step?
     *
     * @access protected
     * @var boolean
     */
    protected $blnProceed = false;

    /**
     * Form ID
     *
     * @access protected
     * @var string
     */
    protected $strFormId = 'payment_purchase_order';

    /**
     * Generate payment authorization form and AUTH or CAPTURE
     *
     * @access 	public
     * @param 	object
     * @return	mixed
     */
    public function checkoutForm(IsotopeProductCollection $objOrder, \Module $objModule)
    {


        $objTemplate = new \Isotope\Template($this->strTemplate);
        $objTemplate->setData($this->arrData);

        $objTemplate->headline = specialchars($GLOBALS['TL_LANG']['MODEL']['tl_iso_payment.purchaseorder'][0]);

        return $objTemplate->parse();
    }


    /**
     * Process payment on checkout page.
     * @param   IsotopeProductCollection    The order being places
     * @param   Module                      The checkout module instance
     * @return  mixed
     */
    public function processPayment(IsotopeProductCollection $objOrder, \Module $objModule)
    {
        $objOrder->checkout();
        $objOrder->updateOrderStatus($this->new_order_status);

        return true;
    }

    protected function generatePaymentWidget() {

        $arrFields = array
        (
            'purchase_order_id'	=> array
            (
                'label'				=> &$GLOBALS['TL_LANG']['MSC']['purchase_order_id'],
                'inputType'			=> 'text',
                'eval'				=> array('mandatory'=>true, 'tableless'=>true),
            )
        );

        $arrParsed = array();
        $blnSubmit = true;
        $intSelectedPayment = intval(\Input::post('PaymentMethod') ?: $this->objCart->getPaymentMethod());

        foreach ($arrFields as $field => $arrData )
        {
            $strClass = $GLOBALS['TL_FFL'][$arrData['inputType']];
            // Continue if the class is not defined
            if (!class_exists($strClass))
            {
                continue;
            }

            $objWidget = new $strClass($strClass::getAttributesFromDca($arrData, $field));
            if($arrData['value'])
            {
                $objWidget->value = $arrData['value'];
            }
            $objWidget->tableless = $this->tableless;

            //Handle form submit
            if( \Input::post('FORM_SUBMIT') == $this->strFormId && $intSelectedPayment == $this->id)
            {
                $objWidget->validate();
                if($objWidget->hasErrors())
                {
                    $blnSubmit = false;
                    $objModule->doNotSubmit = true;
                }
            }

            // Give the template plenty of ways to output the fields
            $strParsed = $objWidget->parse();
            $strBuffer .= $strParsed;
            $arrParsed[$field] = $strParsed;
            $objTemplate->{'field_'.$field} = $strParsed;
        }
    }
}

