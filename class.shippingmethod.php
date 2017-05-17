<?php

class Shippingmethod{
    
    public $methods;
    
    public function __construct() {
        $shippingMethods = (object) array(
                'flat-rate' => array(
                    'active' => false,
                    'rate' => '0'
                ),
                'per-product' => array(
                    'active' => false,
                    'rate' => '0'
                )
        );
        
        $this->methods = $shippingMethods;
    }
    
    public function setMethod($type, $value){
        $methodsObject = (array) $this->methods;
        foreach($methodsObject as $method => $methodValues){
            if($method == $type){
                $methodsObject[$method]['active'] = $value;
            }
        }
        $this->methods = (object) $methodsObject;
    }
    
    public function setMethodRate($type, $value){
         $methodsObject = (array) $this->methods;
        foreach($methodsObject as $method => $methodValues){
            if($method == $type){
                $methodsObject[$method]['rate'] = $value;
            }
        }
        $this->methods = (object) $methodsObject;
    }
    
    public function getShippingMethods(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'options';
        $sql = "SELECT * FROM $table_name where option_name = 'shipping-method'";
        $results = $wpdb->get_results($sql);
        return $results[0];
    }
}

