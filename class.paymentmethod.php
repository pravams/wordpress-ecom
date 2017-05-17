<?php

class Paymentmethod{
    public $methods;
    
    public function __construct() {
        $paymentMethods = (object) array(
                'cash' => array(
                    'active' => false,
                    'name' => 'Cash'
                ),
                'check' => array(
                    'active' => false,
                    'name' => 'Check'
                ),
                'cc' => array(
                    'active' => false,
                    'name' => 'Credit Card'
                )
        );
        
        $this->methods = $paymentMethods;
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
    
    public function setMethodName($type, $value){
         $methodsObject = (array) $this->methods;
        foreach($methodsObject as $method => $methodValues){
            if($method == $type){
                $methodsObject[$method]['name'] = $value;
            }
        }
        $this->methods = (object) $methodsObject;
    }
    
    public function getPaymentMethods(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'options';
        $sql = "SELECT * FROM $table_name where option_name = 'payment-method'";
        $results = $wpdb->get_results($sql);
        return $results[0];
    }
}