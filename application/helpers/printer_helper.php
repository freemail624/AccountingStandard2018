<?php
	require 'autoload.php';

	use Mike42\Escpos\Printer;
	use Mike42\Escpos\EscposImage;
	use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

	
	  function print_receipt($items, $printer, $hostname, $open_drawer)
	  {
	    try {
	    	

			/* Date is kept the same for testing */
			// $date = date('l jS \of F Y h:i:s A');
			$date = "Monday 6th of April 2015 02:56:25 PM";
		    // Enter the share name for your USB printer here
		    $connector = new WindowsPrintConnector($printer, $hostname);
		    /* Print a "Hello world" receipt" */
		    $printer = new Printer($connector);
		    $printer -> setJustification(Printer::JUSTIFY_CENTER);
		    $printer -> setFont(Printer::FONT_B);

		    if($open_drawer){
		    	$printer -> pulse();
		    }

		    foreach ($items as $item) {
			    $printer -> text($item."\n");
			}
			$printer ->setJustification(Printer::JUSTIFY_LEFT);

		    // $printer -> text("Hello World!\n");
		    // $printer -> text("Hello World!12123123123123\n");
		    $printer -> cut();

		    
		    /* Close printer */
		    $printer -> close();
		} catch(Exception $e) {
		    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
		}
	  }

	  function open_drawer($printer, $hostname)
	  {
	    try {
			/* Date is kept the same for testing */
			// $date = date('l jS \of F Y h:i:s A');
			$date = "Monday 6th of April 2015 02:56:25 PM";
		    // Enter the share name for your USB printer here
		    $connector = new WindowsPrintConnector($printer, $hostname);
		    /* Print a "Hello world" receipt" */
		    $printer = new Printer($connector);
		    $printer -> setJustification(Printer::JUSTIFY_CENTER);
		    $printer -> setFont(Printer::FONT_A);

	    	$printer -> pulse();
		    /* Close printer */
		    $printer -> close();
		} catch(Exception $e) {
		    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
		}
	  }
?>