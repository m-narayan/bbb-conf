$(document).ready(function() {
    $(document)[0].oncontextmenu = function() {
        return false;
    } 
   
    $("body").mousedown(function(e) {
        if (e.which === 3) {
           
            jAlert('warning', 'This functionality is asasasa blocked due to security reason', 'Warning Dialog');
        }
    });

    $("a").click(function () {
        $("#ret_data").html(""); 
        $(".tt").css({
            "background-color":"transparent",
            "border-style": "none",
            "border-bottom-style": "solid",
            "border-color": "#0077b0",
            "border-radius":"13px"
        })
        $("a").css({
            "color":"white"
        })
        $(this).parent().css({
            "background-color":"#e4f1fa",
            "border-color":"orangered",
            "border-style": "solid",
            "border-radius": "13px"
        })  
        $(this).css({
            "color":"#2690cc"
        })
    });
    
    $("#repRfq").click(function () {
       
        $("#ret_data").load("assets/replyRfq/index.php"); 
        
    });
	$("#prodQa").click(function () {
       
        $("#ret_data").load("assets/productQa/index.php"); 
        
    });
	$("#po").click(function () {
       
        $("#ret_data").load("assets/productOrders/index.php"); 
		
        
    });
	$("#psr").click(function () {
       
        $("#ret_data").load("assets/productSampReq/index.php"); 
        
    });
	$("#ot").click(function () {
       
        $("#ret_data").load("assets/orderTracking/index.php"); 
        
    });
	$("#pr").click(function () {
       
        $("#ret_data").load("assets/productRefund/index.php"); 
        
    });
	$("#cat").click(function () {
       
        $("#ret_data").load("assets/catalogue/index.php"); 
        
    });
	$("#sp").click(function () {
       
        $("#ret_data").load("assets/salesPromotion/index.php"); 
        
    });
	$("#do").click(function () {
       
        $("#ret_data").load("assets/deliveredOrders/index.php"); 
        
    });
	$("#fpo").click(function () {
       
        $("#ret_data").load("assets/fixedPriceOrders/index.php"); 
        
    });
	
   
  
});

 