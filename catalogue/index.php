<?php 
    session_start();
    include 'include/config.php';
    require_once('classes/Login.php');
    require_once('classes/Catalogue.php');
    require_once('classes/EncryptDecrypt.php');
    require_once('classes/Authorization.php');

    include('include/pagination.php');



    $auth_right = new Authorization();
    $res = "";
    if(!$auth_right->checkAccessRight())
    {
        header('Location: ../index.php');

    }else {
        $encObj  = new EncryptDecrypt();
        $userId = $encObj->edCrypt($_SESSION['userId'],ENCRYPT_KEY);
        $password = $encObj->edCrypt($_SESSION['password'],ENCRYPT_KEY);

        $catalogue = new Catalogue();
        $result = $catalogue->connection();
        $result = $catalogue->authenticateUser($userId,$password);


        $email = $result->user_email;

        if($email != "") {
            $res = $catalogue->get_product_catalog();
            //print_r($res);
        }
    }

    if(isset($_POST['SaveCTD']))
    {
        //echo "hello";


        $ctdid = $_POST['ctdid'];
        $filName = $_POST['filName'];


        $doc_name = $filName;
        $dt_id = 'SPLD';
        $res9 = $catalogue->CreateGFSSupplierDocFileID($doc_name,$dt_id);
        //print_r($res9);

        $main_folder = $res9->result_set->main_folder;
        $sub_folder = $res9->result_set->sub_folder;
        $gfs_filename = $res9->result_set->gfs_filename;


        $ftp_server = FTP_SERVER_IP;
        $ftp_user_name = FTP_USER_NAME;
        $ftp_user_pass = FTP_USER_PASS;




        if($_FILES['SaveCTDF']['name']!='')
        {

            $size=$_FILES['SaveCTDF']['size'];
            $type=$_FILES['SaveCTDF']['type'];
            if($size<=50000000000)
            {
                $file=$_FILES['SaveCTDF']['name'];
                $temp_name=$_FILES['SaveCTDF']['tmp_name'];
                //$path=$_SERVER['DOCUMENT_ROOT']."/Proclaim/supTCP4/Temp/".$file ;
                $path=$_SERVER['DOCUMENT_ROOT']."/Supplies/supTCP4/Temp/".$file ;

                move_uploaded_file($temp_name,$path);

                //$file = 'addGrey.jpg';
                $conn_id = ftp_connect($ftp_server);
                $login_result = @ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if($login_result)
                {

                    ftp_pasv($conn_id, true);

                    if(!@ftp_chdir($conn_id, $main_folder)) {

                        ftp_mkdir($conn_id, $main_folder);
                        ftp_chdir($conn_id, $main_folder);
                    } 

                    if(!@ftp_chdir($conn_id, $sub_folder)) {

                        ftp_mkdir($conn_id, $sub_folder);
                        ftp_chdir($conn_id, $sub_folder);
                    } 


                    $filen = $file;	
                    $file = $temp_name ;
                    $remote_file = $filen;

                    $ret = ftp_nb_put($conn_id, $remote_file, $file, FTP_BINARY, FTP_AUTORESUME);
                    while(FTP_MOREDATA == $ret) {
                        $ret = ftp_nb_continue($conn_id);
                    }

                    if($ret == FTP_FINISHED) {
                        echo "File '" . $remote_file . "' uploaded successfully.";
                    } else {
                        echo "Failed uploading file '" . $remote_file . "'.";
                    }
                } else {
                    echo "Cannot connect to FTP server at " . $ftp_server;
                }   

                print_r($catalogue->update_clinical_catalog($filen,$ctdid));


            }
            else
            {
                echo "<script>";
                echo "alert('Image Size Shouldnot be Greater Than 50 KiloByte and upload only jpeg/png image');";
                echo "</script>";
            }
        }	




        //  print_r($res9);
    }


    if(isset($_POST['SaveIMGB']))
    {


        $ctdid = $_POST['fid'];
        $filName = $_POST['filNameI'];


        $doc_name = $filName;
        $dt_id = 'SPLD';
        $res9 = $catalogue->CreateGFSSupplierDocFileID($doc_name,$dt_id);

        $main_folder = $res9->result_set->main_folder;
        $sub_folder = $res9->result_set->sub_folder;
        $gfs_filename = $res9->result_set->gfs_filename;


        $ftp_server = FTP_SERVER_IP;
        $ftp_user_name = FTP_USER_NAME;
        $ftp_user_pass = FTP_USER_PASS;



        if($_FILES['SaveImg']['name']!='')
        {

            $size=$_FILES['SaveImg']['size'];
            $type=$_FILES['SaveImg']['type'];
            if($size<=50000000000)
            {
                $file=$_FILES['SaveImg']['name'];
                $temp_name=$_FILES['SaveImg']['tmp_name'];
                //$path=$_SERVER['DOCUMENT_ROOT']."/Proclaim/supTCP4/Temp/".$file ;
                $path=$_SERVER['DOCUMENT_ROOT']."/Supplies/supTCP4/Temp/".$file ;

                move_uploaded_file($temp_name,$path);

                //$file = 'addGrey.jpg';
                $conn_id = ftp_connect($ftp_server);
                $login_result = @ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if($login_result)
                {

                    ftp_pasv($conn_id, true);

                    if(!@ftp_chdir($conn_id, $main_folder)) {

                        ftp_mkdir($conn_id, $main_folder);
                        ftp_chdir($conn_id, $main_folder);
                    } 

                    if(!@ftp_chdir($conn_id, $sub_folder)) {

                        ftp_mkdir($conn_id, $sub_folder);
                        ftp_chdir($conn_id, $sub_folder);
                    } 


                    $filen = $file;	
                    $file = $temp_name ;
                    $remote_file = $filen;

                    $ret = ftp_nb_put($conn_id, $remote_file, $file, FTP_BINARY, FTP_AUTORESUME);
                    while(FTP_MOREDATA == $ret) {
                        $ret = ftp_nb_continue($conn_id);
                    }

                    if($ret == FTP_FINISHED) {
                        echo "File '" . $remote_file . "' uploaded successfully.";
                    } else {
                        echo "Failed uploading file '" . $remote_file . "'.";
                    }
                } else {
                    echo "Cannot connect to FTP server at " . $ftp_server;
                }   

                print_r($catalogue->update_images_catalog($filen,$ctdid));


            }
            else
            {
                echo "<script>";
                echo "alert('Image Size Shouldnot be Greater Than 50 KiloByte and upload only jpeg/png image');";
                echo "</script>";
            }
        }	


    }

    if(isset($_POST['SaveTS']))
    {


        $ctdid = $_POST['tid'];
        $filName = $_POST['filNameT'];


        $doc_name = $filName;
        $dt_id = 'SPLD';
        $res9 = $catalogue->CreateGFSSupplierDocFileID($doc_name,$dt_id);

        $main_folder = $res9->result_set->main_folder;
        $sub_folder = $res9->result_set->sub_folder;
        $gfs_filename = $res9->result_set->gfs_filename;


        $ftp_server = FTP_SERVER_IP;
        $ftp_user_name = FTP_USER_NAME;
        $ftp_user_pass = FTP_USER_PASS;



        if($_FILES['SaveImgT']['name']!='')
        {

            $size=$_FILES['SaveImgT']['size'];
            $type=$_FILES['SaveImgT']['type'];
            if($size<=50000000000)
            {
                $file=$_FILES['SaveImgT']['name'];
                $temp_name=$_FILES['SaveImgT']['tmp_name'];
                //$path=$_SERVER['DOCUMENT_ROOT']."/Proclaim/supTCP4/Temp/".$file ;
                $path=$_SERVER['DOCUMENT_ROOT']."/Supplies/supTCP4/Temp/".$file ;

                move_uploaded_file($temp_name,$path);

                //$file = 'addGrey.jpg';
                $conn_id = ftp_connect($ftp_server);
                $login_result = @ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if($login_result)
                {

                    ftp_pasv($conn_id, true);

                    if(!@ftp_chdir($conn_id, $main_folder)) {

                        ftp_mkdir($conn_id, $main_folder);
                        ftp_chdir($conn_id, $main_folder);
                    } 

                    if(!@ftp_chdir($conn_id, $sub_folder)) {

                        ftp_mkdir($conn_id, $sub_folder);
                        ftp_chdir($conn_id, $sub_folder);
                    } 


                    $filen = $file;	
                    $file = $temp_name ;
                    $remote_file = $filen;

                    $ret = ftp_nb_put($conn_id, $remote_file, $file, FTP_BINARY, FTP_AUTORESUME);
                    while(FTP_MOREDATA == $ret) {
                        $ret = ftp_nb_continue($conn_id);
                    }

                    if($ret == FTP_FINISHED) {
                        echo "File '" . $remote_file . "' uploaded successfully.";
                    } else {
                        echo "Failed uploading file '" . $remote_file . "'.";
                    }
                } else {
                    echo "Cannot connect to FTP server at " . $ftp_server;
                }   

                print_r($catalogue->update_tech_catalog($filen,$ctdid));


            }
            else
            {
                echo "<script>";
                echo "alert('Image Size Shouldnot be Greater Than 50 KiloByte and upload only jpeg/png image');";
                echo "</script>";
            }
        }	


    }

    if(isset($_POST['SaveUM']))
    {


        $ctdid = $_POST['uid'];
        $filName = $_POST['filNameU'];


        $doc_name = $filName;
        $dt_id = 'SPLD';
        $res9 = $catalogue->CreateGFSSupplierDocFileID($doc_name,$dt_id);

        $main_folder = $res9->result_set->main_folder;
        $sub_folder = $res9->result_set->sub_folder;
        $gfs_filename = $res9->result_set->gfs_filename;


        $ftp_server = FTP_SERVER_IP;
        $ftp_user_name = FTP_USER_NAME;
        $ftp_user_pass = FTP_USER_PASS;



        if($_FILES['SaveImgU']['name']!='')
        {

            $size=$_FILES['SaveImgU']['size'];
            $type=$_FILES['SaveImgU']['type'];
            if($size<=50000000000)
            {
                $file=$_FILES['SaveImgU']['name'];
                $temp_name=$_FILES['SaveImgU']['tmp_name'];
                //$path=$_SERVER['DOCUMENT_ROOT']."/Proclaim/supTCP4/Temp/".$file ;
                $path=$_SERVER['DOCUMENT_ROOT']."/Supplies/supTCP4/Temp/".$file ;

                move_uploaded_file($temp_name,$path);

                //$file = 'addGrey.jpg';
                $conn_id = ftp_connect($ftp_server);
                $login_result = @ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if($login_result)
                {

                    ftp_pasv($conn_id, true);

                    if(!@ftp_chdir($conn_id, $main_folder)) {

                        ftp_mkdir($conn_id, $main_folder);
                        ftp_chdir($conn_id, $main_folder);
                    } 

                    if(!@ftp_chdir($conn_id, $sub_folder)) {

                        ftp_mkdir($conn_id, $sub_folder);
                        ftp_chdir($conn_id, $sub_folder);
                    } 


                    $filen = $file;	
                    $file = $temp_name ;
                    $remote_file = $filen;

                    $ret = ftp_nb_put($conn_id, $remote_file, $file, FTP_BINARY, FTP_AUTORESUME);
                    while(FTP_MOREDATA == $ret) {
                        $ret = ftp_nb_continue($conn_id);
                    }

                    if($ret == FTP_FINISHED) {
                        echo "File '" . $remote_file . "' uploaded successfully.";
                    } else {
                        echo "Failed uploading file '" . $remote_file . "'.";
                    }
                } else {
                    echo "Cannot connect to FTP server at " . $ftp_server;
                }   

                print_r($catalogue->update_manual_catalog($filen,$ctdid));


            }
            else
            {
                echo "<script>";
                echo "alert('Image Size Shouldnot be Greater Than 50 KiloByte and upload only jpeg/png image');";
                echo "</script>";
            }
        }	


    }

    if(isset($_POST['createCatalogue']))
    {
        //$prodCode = $_POST['prodCode'];
        //$prodName = $_POST['prodName'];
        //$prodCode = $_POST['prodCode'];
        $searchType = $_POST['searchType'];

        if($searchType == "prodCode")
        {

            $iValue = $_POST['iValue'];
            $res = $catalogue->get_product_catalogById($iValue);
            //print_r($res1);
        }

        if($searchType == "prodName")
        {
            $conditionType = $_POST['conditionType'];
            $cValue = $_POST['cValue'];
            $res = $catalogue->searchMSupCatalog($conditionType,$cValue);
            //print_r($res);
        }
    }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Supplier - Catalogue</title>

    <link rel="stylesheet" type="text/css" href="css/Style.css"/>
    <link rel="stylesheet" type="text/css" href="css/jquery.alerts.css"  media="screen" /> 
    <link rel="stylesheet" type="text/css" href="css/PostLogin.css"/>
    <link rel="stylesheet" type="text/css" href="css/popUpStyle.css"/>
    <link rel="stylesheet" type="text/css" href="css/CatalogueBasic.css"/>

    <link rel="stylesheet" type="text/css" href="css/rhd.css"/> 
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="css/tcal.css" /> 
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />


    <script type="text/javascript" src="js/jquery-1.7.2.js"></script>
    <script type="text/javascript" src="js/jquery.ui.draggable.js" ></script>    
    <script type="text/javascript" src="js/jquery.alerts.js"></script>
    <script type="text/javascript" src="js/jquery-1.8.3.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>      
    <script type="text/javascript" src='js/jquery.simplemodal.js'></script>
    <script type="text/javascript" src='assets/Catalogue/js/Catalogue.js'></script>
    <script type="text/javascript" src="js/LoginFields.js"></script>


    <script type="text/javascript">                                 
        $(document).ready(function() {

            //  $("#p_icd_list").dropdownchecklist({ firstItemChecksAll: true, maxDropHeight: 100 });

        });
    </script>

    <script type='text/javascript'>
        function go_to_page(page_num){
            //get the number of items shown per page
            var show_per_page = parseInt($('#show_per_page').val());
            //alert(show_per_page);
            //get the element number where to start the slice from
            start_from = page_num * show_per_page;


            //get the element number where to end the slice
            end_on = start_from + show_per_page;

            //hide all children elements of content div, get specific items and show them
            $('#RfqcrDate').children().css('display', 'none').slice(start_from, end_on).css('display', 'block');

            /*get the page link that has longdesc attribute of the current page and add active_page class to it
            and remove that class from previously active page link*/
            $('.page_link[longdesc=' + page_num +']').addClass('active_page').siblings('.active_page').removeClass('active_page');

            //update the current page input field
            $('#current_page').val(page_num);
        }
        function previous(){

            new_page = parseInt($('#current_page').val()) - 1;

            //if there is an item before the current active link run the function
            if($('.active_page').prev('.page_link').length==true){
                go_to_page(new_page);
            }

        }

        function next(){
            new_page = parseInt($('#current_page').val()) + 1;
            //if there is an item after the current active link run the function
            if($('.active_page').next('.page_link').length==true){
                go_to_page(new_page);
            }

        }

    </script>

    <style>
        #page_navigation a{
            padding:3px ;
            padding-top:8px;
            border:1px solid #309dcf;
            margin:2px;
            text-align:center;

            margin-top:0px;
            color:#309dcf;
            height:21px;
            width:30px;
            text-decoration:none;
            float:left;
        }

        #page_navigation a.current{
            color:#ffffff;
        }
        .active_page{
            background:#309dcf;
            color:#000000 ;
        }
    </style>

    <style type="text/css">
        ul.pagination {
            font-family: "Arial", "Helvetica", sans-serif;
            font-size: 13px;
            color:#309dcf;
            height: 100%;
            list-style-type: none;
            margin: 20px 0;
            overflow: hidden;
            padding: 0;

        }
        ul.pagination li.details {
            background-color: white;
            border-color: #309dcf;
            border-image: none;
            border-style: solid;
            border-width: 1px 1px 1px;
            /*color: #1E598E;*/
            font-weight: bold;
            padding: 8px 8px;
            text-decoration: none;
        }
        ul.pagination li.dot {
            padding: 3px 0;
        }
        ul.pagination li {
            float: left;
            list-style-type: none;
            margin: 0 3px 0 0;
        }
        ul.pagination li:first-child {
            margin-left: 0;
        }
        ul.pagination li a {
            /*color: black;*/
            display: block;
            padding: 7px 8px;
            text-decoration: none;
        }
        ul.pagination li a img {
            border: medium none;
        }
        ul.pagination li a.current {
            background-color: #309dcf;

            border-radius: 0 0 0 0;
            /*color: #333333;*/
        }
        ul.pagination li a.current:hover {
            background-color: #309dcf;


        }
        ul.pagination li a:hover {
            background-color: #C8D5E0;
        }
        ul.pagination li a {
            background-color: #F6F6F6;
            border-color: #309dcf;
            border-image: none;
            border-style: solid;
            border-width: 1px 1px 2px;
            color: #309dcf;
            display: block;
            font-weight: bold;
            padding: 8px 8px;
            text-decoration: none;
        }
    </style>


</head>

<body background="gray">
<?php include_once 'assets/main/HeaderNew.php'; ?>
<?php include_once 'assets/main/LeftSideNew.php'; ?>
<div id="cat_rightside">   
    <div id="ret_data"> 
        
            <form method="post" action="" method="post">
                <!-- To Create the Button on Right Hand Side --> 
              <div class="internalManuBar" >   
                <input type="button" value="Create Catalogue" id="createCatalogue" name="createCatalogue" class="Pbutton orange" style="margin-top:3px; height: 25px; width:125px;float:right;" />
               
               <label class="hdr" style="float:left; vertical-align:top; margin-left: 1px; "margin-top:2px;  height: 25px;"">SEARCH ON </label>
                <select name="searchType"   class="inputDropDownSma"  style="float:left; margin-left:20px;" id="searchType" >
                    <option value="prodCode" >Product Code</option>
                    <option value="prodName" selected="selected">Product Name</option>                              
                </select>
                
                <div id="pNameSDiv" style="display:block;">
                    <label class="hdr" style="float:left; vertical-align:top; margin-left: 25px; "margin-top:2px;  height: 25px;"">WITH </label>
                    <select name="conditionType"  id="conditionType"  class="inputDropDownSma" style="float:left; margin-bottom:8px; margin-left:40px;" >

                        <option value="any_words" selected="selected">Any Words</option>
                        <option value="exclude_words">Exclude Words</option> 
                        <option value="or_words">OR Words</option> 
                        <option value="and_words">And Words</option>
                        <option value="exact_phrase">Exact Phrase</option>                             
                    </select>
                
                    <div style="display:block;" id="anyKeyWord">
                       <input type="text"  maxlength="30" style="float:left; height:20px; margin-left:50px;" class="inputTextSmall" name="cValue" id="cValue"/>
                    </div>
                </div> 

                <div id="pCodeSDiv" style="display:none;">
                    <input type="text"  maxlength="30" style="float:left; margin-top:2px; height:20px; margin-left:50px;" class="inputTextSmall" name="iValue" id="iValue"  />
                </div>
                <input type="submit" value="Search" id="createCatalogue" name="createCatalogue" class="Pbutton orange" style="margin-left:55px; width:125px; float:left; height: 25px;margin-top:3px;" />
                <!--</div> -->
                <!--dsads-->
              </div>   
            </form> 
         

        <!--<div class="internalDataGridBar">-->
            <div class="catlog_actionDiv" > 
            <div class="Tmenu_bgBigCatalogue" style="width: 100%; margin-left: 15px;">
                <div class="menuBG1" style="text-align:left; width:15%;">Code</div>
                <div class="menuBG1" style="text-align:left; width:30%;">Name</div>
                <div class="menuBG1" style="text-align:center;width:27%; border:none;">Action</div>
            </div>
            <div id="crDate">
                        <?php 
                            if($searchType == "prodName")
                            {
                                $num_of_rows = count($res->result_set);
                                $j=0;
                                $sl=1;
                                $l = 1;
                                while($j<$showPerPage){ 
                                    if(isset($_GET['page'])) { 
                                        $l = (($_GET['page']-1)*$showPerPage)+$j;
                                    }
                                    else { 
                                        $l = $j;
                                    }

                                    if($res->result_set[$l-1]->obj->p_code!="") {

                                        if($sl%2==1) {
                                        ?>

                                        <div id='pag'>
                                            <div class='Catalogue-Code'> <?php echo $res->result_set[$l-1]->obj->p_code; ?></div>
                                            <div class='Catalogue-Name'> <?php echo $res->result_set[$l-1]->obj->p_name; ?></div> 
                                        <div class='view'>
                                                <input type="hidden" name="vId" id="vId" value="<?php echo $res->result_set[$l-1]->_id; ?>"><a href="#"><strong><img src="images/view-catalog.png" style="width:16px; height:16px; border: 1px solid black;" title="VIEW EDIT CATALOGUE"/></strong></a>
                                        </div>
                                        <div class='delete'>
                                                <input type="hidden" name="vId" id="vId" value="<?php echo $res->result_set[$l-1]->_id; ?>"><a href="#"><strong><img src="images/delete-catalog.png" style="width:16px; height:16px; border: 1px solid black;" title="DELETE CATALOGUE"/></strong></a>
                                        </div>
                                        </div>
                                        <?php
                                        } else{ ?>

                                        <div id='pag1'> 
                                            <div class='Catalogue-Code'><?php echo $res->result_set[$l-1]->obj->p_code; ?></div>
                                            <div class='Catalogue-Name'><?php echo $res->result_set[$l-1]->obj->p_name; ?></div>
                                        <div class='view'>
                                                <input type="hidden" name="vId" id="vId" value="<?php echo $res->result_set[$l-1]->_id; ?>"><a href="#"><strong><img src="images/view-catalog.png" style="width:16px; height:16px; border: 1px solid black;" title="VIEW EDIT CATALOGUE"/></strong></a>
                                            </div>
                                            <div class='delete'>
                                                <input type="hidden" name="vId" id="vId" value="<?php echo $res->result_set[$l-1]->_id; ?>"><a href="#"><strong><img src="images/delete-catalogue.png" style="width:16px; height:16px; border: 1px solid black;" title="DELETE CATALOGUE"/></strong></a>
                                            </div>
                                        </div>
                                        <?php
                                    }}
                                    ++$j; 
                                    ++$sl; 
                                    // echo $num_of_rows;
                            } }else if($searchType == "prodCode"){

                                    $num_of_rows = count($res->result_set);
                                    $j=0;
                                    $sl=1;
                                    $l = 1;
                                    while($j<$showPerPage){ 
                                        if(isset($_GET['page'])) { 
                                            $l = (($_GET['page']-1)*$showPerPage)+$j;
                                        }
                                        else { 
                                            $l = $j;
                                        }

                                        if($res->result_set[$l-1]->p_code!="") {

                                            if($sl%2==1) {
                                            ?>

                                            <div id='pag'>
                                                <div class='Catalogue-Code'> <?php echo $res->result_set[$l-1]->p_code; ?></div>
                                                <div class='Catalogue-Name'> <?php echo $res->result_set[$l-1]->p_name; ?></div>                                   


                                                <div class='view'>
                                                    <input type="hidden" name="vId" id="vId" value="<?php echo $res->result_set[$l-1]->_id; ?>"><a href="#"><strong><img src="images/view-catalog.png" style="width:16px; height:16px; border: 1px solid black;" title="VIEW EDIT CATALOGUE"/></strong></a>
                                                </div>
                                                <div class='delete'>
                                                    <input type="hidden" name="vId" id="vId" value="<?php echo $res->result_set[$l-1]->_id; ?>"><a href="#"><strong><img src="images/delete-catalogue.png" style="width:16px; height:16px; border: 1px solid black;" title="DELETE CATALOGUE"/></strong></a>
                                                </div>
                                            </div>
                                            <?php
                                            } else{ ?>

                                            <div id='pag1'> 
                                                <div class='Catalogue-Code'><?php echo $res->result_set[$l-1]->p_code; ?></div>
                                                <div class='Catalogue-Name'><?php echo $res->result_set[$l-1]->p_name; ?></div>
                                               <div class='view'>
                                                    <input type="hidden" name="vId" id="vId" value="<?php echo $res->result_set[$l-1]->_id; ?>"><a href="#"><strong><img src="images/view-catalog.png" style="width:16px; height:16px; border: 1px solid black;" title="VIEW EDIT CATALOGUE"/></strong></a>
                                                </div>
                                                <div class='delete'>
                                                    <input type="hidden" name="vId" id="vId" value="<?php echo $res->result_set[$l-1]->_id; ?>"><a href="#"><strong><img src="images/delete-catalogue.png" style="width:16px; height:16px; border: 1px solid black;" title="DELETE CATALOGUE"/></strong></a>
                                                </div>
                                            </div>
                                            <?php
                                        }}
                                        ++$j; 
                                    ++$sl; 
                                    // echo $num_of_rows;
                                }


                        } ?>


                    </div>
       </div>
<!--    sasa-->
    </div>

    <div class="internalDataGridBarCatalogue">
    <div class="catlog_boxDiv" style="display:none;">
        <div class="catLog">
            <div class="cat_row" style="width:98%;"> </div>
            <div class="cat_row">
                <div class="cat_colF">Code</div><div class="cat_colR"><input type="text" class="inputTextSmall_cat" name="vp_code" id="vp_code" maxlength="10"/></div>
                <div class="cat_colF">Name</div><div class="cat_colR"><input type="text" class="inputTextSmall_cat" name="vp_name" id="vp_name" maxlength=""/></div>
            </div>
            <div class="cat_row">
                <div class="cat_colF">Class Code</div><div class="cat_colR"><input type="text" class="inputTextSmall_cat" name="vp_class_code" id="vp_class_code" maxlength=""/></div>
                <div class="cat_colF">NDC</div><div class="cat_colR"><input type="text" class="inputTextSmall_cat" name="vp_ndc" id="vp_ndc" maxlength=""/></div>
            </div>
            <div class="cat_row">
                <div class="cat_colF">Product L*W*H</div><div class="cat_colR"><input type="text" class="inputTextSmall_cat" name="vp_unit_lwh" id="vp_unit_lwh" maxlength=""/></div>
                <div class="cat_colF">Retail price</div><div class="cat_colR"><input type="text" class="inputTextSmall_cat" name="vp_retail_pr" id="vp_retail_pr" maxlength=""/></div>
            </div>
            <div class="cat_row">
                <div class="cat_colF">Unit Weight</div><div class="cat_colR"><input type="text" class="inputTextSmall_cat" name="vp_unit_wt" id="vp_unit_wt" maxlength=""/></div>
                <div class="cat_colF">Product Bar Code</div><div class="cat_colR"><input type="text" class="inputTextSmall_cat" name="vp_bar_code" id="vp_bar_code" maxlength=""/></div>
            </div>
            <div class="cat_row">
                <div class="cat_colF">Url</div><div class="cat_colR"><input type="text" class="inputTextSmall_cat" name="vp_urls" id="vp_urls" maxlength=""/></div>
                <div class="cat_colF">Patient Group Analysis</div><div class="cat_colR"><input type="text" class="inputTextSmall_cat" name="vp_patgrp_anal_doc" id="vp_patgrp_anal_doc" maxlength=""/></div>
            </div>
        </div>
        <div id="CCEVKO">
            <div class="subHeader" style="width:95%; margin-top:20px; float:left;">Case Studies / Comments / Evaluations / Knowledge / Outcome Report<span><a href="#" id="showTView" style="font:bold 12px/14px Verdana, Arial, Helvetica, sans-serif; color:#fa7c4e; float:right; margin-right:10px;">SHOW </a></span></div>
            <div id="showTCView" style="display:none;">
                <div class="cat_row">
                    <div class="cat_colF2">Product Case Studies</div><div class="cat_colR2"><textarea class="inputTextArea_cat" id="vp_cs_doc" name="vp_cs_doc"></textarea></div>
                </div>
                <!-- <div class="cat_row">
                <div class="cat_colF2">Technical Specifications</div><div class="cat_colR2"><textarea class="inputTextArea_cat"></textarea></div>
                </div>-->
                <div class="cat_row">
                    <div class="cat_colF2">Comments</div><div class="cat_colR2"><textarea class="inputTextArea_cat" id="vp_comments" name="vp_comments"></textarea></div>
                </div>
                <div class="cat_row">
                    <div class="cat_colF2">Evaluations</div><div class="cat_colR2"><textarea class="inputTextArea_cat" id="vp_eval_doc" name="vp_eval_doc"></textarea></div>
                </div>
                <div class="cat_row">
                    <div class="cat_colF2">Knowledge</div><div class="cat_colR2"><textarea class="inputTextArea_cat" id="vp_kb" name="vp_kb"></textarea></div>
                </div>
                <div class="cat_row">
                    <div class="cat_colF2">Outcome Report</div><div class="cat_colR2"><textarea class="inputTextArea_cat" id="vp_outcome_doc" name="vp_outcome_doc"></textarea></div>
                </div>
                <div class="cat_row">
                    <div class="cat_colF2">Certain Type Of Disease</div><div class="cat_colR2"><textarea class="inputTextArea_cat"></textarea></div>
                </div>
            </div>
        </div>
        <div id="clinicalTDocDiv">
            <div class="cat_row">

                <div class="subHeader" style="width:750px; margin-top:10px; float:left;">Clinical Trial Documents
                    <div class="subHeader_Rtext">
                        <a href="#" id="showCTD" style="font:bold 12px/14px Verdana, Arial, Helvetica, sans-serif; color:#fa7c4e;">SHOW </a>
                        &nbsp;||&nbsp;
                        <a href="#" id="showCTDU" style="color:#ffffff;" >Upload</a>
                    </div>
                </div>

                <div id='pag' class="ctdDivR" style="display:none;">
                    <div class='Catalogue-Doc' id="ctdfile"> </div>
                    <div class='Catalogue-Delete'><a href="#" id="delFile"><input type="hidden" id="delPath" name="delPath" /><strong> Delete </strong></a></div>  
                </div>
                <form method="post" enctype="multipart/form-data">
                <div id='pag' class="ctdDivF" style="display:none;">
                    <div class="cat_row" >
                        <div class="row">

                            <div class="colF">File Name</div>
                            <div class="colR" style="width:70%; "><input type="text" name="filName" id="filName" class="inputTextSmall_cat" /></div>


                            <div class="colF">Upoload File</div>
                            <div class="colR" style="width:70%; "><input type="file" name="SaveCTDF" id="SaveCTDF" /><input type="hidden" name="ctdid" id="ctdid" /></div>

                            <div class="cat_colF" style="float:left; margin-left:200px;"><input type="submit" value="Save" id="SaveCTD" name="SaveCTD" class="Pbutton orange" style="width:100px;float:left;" /><input type="button" value="Cancel" id="CancelCTD" name="CancelCTD" class="Pbutton orange" style="width:100px;float:left;" /></div>

                        </div>
                    </div>

                </div>
            </div> 
            </form>
        </div>

        <div id="imagesDiv" >
            <form method="post" enctype="multipart/form-data">
                <div class="cat_row">
                    <div class="subHeader" style="width:750px; margin-top:10px; float:left;">Images
                        <div class="subHeader_Rtext">
                            <a href="#" id="showImage" style="font:bold 12px/14px Verdana, Arial, Helvetica, sans-serif; color:#fa7c4e;">SHOW </a>
                            &nbsp;||&nbsp;
                            <a href="#" id="showUImagef" style="color:#ffffff;" >Upload</a>
                        </div>
                    </div>

                    <div id='pag' class="iDivR" style="display:none;">
                        <div class='Catalogue-Doc' id="imgfile"> </div>
                        <div class='Catalogue-Delete'><strong> Delete </strong></div>  
                    </div>
                    <div id='pag' class="iDivF" style="display:none;">

                        <div class="cat_row" >

                            <div class="row">

                                <div class="colF">File Name</div>
                                <div class="colR" style="width:70%; "><input type="text" name="filNameI" id="filNameI" class="inputTextSmall_cat" /></div>
                                <div class="colF">Upoload File</div>
                                <div class="colR" style="width:70%; "><input type="file" name="SaveImg" id="SaveImg" /><input type="hidden" name="fid" id="fid" /></div>

                                <div class="cat_colF" style="float:left; margin-left:200px;"><input type="submit" value="Save" id="SaveIMGB" name="SaveIMGB" class="Pbutton orange" style="width:100px;float:left;" /><input type="button" value="Cancel" id="CancelIMG" name="CancelIMG" class="Pbutton orange" style="width:100px;float:left;" /></div>

                            </div>
                        </div>
                    </div>

                </div> 

            </form>
        </div>

        <div id="techSpecDiv">

            <form method="post" enctype="multipart/form-data">
                <div class="cat_row">
                    <div class="subHeader" style="width:750px; margin-top:10px; float:left;">Technical Specifications/ Manuals
                        <div class="subHeader_Rtext">
                            <a href="#" id="showManual" style="font:bold 12px/14px Verdana, Arial, Helvetica, sans-serif; color:#fa7c4e;">SHOW </a>
                            &nbsp;||&nbsp;
                            <a href="#" id="showManualF" style="color:#ffffff;" >Upload</a>
                        </div>
                    </div>

                    <div id='pag' style="display:none" class="tsDivR">
                        <div class='Catalogue-Doc' id="tsfile"> </div>
                        <div class='Catalogue-Delete'><strong> Delete </strong></div>   
                    </div>
                    <div id='pag' class="tsDivF" style="display:none;">

                        <div class="cat_row" >

                            <div class="row">


                                <div class="colF">File Name</div>
                                <div class="colR" style="width:70%; "><input type="text" name="filNameT" id="filNameT" class="inputTextSmall_cat" /></div>
                                <div class="colF">Upoload File</div>
                                <div class="colR" style="width:70%; "><input type="file" name="SaveImgT" id="SaveImgT" /><input type="hidden" name="tid" id="tid" /></div>

                                <div class="cat_colF" style="float:left; margin-left:200px;"><input type="submit" value="Save" id="SaveTS" name="SaveTS" class="Pbutton orange" style="width:100px;float:left;" /><input type="button" value="Cancel" id="CancelTS" name="CancelTS" class="Pbutton orange" style="width:100px;float:left;" /></div>

                            </div>
                        </div>
                    </div>
                </div> 
            </form>
        </div>
        <div id="userManualDiv">
            <form method="post" enctype="multipart/form-data">
            <div class="cat_row">
                <div class="subHeader" style="width:750px; margin-top:10px; float:left;">User Manuals
                    <div class="subHeader_Rtext">
                        <a href="#" id="showUManual" style="font:bold 12px/14px Verdana, Arial, Helvetica, sans-serif; color:#fa7c4e;">SHOW </a>
                        &nbsp;||&nbsp;
                        <a href="#" id="showUManualF" style="color:#ffffff;" >Upload</a>
                    </div>
                </div>

                <div id='pag' style="display:none;" class="umDivR">
                    <div class='Catalogue-Doc' id="umfile"> </div>
                    <div class='Catalogue-Delete'><strong> Delete </strong></div>   
                </div>
                <div id='pag' style="display:none;" class="umDivF">

                    <div class="cat_row" >

                        <div class="row" >


                            <div class="colF">File Name</div>
                            <div class="colR" style="width:70%; "><input type="text" name="filNameU" id="filNameU" class="inputTextSmall_cat" /></div>
                            <div class="colF">Upoload File</div>
                            <div class="colR" style="width:70%; "><input type="file" name="SaveImgU" id="SaveImgU" /><input type="hidden" name="uid" id="uid" /></div>

                            <div class="cat_colF" style="float:left; margin-left:200px;"><input type="submit" value="Save" id="SaveUM" name="SaveUM" class="Pbutton orange" style="width:100px;float:left;" /><input type="button" value="Cancel" id="CancelUM" name="CancelUM" class="Pbutton orange" style="width:100px;float:left;" /></div>

                        </div>
                    </div>
                </div>
            </div> 
        </div>


        <div class="cat_colF" style="float:right; margin-right:-50px;"><input type="button" value="Update" id="updateCat" name="updateCat" class="Pbutton orange" style="width:100px;float:left;" /><input type="submit" value="Back" id="backWard" name="backWard" class="Pbutton orange" style="width:100px;float:left;" /></div>

    </div>
    </div>
</div>
</form>



<!--<div style="float:left; margin-top:45px; margin-left:420px; display:block;" id="pagination"><div id='page_navigation'><?php echo pagination($showPerPage,$page,'body.php?pages=cat&page=',$num_of_rows); ?></div><input type="hidden" id="show_per_page" /><input type="hidden" id="current_page" /></div>-->

<!-- Create Catalogue Start -->
<div id="basic-modal-content3">

    <p>
    <div class="internalManupopUpBar" id="crCat">
    <label class="hdr" style="vertical-align:middle; margin-left: 1%; margin-top:4px;  height: 25px; float: left;">CREATE CATALOGUE</label>
    <div class="save" style="width:120px; float: right; vertical-align:middle;margin-top:30px; margin-right : 30px; font-weight:bold;"><input type="submit" class="Pbutton orange" value="Back" id = 'backClose' name="backClose" style=" vertical-align:middle;height:25px; width:120px; float: right; padding-right: 10px;" /></div>
    </div>
      
            <div class="row">
                <div class="colF">Code</div>
                <div class="colR"><input type="text" class="inputTextSmall" name="p_code" id="p_code" maxlength="10"/></div>
                <div class="colF">Name</div>
                <div class="colR"><input type="text" name="p_name" id="p_name" maxlength="20" class="inputTextSmall" /></div>
            </div>

            <div class="row">
                <div class="colF">Product Class Code</div>
                <div class="colR"><input type="text" class="inputTextSmall" name="p_class_code" id="p_class_code" /></div>
                <div class="colF">Product Case Studies</div>
                <div class="colR"><input type="text" name="p_cs_doc" id="p_cs_doc" maxlength="10" class="inputTextSmall" /></div>
            </div>
            <div class="row">
                <div class="colF">Url</div>
                <div class="colR"><input type="text" class="inputTextSmall" name="p_urls" id="p_urls" /></div>
                <div class="colF">Retail Price</div>
                <div class="colR"><input type="text" name="p_retail_pr" id="p_retail_pr" maxlength="10" class="inputTextSmall" /></div>
            </div>
            <div class="row">

                <div class="colF">NDC</div>
                <div class="colR"><input type="text" name="p_ndc" id="p_ndc" maxlength="13" class="inputTextSmall" /></div>
                <div class="colF">Product L*W*H</div>
                <div class="colR"><input type="text" name="p_unit_lwh" id="p_unit_lwh" maxlength="10" class="inputTextSmall" /></div>
            </div>
            <div class="row">
                <div class="colF">Product Bar Code</div>
                <div class="colR"><input type="text" class="inputTextSmall" name="p_bar_code" id="p_bar_code" maxlength="30" /></div>
                <div class="colF">Unit Weight</div>
                <div class="colR"><input type="text" name="p_unit_wt" id="p_unit_wt" maxlength="10" class="inputTextSmall" /></div>
            </div>
            <div class="row">

                <div class="colF">Technical Manual Name</div>
                <div class="colR"><input type="text" name="p_tm_file" id="p_tm_file" maxlength="20" class="inputTextSmall" /></div>
                <div class="colF">Product User File Name</div>
                <div class="colR"><input type="text" class="inputTextSmall" name="p_um_file" id="p_um_file" /></div>
            </div>
            <!--<div class="row">
            <div class="colF">Technical Specifications</div>
            <div class="colR" style="width:70%; "><textarea class="textA" name="p_tech_spec" id="p_tech_spec"></textarea></div>
            </div>-->


            <div class="row">

                <div class="colF">Comments</div>
                <div class="colR" style="width:70%; "><textarea class="textA" name="p_comments" id="p_comments"></textarea></div>

            </div>

            <div class="row">

                <div class="colF">Evaluations</div>
                <div class="colR" style="width:70%; "><textarea class="textA" name="p_eval_doc" id="p_eval_doc"></textarea></div>

            </div>



            <div class="row">

                <div class="colF">Outcome Report</div>
                <div class="colR" style="width:70%; "><textarea class="textA" name="p_outcome_doc" id="p_outcome_doc"></textarea></div>

            </div>
            <div class="row">

                <div class="colF">Major Patient Group Analysis</div>
                <div class="colR" style="width:70%; "><textarea class="textA" name="p_patgrp_anal_doc" id="p_patgrp_anal_doc"></textarea></div>

            </div>
            <div class="row">

                <div class="colF">Knowledge</div>
                <div class="colR" style="width:70%; "><textarea class="textA" name="p_kb" id="p_kb"></textarea></div>

            </div>

            <div class="row" style="margin-top:5px;">
             <div class="save" style="width:120px; margin-left:330px;"><input type="submit" class="Pbutton orange" value="Submit" id = 'insertCat' name="insertCat" style="height:25px;  width:120px;" /><input type="hidden" value="" id="nid" /></div>   
            </div>
     
    </p>
</div>
</div>
<!-- Create Catalogue End -->


<!-- View Catalogue Start -->
<div id="basic-modal-content1">

    <p>
    
    <div class="internalManupopUpBar" id="viewCat">
    <label class="hdr" style="vertical-align:middle; margin-left: 1%; margin-top:4px;  height: 25px; float: left;">VIEW CATALOGUE</label>
    </div>
    
    <div class="formArea">
            <div class="row">
                <div class="colF">Code</div>
                <div class="colR"><input type="text" class="inputTextSmall" name="vp_code" id="vp_code" disabled="disabled" /></div>
                <div class="colF">Name</div>
                <div class="colR"><input type="text" name="vp_name" id="vp_name" maxlength="20" class="inputTextSmall" disabled="disabled" /></div>
            </div>

            <div class="row"><div class="colF">Product Class Code</div><div class="colR"><input type="text" class="inputTextSmall" name="vp_class_code" id="vp_class_code" disabled="disabled"/></div><div class="colF">Product Case Studies </div><div class="colR"><input type="text" name="vp_cs_doc" id="vp_cs_doc" maxlength="20" class="inputTextSmall" disabled="disabled" /></div></div>

            <div class="row">
                <!-- 
                <div class="colF">Supplier Code</div><div class="colR"><input type="text" class="inputTextSmall" name="vp_sup_id" id="vp_sup_id" disabled="disabled" /></div>
                -->
                <div class="colF">NDC</div><div class="colR"><input type="text" name="vp_ndc" id="vp_ndc" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>

            <div class="row"><div class="colF">Major Patient Group Analysis</div><div class="colR"><input type="text" class="inputTextSmall" name="vp_patgrp_anal_doc" id="vp_patgrp_anal_doc" disabled="disabled"/></div><div class="colF">Product L*W*H</div><div class="colR"><input type="text" name="vp_unit_lwh" id="vp_unit_lwh" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>

            <div class="row"><div class="colF">Url</div><div class="colR"><input type="text" class="inputTextSmall" name="vp_urls" id="vp_urls" disabled="disabled"/></div><div class="colF">Retail Price</div><div class="colR"><input type="text" name="vp_retail_pr" id="vp_retail_pr" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>    

            <div class="row"><div class="colF">Images</div><div class="colR"><input type="text" class="inputTextSmall" name="vp_image_list" id="vp_image_list" disabled="disabled"/></div><div class="colF">Technical Manual Name</div><div class="colR"><input type="text" name="vp_tm_file" id="vp_tm_file" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>

            <div class="row"><div class="colF">Technical Specifications</div><div class="colR"><input type="text" class="inputTextSmall" name="vp_tech_spec" id="vp_tech_spec" disabled="disabled"/></div><div class="colF">Clinical Trial Doc</div><div class="colR"><input type="text" name="vp_ct_doc" id="vp_ct_doc" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>
            <div class="row"><div class="colF">User File Name</div><div class="colR"><input type="text" class="inputTextSmall" name="vp_um_file" id="vp_um_file" disabled="disabled" /></div><div class="colF">Comments</div><div class="colR"><input type="text" name="vp_comments" id="vp_comments" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>
            <div class="row"><div class="colF">Bar Code</div><div class="colR"><input type="text" class="inputTextSmall" name="vp_bar_code" id="vp_bar_code" disabled="disabled"/></div><div class="colF">Unit Weight</div><div class="colR"><input type="text" name="vp_unit_wt" id="vp_unit_wt" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>               
            <div class="row"><div class="colF">Certain type of Disease (List)</div><div class="colR"><input type="text" class="inputTextSmall" name="vp_icd_list" id="vp_icd_list" disabled="disabled"/></div><div class="colF">Evaluations</div><div class="colR"><input type="text" name="vp_eval_doc" id="vp_eval_doc" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>
            <div class="row"><div class="colF">Knowledge</div><div class="colR"><input type="text" class="inputTextSmall" name="vp_kb" id="vp_kb" disabled="disabled"/></div><div class="colF">Outcome report</div><div class="colR"><input type="text" name="vp_outcome_doc" id="vp_outcome_doc" resize="vertical" class="inputTextSmall"/></div></div>
            <div class="row"><div class="save"><input type="submit" class="cNbutton orange" value="Back" id = 'back' name="back" /><input type="hidden" value="" id="nid" /></div></div>
        </div></p> 

</div>
</div>
<!-- View Catalogue End -->




<!-- Delete Catalogue Start -->
<div id="basic-modal-content">

    <p>
    
   <!-- <div class="modalTopbar blue" id="viewCat">Delete Product Catalogue </div>  -->
    <div class="internalManupopUpBar" id="viewCat">
    <label class="hdr" style="vertical-align:middle; margin-left: 1%; margin-top:4px;  height: 25px; float: left;"> CATALOGUE</label>
    <input type="submit" class="Pbutton orange" value='Back' id ="backNew" name="back" style="float :right; margin-top: 2px;"/>
    </div>
    <div class="formArea">
            <div class="row">
                <div class="colF">Code</div>
                <div class="colR"><input type="text" class="inputTextSmall" name="dp_code" id="dp_code" disabled="disabled" /></div><div class="colF">Name</div><div class="colR"><input type="text" name="dp_name" id="dp_name" maxlength="20" class="inputTextSmall" disabled="disabled" /></div></div>

            <div class="row"><div class="colF">Product Class Code</div><div class="colR"><input type="text" class="inputTextSmall" name="dp_class_code" id="dp_class_code" disabled="disabled"/></div><div class="colF">Product Case Studies</div><div class="colR"><input type="text" name="dp_cs_doc" id="dp_cs_doc" maxlength="20" class="inputTextSmall" disabled="disabled" /></div></div>

            <div class="row">
                <!--
                <div class="colF">Supplier Code</div><div class="colR"><input type="text" class="inputTextSmall" name="dp_sup_id" id="dp_sup_id" disabled="disabled" /></div>
                -->
                <div class="colF">NDC</div><div class="colR"><input type="text" name="dp_ndc" id="dp_ndc" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div> 

            <div class="row"><div class="colF">Major Patient Group Analysis</div><div class="colR"><input type="text" class="inputTextSmall" name="dp_patgrp_anal_doc" id="dp_patgrp_anal_doc" disabled="disabled"/></div><div class="colF">Product L*W*H</div><div class="colR"><input type="text" name="dp_unit_lwh" id="dp_unit_lwh" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>

            <div class="row"><div class="colF">Url</div><div class="colR"><input type="text" class="inputTextSmall" name="dp_urls" id="dp_urls" disabled="disabled"/></div><div class="colF">Retail Price</div><div class="colR"><input type="text" name="dp_retail_pr" id="dp_retail_pr" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>    

            <div class="row"><div class="colF">Images</div><div class="colR"><input type="text" class="inputTextSmall" name="dp_image_list" id="dp_image_list" disabled="disabled"/></div><div class="colF">Technical Manual Name</div><div class="colR"><input type="text" name="dp_tm_file" id="dp_tm_file" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>

            <div class="row"><div class="colF">Technical Specifications</div><div class="colR"><input type="text" class="inputTextSmall" name="dp_tech_spec" id="dp_tech_spec" disabled="disabled"/></div><div class="colF">Clinical Trial Doc</div><div class="colR"><input type="text" name="dp_ct_doc" id="dp_ct_doc" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>
            <div class="row"><div class="colF">Product User File Name</div><div class="colR"><input type="text" class="inputTextSmall" name="dp_um_file" id="vp_um_file" disabled="disabled" /></div><div class="colF">Comments</div><div class="colR"><input type="text" name="dp_comments" id="dp_comments" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>
            <div class="row"><div class="colF">Product Bar Code</div><div class="colR"><input type="text" class="inputTextSmall" name="dp_bar_code" id="dp_bar_code" disabled="disabled"/></div><div class="colF">Unit Weight</div><div class="colR"><input type="text" name="dp_unit_wt" id="dp_unit_wt" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>               
            <div class="row"><div class="colF">Certain type of Disease (List)</div><div class="colR"><input type="text" class="inputTextSmall" name="dp_icd_list" id="dp_icd_list" disabled="disabled"/></div><div class="colF">Evaluations</div><div class="colR"><input type="text" name="dp_eval_doc" id="dp_eval_doc" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>
            <div class="row"><div class="colF">Knowledge</div><div class="colR"><input type="text" class="inputTextSmall" name="dp_kb" id="dp_kb" disabled="disabled"/></div><div class="colF">Outcome report</div><div class="colR"><input type="text" name="dp_outcome_doc" id="dp_outcome_doc" maxlength="20" class="inputTextSmall" disabled="disabled"/></div></div>

            <div class="row">
            <div class="save"><input type="submit" class="cNbutton orange" value="Delete" id = 'delete' name="delete" /><input type="hidden" value="did" id="did" /></div>
            
            
            </div>
            
        </div></p> 
</div>
<!-- Delete Catalogue End -->





</div>
<!-- Create prod. info request ends --> 
<?php include_once 'assets/main/FooterNew.php'; ?>
