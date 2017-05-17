<?php 
global $wp_admin_bar;
$session = new Checkoutsession();
$productDescHtml = '';
$url = $args['url'];
if($session->isInitiated()){
    $productDescHtml = '<div class="ab-item"><a class="menu-cart" url='.$url.'>Cart</a>';
    $cart = $session->getCart();
    foreach($cart as $key => $item){
        $product = Product::product_load($key);
        $productDesc = $product[0];
        $productDescHtml .= '<div class="ab-sub-wrapper"><b>'.$productDesc->post_title.'</b>';
        $productDescHtml .= "<span>qty:".$item."</span></div>";
    }
    $productDescHtml .= '</div>';

    if(isset($cart)){
        $wp_admin_bar->add_menu( array(
                    'parent' => 'top-secondary',
                    'id'     => 'cart',
                    'title'  => $productDescHtml,
                    'meta'   => array(
                            'class'    => 'admin-bar-search',
                            'tabindex' => -2,
                    )
            ) );
    }
    
}
?>