<div id="Container"> 
<!--Header Start-->
<div id="top">
    <div id="logo"></div>
    <div id="logout">
        <form method="GET" action="logout.php?logout=1">
            <input type="hidden" name="logout" value="1" />
            <input type="submit" class="Btn" value="Log Out" />
        </form>
    </div>
</div>
<!--Header End-->
<!--Left Hand Side Menu Start-->
<div id="content">
<div id="leftside">
<div class="menue" onmouseover="this.className">

<!--
Left Hand Side click on RFQ
-->
<div class="leftmenu">
<?php if($_GET['pages']=='rfq'){?>
    <script>
        $(document).ready(function() { 
            $('#waitDiv').modal();
            $('#simplemodal-container').height(80);
            $('#simplemodal-container').width(400);
            $("#simplemodal-container").css( { marginLeft : "300px", marginTop : "120px", backgroundColor : "#333333" } );
            $("#simplemodal-container a.modalCloseImg").css( {display : "none" } );
            setTimeout( "$.modal.close();",2000 ); 

        });
    </script>
    <div class="tt1">
        <?php }else{ ?><div class="tt"><?php } ?><a href="body.php?pages=rfq" id="repRfq">RFQ</a></div></div>                 

<!--
/*********************************************
//***** Left Hand Side click on Purchase Orders ***
/********************************************
-->
<div class="leftmenu">
<?php if($_GET['pages']=='purchaseOrder'){?>

    <div class="tt1"> <?php } else { ?>  <div class="tt"><?php } ?><a href="body.php?pages=purchaseOrder" id="po">Purchase Orders </a></div></div>
<!--
/*************************************************
//***** Left Hand Side click on Delivery Orders ***
/**************************************************
-->
<div class="leftmenu"><?php if($_GET['pages']=='DeliveryOrders'){?><script>
        $(document).ready(function() { 
            $('#waitDiv').modal();
            $('#simplemodal-container').height(80);
            $('#simplemodal-container').width(400);
            $("#simplemodal-container").css( { marginLeft : "300px", marginTop : "120px", backgroundColor : "#333333" } );
            $("#simplemodal-container a.modalCloseImg").css( {display : "none" } );
            setTimeout( "$.modal.close();",2000 ); 
        });
    </script>

    <div class="tt1"><?php }else{ ?><div class="tt"><?php } ?><a href="body.php?pages=DeliveryOrders" id="do">Delivery Orders </a></div></div>
<!--
/**************************************************
//***** Left Hand Side click on Payments **********
/**************************************************
-->
<div class="leftmenu"><?php if($_GET['pages']=='Payments'){?>
<script>

        $(document).ready(function() { 
            $('#simplemodal-container').height(80);
            $('#simplemodal-container').width(400);
            $("#simplemodal-container").css( { marginLeft : "300px", marginTop : "120px", backgroundColor : "#333333" } );
            $("#simplemodal-container a.modalCloseImg").css( {display : "none" } );
            setTimeout( "$.modal.close();",2000 ); 
        });

</script>
    <div class="tt1"><?php }else{ ?><div class="tt"><?php } ?><a href="body.php?pages=Payments" id="py">Payments </a></div></div>



<!--   
/**************************************************
//***** Left Hand Side click on Product Refunds ***
/**************************************************
-->
<div class="leftmenu"><?php if($_GET['pages']=='prodRefund'){?><script>
        $(document).ready(function() {
            $('#waitDiv').modal();
            $('#simplemodal-container').height(80);
            $('#simplemodal-container').width(400);
            $("#simplemodal-container").css( { marginLeft : "300px", marginTop : "120px", backgroundColor : "#333333" } );
            $("#simplemodal-container a.modalCloseImg").css( {display : "none" } );
            setTimeout( "$.modal.close();",2000 ); 
        });

    </script>
    <div class="tt1"><?php }else{ ?><div class="tt"><?php } ?><a href="body.php?pages=prodRefund" id="pr">Product Refund </a></div></div>   


<!--
/*************************************************
//***** Left Hand Side click on Sales Promotions ***
/**************************************************
-->
<div class="leftmenu"><?php if($_GET['pages']=='salesPromotion'){?><script>
        $(document).ready(function() {
            $('#waitDiv').modal();
            $('#simplemodal-container').height(80);
            $('#simplemodal-container').width(400);
            $("#simplemodal-container").css( { marginLeft : "300px", marginTop : "120px", backgroundColor : "#333333" } );
            $("#simplemodal-container a.modalCloseImg").css( {display : "none" } );
            setTimeout( "$.modal.close();",2000 ); 
        });


    </script>
    <div class="tt1"><?php }else{ ?><div class="tt"><?php } ?><a href="body.php?pages=salesPromotion" id="sp">Sales Promotion </a></div></div>  

<!--
/******************************************************
//***** Left Hand Side click on Fixed Price Orders ***
/*****************************************************

-->
<div class="leftmenu"><?php if($_GET['pages']=='fixedPrice'){?><script>
        $(document).ready(function() { 
            $('#waitDiv').modal();
            $('#simplemodal-container').height(80);
            $('#simplemodal-container').width(400);
            $("#simplemodal-container").css( { marginLeft : "300px", marginTop : "120px", backgroundColor : "#333333" } );
            $("#simplemodal-container a.modalCloseImg").css( {display : "none" } );
            setTimeout( "$.modal.close();",2000 ); 
        });

    </script>
    <div class="tt1"><?php }else{ ?><div class="tt"><?php } ?><a href="body.php?pages=fixedPrice" id="fpo">Fixed Price Orders </a></div></div> 


<!--
/*********************************************
//***** Left Hand Side click on Product QA ***
/********************************************
-->
<div class="leftmenu"><?php if($_GET['pages']=='prodQA'){?><script>
        $(document).ready(function() {


            $('#waitDiv').modal();
            $('#simplemodal-container').height(80);
            $('#simplemodal-container').width(400);
            $("#simplemodal-container").css( { marginLeft : "300px", marginTop : "120px", backgroundColor : "#333333" } );
            $("#simplemodal-container a.modalCloseImg").css( {display : "none" } );
            setTimeout( "$.modal.close();",2000 ); 
        }); 
    </script>

    <div class="tt1"><?php }else{ ?><div class="tt"><?php } ?><a href="body.php?pages=prodQA" id="prodQa">Product Q&A </a></div></div>

<!--
**********************************************************
//***** Left Hand Side click on Product Sample Requests ***
/**********************************************************
-->
<div class="leftmenu"><?php if($_GET['pages']=='prodSampReq'){?><script>
            $(document).ready(function() { 
                $('#waitDiv').modal();
                $('#simplemodal-container').height(80);
                $('#simplemodal-container').width(400);
                $("#simplemodal-container").css( { marginLeft : "300px", marginTop : "120px", backgroundColor : "#333333" } );
                $("#simplemodal-container a.modalCloseImg").css( {display : "none" } );
                setTimeout( "$.modal.close();",2000 ); 
            });

        </script>
        <div class="tt1"><?php }else{ ?><div class="tt"><?php } ?><a href="body.php?pages=prodSampReq" id="psr">Sample Requests </a></div></div>

    <!--
    /*********************************************
    //***** Left Hand Side click on Catalogue ***
    /********************************************
    -->
    <div class="leftmenu">
        <?php if($_GET['pages']=='cat'){?>
            <script>
                $(document).ready(function() { 
                    $('#waitDiv').modal();
                    $('#simplemodal-container').height(80);
                    $('#simplemodal-container').width(400);
                    $("#simplemodal-container").css( { marginLeft : "300px", marginTop : "120px", backgroundColor : "#333333" } );
                    $("#simplemodal-container a.modalCloseImg").css( {display : "none" } );
                    setTimeout( "$.modal.close();",2000 );            
                });
            </script>

            <div class="tt1"><?php }else{ ?><div class="tt"><?php } ?><a href="body.php?pages=cat" id="cat">Catalogue </a></div></div>


    </div>

    </div>
<!--Left Hand Side Menu End-->

<!--Right Hand Side Data Area Start-->
 <div id="rightside">
    <div id="ret_data"></div>
</div>
</div>
<!--Right Hand Side Data Area End-->


<!--Footer Start-->
<div id="footer"></div>
<!--Footer End -->