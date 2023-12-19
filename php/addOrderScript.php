<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $xml = simplexml_load_file('../Data/Restaurant.xml');

    $maxOrderId = 0;
    foreach ($xml->orders->order as $order) {
        $id = (int) $order['id'];
        if ($id > $maxOrderId) {
            $maxOrderId = $id;
        }
    }

   
    $newOrder = $xml->orders->addChild("order");
    $newOrder->addAttribute("id", strval($maxOrderId + 1));
    $newOrder->addAttribute('tableId', $_POST['tableId']);
    $newOrder->addAttribute('waiterId', $_POST['waiterId']);
    
    
    $orderItems = $newOrder->addChild('orderItems');
    foreach ($_POST['dishes'] as $dishId) {
        $quantity = $_POST['dish_qty'][$dishId];
        $item = $orderItems->addChild('item');
        $item->addAttribute('dishId', $dishId);
        $item->addAttribute('quantity', $quantity);
    }
    
   
    $xml->asXML('../Data/Restaurant.xml');
    
 
    header('Location: order_confirmation_page.php');
    exit;
}


?>