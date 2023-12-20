<?php
session_start();
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
    $newOrder->addAttribute('customerUserName', $_SESSION['username']);

   
    $orderItems = $newOrder->addChild('orderItems');
    $customerPreferences = $newOrder->addChild('customerPreferences');
    foreach ($_POST['dishes'] as $dishId) {
        $dish = $xml->menu->xpath("//dish[@id='" . $dishId . "']")[0];
        $quantity = $_POST['dish_qty'][$dishId];
        $item = $orderItems->addChild('item');
        $item->addAttribute('dishId', $dishId);
        $item->addAttribute('quantity', $quantity);

        
        $description = isset($_POST['dish_desc'][$dishId]) ? $_POST['dish_desc'][$dishId] : 'ei ole';

        $preference = $customerPreferences->addChild('preference');
        $preference->addAttribute('type', 'preference');
        $preference->addAttribute('dish', $dish->name);
        $preference->addAttribute('description', $description);
    }




    
    $status = $newOrder->addChild('status', 'active');

    $xml->asXML('../Data/Restaurant.xml');

    header('Location: ../pages/myOrders.php');
    exit;
}
?>