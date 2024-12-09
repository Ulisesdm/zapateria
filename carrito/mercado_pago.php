<?php

require '../vendor/autoload.php';

MercadoPago\SDK::setAccessToken(TOKEN_MP);

$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();
$item->id = '0001';
$item->item = 'Producto';
$item->quantity = 1;
$item->unit_price = 150.00;
$item->currency_id= 'MXN';

$preference->items = array($item);

$preference->back_urls = array(
    "sucess" => "http://localhost/ProyectoAdonay/captura.php",
    "sucess" => "http://localhost/ProyectoAdonay/fallo.php"
);

$preference->auto_return = "approved";
$preference->binary_mode = true;

$preference->save();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>
    <h3>Mercado Pago</h3>
    <div class="checkout-btn"></div>

    <script>
        const mp = new MercadoPago('TEST-2e742f44-a14b-4d21-b3a2-754656afe9b8', {
            locale: 'es-MX'
        });

        mp.checkout({
            preference:{
                id: '<?php echo $preference->id; ?>'
            },
            render:{
                container: '.checkout-btn',
                label: 'Pagar con Mercado Pago'
            }
        })

    </script>
    
</body>
</html>