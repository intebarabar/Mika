<?php

class Smartwave_Mango_Model_System_Config_Source_Setting_Product_Tab
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'type1', 'label' => 'Default'),
            array('value' => 'type2', 'label' => 'Vertical Tab'),
            array('value' => 'type3', 'label' => 'Accordion Tab')
        );
    }
}