<?php

class Data{
    
    public function loadDataPayment($wpdb){
        $table_name = $wpdb->prefix . 'options';
        $paymentMethod = new Paymentmethod();
        $paymentMethod->setMethod('cash', true);
        $paymentMethod->setMethodName('cash', 'Cash');
        $paymentMethod->setMethod('check', true);
        $paymentMethod->setMethodName('check', 'Check/MoneyOrder');
        $paymentMethodValue = serialize($paymentMethod);        
        
        $sql = "INSERT INTO $table_name  (option_name, option_value, autoload) VALUES ( 'payment-method', '$paymentMethodValue', 'no'); ";
        $wpdb->query($sql);
    }
    
    public function loadDataShipping($wpdb){
        $table_name = $wpdb->prefix . 'options';
        $shippingMethod = new Shippingmethod();
        $shippingMethod->setMethod('flat-rate', true);
        $shippingMethod->setMethodRate('flat-rate', '5');
        $shippingMethod->setMethod('per-product', true);
        $shippingMethod->setMethodRate('per-product', '4');
        $shippingMethodValue = serialize($shippingMethod);        
        
        $sql = "INSERT INTO $table_name  (option_name, option_value, autoload) VALUES ( 'shipping-method', '$shippingMethodValue', 'no'); ";
        $wpdb->query($sql);
    }
    
    public function loadDataCountry($wpdb, $tablename){
        
        $sql = "INSERT INTO $tablename  (name, code, currency, currency_symbol) VALUES ( 'Afghanistan', 'AF', 'AFN', 'AFN'), "
                . " ( 'United States of America', 'US', 'Dollars', '&#36;'), "
                . "( 'India', 'IN', 'INR', '&#8377;');";
        $wpdb->query($sql);
    }
    
    public function loadDataState($wpdb, $tablecountry, $tablestate){
        
        $result = $wpdb->get_results("SELECT id FROM $tablecountry where code = 'US'");
        $keyRes = $result[0];
        $key = $keyRes->id;
        $sql = "INSERT INTO $tablestate  (name, code, country_code) VALUES ( 'Alaska' , 'AK', $key), "
                . "( 'Alabama' , 'AL', $key) ;";
        $wpdb->query($sql);
        
        $result = $wpdb->get_results("SELECT id FROM $tablecountry where code = 'IN'");
        $keyRes = $result[0];
        $key = $keyRes->id;
        $sql = "INSERT INTO $tablestate  (name, code, country_code) VALUES ( 'Uttar Pradesh' , 'UP', $key), "
                . "( 'Maharashtra' , 'MH', $key) ;";
        $wpdb->query($sql);
    }
}
