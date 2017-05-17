<style>
    .admin-shipping-method-form{
        min-width: 760px;
    }
</style>
<div class="pravams-admin-form">
    <div class="admin-shipping-method-form">
        <h3>Shipping Method:</h3>
    </div>
    <div class="admin-shipping-method-select">
        <?php 
        $shippingMethods = new Shippingmethod();
        $allData = $shippingMethods->getShippingMethods();
        $methods = $allData->option_value;
        $methodsVal = unserialize($methods);
        $shipMethods = $methodsVal->methods;
        foreach($shipMethods as $shipMethod => $value){?>
            <div class="admin-shipping-method-form">
                <span><?php echo $shipMethod;?>: </span>
                <span>Enabled</span><input type="checkbox" name="<?php echo $shipMethod;?>" id="<?php echo $shipMethod;?>-active" checked="<?php echo $value['active']?>"/>
                <span>Charges</span><input type="text" name="<?php echo $shipMethod;?>-rate" id="<?php echo $shipMethod;?>-rate" value="<?php echo $value['rate'];?>" />
            </div>            
        <?php }?>
    </div>
    <div class="admin-payment-method-form">
        <h3>Payment Method:</h3>
    </div>
    <div class="admin-payment-method-select">
        <?php 
        $paymentMethods = new Paymentmethod();
        $allData = $paymentMethods->getPaymentMethods();
        $methods = $allData->option_value;
        $methodsVal = unserialize($methods);
        $payMethods = $methodsVal->methods;
        foreach($payMethods as $payMethod => $value){?>
            <div class="admin-payment-method-form">
                <span><?php echo $payMethod;?>: </span>
                <span>Enabled</span><input type="checkbox" name="<?php echo $payMethod;?>" id="<?php echo $payMethod;?>-active" checked="<?php echo $value['active']?>"/>                
            </div>        
        <?php }?>
    </div>
</div>