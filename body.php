<?php
    session_start();
//    First page after Successful Login  
    if($_GET['pages']=="LND") {
        include'assets/LandingPage/LandingPage.php';
    }
    
    
// Request For Quotations    
    if($_GET['pages']=="RFQ") {
        include'assets/RequestForQuotations/index.php';
    }
	
// Approved Delivery    
    if($_GET['pages']=="APD") {
        include'assets/ApprovedDelivery/index.php';
    }
    
// Catalogue    
    if($_GET['pages']=="CAT") {
        include'assets/Catalogue/index.php';
    }
    
 // Product Question Answer   
    if($_GET['pages']=="PQA") {
        include'assets/ProductQA/index.php';
    }
    
// Purchase Orders    
    if($_GET['pages']=="POS") {
        include'assets/PurchaseOrders/index.php';
    }
    
 // Product Sample Request
    
    if($_GET['pages']=="PSR") {
        include'assets/ProductSampleRequest/index.php';
    }
 
 // Delivery Orders
    if($_GET['pages']=="DOS") {
        include'assets/DeliveryOrders/index.php';
    }
    

// Payments 
    if($_GET['pages']=="PMT"){
        include'assets/Payments/index.php';
    }
   
// Product and Payment Refund   
    if($_GET['pages']=="PRN") {
        include'assets/ProductRefund/index.php';
    }
   
// Sales Promotion   
    if($_GET['pages']=="SPN") {
        include'assets/SalesPromotion/index.php';
    }

// Fixed Price Orders
    if($_GET['pages']=="PFP") {          
          include'assets/FixedPriceOrders/index.php';
    }   
?>