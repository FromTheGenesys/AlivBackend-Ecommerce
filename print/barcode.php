<?php

    # receipt image
    session_start();
    
    ob_flush();
    
    require_once('barcode/class/BCGFontFile.php');
    require_once('barcode/class/BCGColor.php');
    require_once('barcode/class/BCGDrawing.php');
    
    require_once('barcode/class/BCGcode39.barcode.php');
    require_once('barcode/class/BCGcode128.barcode.php');
    
    // The arguments are R, G, and B for color.
    $colorFront = new BCGColor(0, 0, 0);
    $colorBack  = new BCGColor(255, 255, 255);
    
    $font       = new BCGFontFile('barcode/font/Arial.ttf', 12);
    
    $code = new BCGcode39(); // Or another class name from the manual
    $code->setScale(2); // Resolution
    $code->setThickness(20); // Thickness
    $code->setForegroundColor($colorFront); // Color of bars
    $code->setBackgroundColor($colorBack); // Color of spaces
    $code->setFont($font); // Font (or 0)
    $code->parse( $_GET['PaymentID'] ); // Text
    
    $drawing = new BCGDrawing('', $colorBack);
    $drawing->setBarcode($code);
    $drawing->draw();
    
    header('Content-Type: image/png');
    
    $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
    
    ob_end_flush();