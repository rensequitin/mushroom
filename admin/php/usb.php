<?php
/* Change to the correct path if you copy this example! */
require __DIR__ . '/../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\EscposImage;

require_once("class.database.php");
$db = MushroomDB::getInstance();

/**
 * Install the printer using USB printing support, and the "Generic / Text Only" driver,
 * then share it (you can use a firewall so that it can only be seen locally).
 *
 * Use a WindowsPrintConnector with the share name to print.
 *
 * Troubleshooting: Fire up a command prompt, and ensure that (if your printer is shared as
 * "Receipt Printer), the following commands work:
 *
 *  echo "Hello World" > testfile
 *  copy testfile "\\%COMPUTERNAME%\Receipt Printer"
 *  del testfile
 */
try {
    // Enter the share name for your USB printer here
    //$connector = null;
	
	$connector = new WindowsPrintConnector("printera");
	$printer = new Printer($connector);

	$printer->initialize();
	
	$img = EscposImage::load("logo-mushroom.png");
	$printer -> setJustification(Printer::JUSTIFY_CENTER);
	$printer -> bitImage($img);
	
	$printer->text("\n\n");
	$printer->text("Mushroom Sisig Haus\nCapitol Exit, Malolos, Bulacan\n0922 849 0700\n");
	$printer->feed();
	$printer->setEmphasis(true);
	$printer -> setJustification();
	$printer->setTextSize(1,2);
	$printer->text("-------------------------------\n");
	$printer->setTextSize(1,1);	
	$printer->text("Order ID. W-99999999\n");
	$printer->text("Order Type: Walk-in\n");
	$printer->text("Cashier: Lorenzo\n");	
	$printer->text("11/23/2017              01:00PM\n");
	$printer -> setJustification();
	$printer->setTextSize(1,2);
	$printer->text("-------------------------------\n");
	$printer->setEmphasis(false);
	$printer->setTextSize(1,1);
	$printer -> setJustification();
	$printer->feed();
	if(isset($_SESSION['POSCart'])){
			foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
					$sql = "Select * from mushroom_foods where food_code = '$cart'";
					$exist = $db->checkExist($sql) or die(mysql_error());
					
					if($exist){

						$row = $db->fetch_array($exist);
						$food_price = $row['food_price'];
						$subtotal = (float)$food_price * (float)$cartItems;
						$foodName = $row['food_name'];
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						//$db->set_foodCode($cart);
						//$db->set_foodImage($row['food_image']);
						//$db->set_foodQuantity($cartItems);
						//$db->set_foodPrice($food_price);
						//$db->set_foodSubtotal($subtotal);
						//$total = $db->compute_bill();
						//$db->view_cart();
						
						$printer->text("$cartItems   $foodName @$food_price\n");
						$printer->text("        *$subtotal\n");
						/* $printer->text("1   Sizzling Pink Salmon Head w/ mushroom atsara @150.00\n");
						$printer->text("        *150.00\n"); */
						
						
					}
							
			}
			//$db->view_button_numbers($active);
			
	}
   
	$printer->text("\n\n");	
	$printer -> setJustification(Printer::JUSTIFY_RIGHT);
	$printer->text("Total Item Sold: 3\n");
	$printer->text("Total: 250.00\n");
	$printer->text("Payment: 300.00\n");
	$printer->text("Change Due: 50.00\n\n");
	
	$printer -> setJustification();
	$printer->setTextSize(1,1);
	$printer->setEmphasis(true);
	$printer->text("-------------CLOSED-------------\n\n");
	$printer->setTextSize(1,1);
	$printer->setEmphasis(false);
	$printer -> setJustification(Printer::JUSTIFY_CENTER);
	$printer->text("Thank You\n");
	$printer->text("Please Come Again\n\n");
	$printer->text("\n\n\n");	
	
	$printer->feed();
	$printer->cut();
	$printer->close();

} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}
/* function title(Printer $printer, $text)
{
    $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
    $printer->text("\n" . $text);
    $printer->selectPrintMode();
    // Reset
} */




/* Change to the correct path if you copy this example! */
/* require __DIR__ . '/../../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector; */

/** 
 * Install the printer using USB printing support, and the "Generic / Text Only" driver,
 * then share it (you can use a firewall so that it can only be seen locally).
 *
 * Use a WindowsPrintConnector with the share name to print.
 *
 * Troubleshooting: Fire up a command prompt, and ensure that (if your printer is shared as
 * "Receipt Printer), the following commands work:
 *
 *  echo "Hello World" > testfile
 *  copy testfile "\\%COMPUTERNAME%\Receipt Printer"
 *  del testfile
 */
/* try { */
    // Enter the share name for your USB printer here
    //$connector = null;
/*     $connector = new WindowsPrintConnector("webeasystep");
 */
    /* Print a "Hello world" receipt" */
	// Prints "Hello World" and fails to cut
/* 	$printer = new Printer($connector);

	$printer->initialize(); */
/* Text of various (in-proportion) sizes */
/* title($printer, "Change height & width\n");
for ($i = 1; $i <= 8; $i++) {
    $printer->setTextSize($i, $i);
    $printer->text($i);
}
$printer->text("\n"); */
/* Width changing only */
/* title($printer, "Change width only (height=4):\n");
for ($i = 1; $i <= 8; $i++) {
    $printer->setTextSize($i, 4);
    $printer->text($i);
}
$printer->text("\n"); */
/* Height changing only */
/* title($printer, "Change height only (width=4):\n");
for ($i = 1; $i <= 8; $i++) {
    $printer->setTextSize(4, $i);
    $printer->text($i);
}
$printer->text("\n"); */
/* Very narrow text */
/* title($printer, "Very narrow text:\n");
$printer->setTextSize(1, 8);
$printer->text("The quick brown fox jumps over the lazy dog.\n"); */
/* Very flat text */
/* title($printer, "Very wide text:\n");
$printer->setTextSize(4, 1);
$printer->text("Hello world!\n"); */
/* Very large text */
/* title($printer, "Largest possible text:\n");
$printer->setTextSize(8, 8);
$printer->text("Hello\nworld!\n");
$printer->cut();
$printer->close();

} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}
function title(Printer $printer, $text)
{
    $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
    $printer->text("\n" . $text);
    $printer->selectPrintMode();
    // Reset
} */

?>