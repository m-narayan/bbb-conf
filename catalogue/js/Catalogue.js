$(document).ready(function() { 
						   
						   
	var showTView = 0;
	var showCTDView = 0;
	var showIView = 0;
	var showISMView = 0;
	var showUMView = 0;
	
	
    $('#createCatalogue').click(function() { 
        $('#basic-modal-content3').modal();
        $('#basic-modal-content3').height(500);
        $('#simplemodal-container').draggable( { 
            containment: 'window', 
            scroll: false, 
            handle: '#crCat',
            cursor: 'move'
        });
    });
	 $('#delFile').live('click',function (e) {
		var delPath=$(this).find('#delPath').val();
		
		$.post("ajax/CatalogueAjax.php", {delPath : delPath}, function(data){ 
            //checkViewInfoRes(jQuery.parseJSON(data)); 
			alert(data);
        })
								 
        //alert(delPath);
    });
	
	$('#showCTDU').click(function() { 
								 
        $('.ctdDivR').hide();
		$('.ctdDivF').show();
    });
	
	/*$('#showCTD').click(function() { 
								 
		$('.ctdDivR').show();
		$('.ctdDivF').hide();
    });*/
	
	$('#showCTD').click(function (e) { 
					
			if(!showCTDView)
            {
				$('.ctdDivR').show('fast', function() {
					// Animation complete.
					$('#showCTD').empty();
					showCTDView = 1;
					$('#showCTD').append('HIDE');
					$('#CCEVKO').hide();
					$('#imagesDiv').hide();
					$('#techSpecDiv').hide();
					$('#userManualDiv').hide();
				});
				
       		 }
           else
            {

				$('.ctdDivR').hide('fast', function() {
					// Animation complete.
					$('#showCTD').empty();
					showCTDView = 0;
					$('#showCTD').append('SHOW');
					$('#CCEVKO').show();
					$('#imagesDiv').show();
					$('#techSpecDiv').show();
					$('#userManualDiv').show();
				});
				
       	     }
			       
    });
	
	$('#CancelCTD').click(function() { 
							 
				   $('.ctdDivF').hide();
				   $('#CCEVKO').show();
				   $('#imagesDiv').show();
				   $('#techSpecDiv').show();
				   $('#userManualDiv').show();
    });
	
	$('#showImage').click(function (e) { 
					
			if(!showIView)
            {
				$('.iDivR').show('fast', function() {
					// Animation complete.
					$('#showImage').empty();
					showIView = 1;
					$('#showImage').append('HIDE');
					$('#CCEVKO').hide();
					$('#clinicalTDocDiv').hide();
					$('#techSpecDiv').hide();
					$('#userManualDiv').hide();
				});
				
       		 }
           else
            {

				$('.iDivR').hide('fast', function() {
					// Animation complete.
					$('#showImage').empty();
					showIView = 0;
					$('#showImage').append('SHOW');
					$('#CCEVKO').show();
					$('#clinicalTDocDiv').show();
					$('#techSpecDiv').show();
					$('#userManualDiv').show();
				});
				
       	     }
			       
    });
	
	$('#backNew').click(function (e) { 
        $.modal.close();
    });
    
    $('#CancelIMG').click(function() { 
							 
				   $('.iDivF').hide();
				   $('#CCEVKO').show();
				   $('#imagesDiv').show();
				   $('#techSpecDiv').show();
				   $('#userManualDiv').show();
    });
	
	
	
	$('#showManual').click(function (e) { 
					
			if(!showISMView)
            {
				$('.tsDivR').show('fast', function() {
					// Animation complete.
					$('#showManual').empty();
					showISMView = 1;
					$('#showManual').append('HIDE');
					$('#CCEVKO').hide();
					$('#clinicalTDocDiv').hide();
					$('#imagesDiv').hide();
					$('#userManualDiv').hide();
				});
				
       		 }
           else
            {

				$('.tsDivR').hide('fast', function() {
					// Animation complete.
					$('#showManual').empty();
					showISMView = 0;
					$('#showManual').append('SHOW');
					$('#CCEVKO').show();
					$('#clinicalTDocDiv').show();
					$('#imagesDiv').show();
					$('#userManualDiv').show();
				});
				
       	     }
			       
    });
	
	$('#CancelTS').click(function() { 
							 
				   $('.tsDivF').hide();
				   $('#CCEVKO').show();
				   $('#imagesDiv').show();
				   $('#techSpecDiv').show();
				   $('#userManualDiv').show();
    });
	
	
	$('#showUManual').click(function (e) { 
					
			if(!showUMView)
            {
				$('.umDivR').show('fast', function() {
					// Animation complete.
					$('#showUManual').empty();
					showUMView = 1;
					$('#showUManual').append('HIDE');
					$('#CCEVKO').hide();
					$('#clinicalTDocDiv').hide();
					$('#imagesDiv').hide();
					$('#techSpecDiv').hide();
				});
				
       		 }
           else
            {

				$('.umDivR').hide('fast', function() {
					// Animation complete.
					$('#showUManual').empty();
					showUMView = 0;
					$('#showUManual').append('SHOW');
					$('#CCEVKO').show();
					$('#clinicalTDocDiv').show();
					$('#imagesDiv').show();
					$('#techSpecDiv').show();
				});
				
       	     }
			       
    });
	
	$('#CancelUM').click(function() { 
							 
				   $('.umDivF').hide();
				   $('#CCEVKO').show();
				   $('#imagesDiv').show();
				   $('#techSpecDiv').show();
				   $('#clinicalTDocDiv').show();
    });
	
	
	
	
	
	
	$('#showUImagef').click(function() { 
								 
		$('.iDivF').show();
		$('.iDivR').hide();
    });
	
	/*$('#showManual').click(function() { 
								 
        $('.tsDivF').hide();
		$('.tsDivR').show();
    });*/
	
	$('#showManualF').click(function() { 
								 
		$('.tsDivF').show();
		$('.tsDivR').hide();
    });
	
	$('#showUManual').click(function() { 
								 
        $('.umDivF').hide();
		$('.umDivR').show();
    });
	
	$('#showUManualF').click(function() { 
								 
		$('.umDivF').show();
		$('.umDivR').hide();
    });
	
	
	
	
	
	

    
    $('#insertCat').click(function() {  
        var p_code = $('#p_code').val(); 
        var p_name = $('#p_name').val();
        var p_class_code = $('#p_class_code').val();
		var p_cs_doc = $('#p_cs_doc').val();
		var p_ndc = $('#p_ndc').val();
		var p_patgrp_anal_doc = $('#p_patgrp_anal_doc').val();  
        var p_unit_lwh = $('#p_unit_lwh').val();
		
        var p_urls = $('#p_urls').val();
		var urlArray = new Array();				
        var temp = new Array();
        temp = p_urls.split(",");
        var i = 0;
        for (a in temp ) {
            temp[a] = temp[a];
            if(!i) { 
                urlArray[a] = '"'+temp[a]+'"';
            } else { 
                urlArray[a] = urlArray+','+'"'+temp[a]+'"';
            }
        }
        
        urlArray = '['+urlArray+']';
		
		
        var p_retail_pr = $('#p_retail_pr').val();
        var p_tm_file = $('#p_tm_file').val();
        var p_tech_spec = $('#p_tech_spec').val();  
        var p_ct_doc = $('#p_ct_doc').val();
        var p_um_file = $('#p_um_file').val();
        var p_comments = $('#p_comments').val();
        var p_bar_code = $('#p_bar_code').val();
        var p_unit_wt = $('#p_unit_wt').val();
        var p_eval_doc = $('#p_eval_doc').val();
        var p_kb = $('#p_kb').val();
        var p_outcome_doc = $('#p_outcome_doc').val();
		
		var ep_code = 0;
        var bp_code = 0;
        var ep_name = 0;
        var bp_name = 0;
        var ep_class_code = 0;
        var ep_cs_doc = 0;  
        var ep_sup_id = 0;  
        var ep_ndc = 0; 
        var ep_patgrp_anal_doc = 0;    
        var ep_unit_lwh  = 0;
        var ep_urls  = 0;
        var ep_retail_pr = 0; 
        var ep_image_list = 0;    
        var ep_tm_file= 0;
        var ep_tech_spec = 0;  
        var ep_ct_doc  = 0;
        var ep_um_file  = 0;        
        var ep_bar_code= 0;   
        var ep_unit_wt  = 0;
        var ep_icd_list = 0; 
        var ep_eval_doc  = 0; 
        var ep_kb   = 0;
        var ep_outcome_doc= 0;
        var ep_comments = 0

        var bp_class_code = 0;
        var bp_cs_doc = 0;  
        var bp_sup_id  = 0; 
        var bp_ndc  = 0;
        var bp_patgrp_anal_doc  = 0;
        var bp_unit_lwh  = 0;
        var bp_urls  = 0;
        var bp_retail_pr  = 0;
        var bp_image_list = 0;
        var bp_tm_file = 0;
        var bp_tech_spec = 0;  
        var bp_ct_doc  = 0;
        var bp_um_file  = 0; 
        var bp_bar_code = 0;  
        var bp_unit_wt  = 0;
        var bp_icd_list  = 0;
        var bp_eval_doc = 0;  
        var bp_kb   = 0;
        var bp_outcome_doc= 0;
		
		var valid_req = /^[a-zA-Z0-9]{1,15}$/;
        var validPcode_req = /^[a-zA-Z0-9]{4,10}$/;
        var url_req = /(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:/~\+#]*[\w\-\@?^=%&amp;/~\+#])?/;
        var validP_name_req = /^[a-zA-Z]{4,10}$/;
        var p_class_code_req = /^[a-zA-Z0-9]{4,10}$/;   
        var p_ndc_req = /^[a-zA-Z0-9]{10,13}$/;    
        var p_patgrp__req = /^[a-zA-Z]{1,10}$/;
        var p_retail_pr_req = /^[0-9]{1,10}$/;    
        var p_tm_file_req = /^[a-zA-Z]{5,33}$/;  
        var p_tech_spec_req = /^[.a-zA-Z0-9]{5,50}$/; 
        var p_ct_doc_req = /^[.a-zA-Z0-9]{5,50}$/;   
        var p_bar_code_req = /^[.0-9]{1,30}$/;  
        var p_unit_wt_req = /^[.a-zA-Z0-9]{1,10}$/; 
        var p_prod_eval_req = /^[a-zA-Z0-9]{1,10}$/; 
        var p_p_kb_req = /^[.a-zA-Z0-9]{1,20}$/;
        var validImage_req = /^[a-zA-Z0-9._]+(?:jpg|gif|png)$/;
        var p_cs_doc_req = /^[a-zA-Z]{5,33}$/; 
		

		
		
	if(p_kb== "")
            {
            jAlert('warning', 'Knowledge can not left blank', 'Error');
            bp_kb = 1;
        }else
            {
            if(p_kb!= "" && (!p_p_kb_req.test(p_kb)))
                {
                jAlert('warning', 'Please enter valid Knowledge', 'Error');
                ep_kb = 1;                                                        
            }
            else
                {
                ep_kb = 0;

            }
        }

        if(p_patgrp_anal_doc== "")
            {
            jAlert('warning', 'Analysis of Major Patient Group can not left blank', 'Error');
            bp_patgrp_anal_doc = 1;
        }else
            {
            if(p_patgrp_anal_doc!= "" && (!p_patgrp__req.test(p_patgrp_anal_doc)))
                {
                jAlert('warning', 'Please enter alphabets of max 10 character  Analysis of Major', 'Error');
                ep_patgrp_anal_doc = 1;
            }
            else
                {
                ep_patgrp_anal_doc = 0;

            }
        }
		
		if(p_outcome_doc== "") { 
            jAlert('warning', 'Outcome report can not left blank', 'Error');
            bp_outcome_doc = 1;
        }else {
            if(p_outcome_doc!= "" && (!valid_req.test(p_outcome_doc))) { 
                jAlert('warning', 'Please enter valid Outcome report', 'Error');
                ep_outcome_doc = 1;
            }
            else {
                ep_outcome_doc = 0;
            }
        }
		
		if(p_eval_doc== "")
            {
            jAlert('warning', 'Product evaluations can not left blank', 'Error');
            bp_eval_doc = 1;
        }else
            {
            if(p_eval_doc!= "" && (!p_prod_eval_req.test(p_eval_doc)))
                {
                jAlert('warning', 'Please enter valid product evaluations', 'Error');
                ep_eval_doc = 1;
            }
            else
                {
                ep_eval_doc = 0;

            }
        }
		

        

        if(p_comments== "")
            {
            jAlert('warning', 'Product  Comments can not left blank', 'Error');
            ep_comments = 1;
        }
        else

            {
            ep_comments = 0;


        }

		
		
		
		if(p_um_file== "")
            {
            jAlert('warning', 'Product User File Name can not left blank', 'Error');                          
            bp_um_file = 1; 
        }else
            {
            if(p_um_file!= "" && (!valid_req.test(p_um_file)))
                {
                jAlert('warning', 'Please enter valid product User File Name', 'Error');
                ep_um_file = 1;
            }
            else
                {
                ep_um_file = 0;

            }
        }
		
		
		if(p_tm_file== "")
            {
            jAlert('warning', 'Technical Manual Name can not left blank', 'Error');
            bp_tm_file = 1;
        }else
            {
            if(p_tm_file!= "" && (!p_tm_file_req.test(p_tm_file)))
                {
                jAlert('warning', 'Technical Manual cannot accept Numerals and special characters & less than 5 ch.', 'Error');
                ep_tm_file = 1;
            }
            else
                {
                ep_tm_file = 0;

            }
        }
		
		
		
		 if(p_unit_wt== "")
            {
            jAlert('warning', 'Unit Weight can not left blank', 'Error');
            bp_unit_wt = 1;
        }else
            {
            if(p_unit_wt!= "" && (!p_unit_wt_req.test(p_unit_wt)))
                {
                jAlert('warning', 'Please enter valid Unit Weight max 10 characters', 'Error');
                ep_unit_wt = 1;
            }
            else
                {
                ep_unit_wt = 0;

            }
        } 
		
		
		if(p_bar_code== "")
            {
            jAlert('warning', 'Product  Bar Code can not left blank', 'Error');
            bp_bar_code = 1;
        }else
            {
            if(p_bar_code!= "" && (!p_bar_code_req.test(p_bar_code)))
                {
                jAlert('warning', 'Bar Code cannot accept alphabets & special characters', 'Error');
                ep_bar_code = 1;
            }
            else
                {
                ep_bar_code = 0;

            }
        }
		
		
		
		if(p_unit_lwh== "")
            {
            jAlert('warning', 'Product Length can not left blank', 'Error');
            bp_unit_lwh = 1;
        }else
            {
            if(p_unit_lwh!= "" && (!valid_req.test(p_unit_lwh)))
                {
                jAlert('warning', 'Please enter valid Product Length of max 10 characters', 'Error');
                ep_unit_lwh = 1;
            }
            else
                {
                ep_unit_lwh = 0;

            }
        }
		
	

        if(p_ndc== "")
            {
            jAlert('warning', 'NDC code can not left blank', 'Error');
            bp_ndc = 1;
        }else
            {
            if(p_ndc!= "" && (!p_ndc_req.test(p_ndc)))
                {
                jAlert('warning', 'Please enter valid NDC code of length 10 to 13', 'Error');
                ep_ndc = 1;
            }
            else
                {
                ep_ndc = 0;

            }
        }
		
		if(p_retail_pr== "")
            {
            jAlert('warning', 'Retail Price can not left blank', 'Error');
            bp_retail_pr = 1;
        }else
            {
            if(p_retail_pr!= "" && (!p_retail_pr_req.test(p_retail_pr)))
                {
                jAlert('warning', 'Please enter valid Numerical Value of max 10', 'Error');
                ep_retail_pr = 1;
            }
            else
                {
                ep_retail_pr = 0;

            }
        }
		
		
		
		 if(p_urls== "")
            {
            jAlert('warning', 'Product URL can not left blank', 'Error');
            bp_urls = 1;
        }else
            {
            if(p_urls!= "" && (!url_req.test(p_urls)))
                {
                jAlert('warning', 'Please enter valid product URL', 'Error');
                ep_urls = 1;
            }
            else
                {
                ep_urls = 0;

            }
        }
		

        
		if(p_cs_doc== "")
            {
            jAlert('warning', 'Case studies of the product can not left blank', 'Error');
            bp_cs_doc = 1;
        }else
            {
            if(p_cs_doc!= "" && (!p_cs_doc_req.test(p_cs_doc)))
                {
                jAlert('warning', 'Please enter valid Case studies of product ', 'Error');
                ep_cs_doc = 1;
            }
            else
                {
                ep_cs_doc = 0;

            }
        }
		
		if(p_class_code== "")
            {
            jAlert('warning', 'Product class code can not left blank', 'Error');
            bp_class_code = 1;
        }else
            {
            if(p_class_code!= "" && (!p_class_code_req.test(p_class_code)))
                {
                jAlert('warning', 'Product class code must be alphabatic of min 4 character', 'Error');
                ep_class_code = 1;
            }
            else
                {
                ep_class_code = 0;

            }
        }
		
		if(p_name== "")
            {
            jAlert('warning', 'Product name can not left blank', 'Error');
            bp_name = 1;
        }else
            {
            if(p_name!= "" && (!validP_name_req.test(p_name)))
                {
                jAlert('warning', 'Valid product Name must be alphabetic and maximum 20 char in product name', 'Error');
                ep_name = 1;
            }
            else
                {
                ep_name = 0;

            }
        }				 

        if(p_code== "")
            {
            jAlert('warning', 'Product code can not left blank', 'Error');
            bp_code = 1;
        }else
            {
            if(p_code!= "" && (!validPcode_req.test(p_code)))
                {
                jAlert('warning', 'Please enter alpha numeric value of length 4 to 10 in product code ', 'Error');
                ep_code = 1;
            }
            else
                {
                ep_code = 0;

            }
        }	
		
		
		
       
	   if(ep_code == 0 && bp_code == 0 && bp_outcome_doc == 0 && ep_outcome_doc == 0 && bp_kb == 0 && ep_kb == 0 && bp_eval_doc == 0 && ep_eval_doc == 0 && bp_unit_wt == 0 && ep_unit_wt == 0 && bp_bar_code == 0 && ep_bar_code == 0 && bp_um_file == 0 && ep_um_file == 0 &&  bp_tm_file == 0 && ep_tm_file == 0 && bp_retail_pr == 0 && ep_retail_pr == 0 && bp_urls == 0 && ep_urls == 0 && bp_unit_lwh == 0 && ep_unit_lwh == 0 && bp_patgrp_anal_doc == 0 && ep_patgrp_anal_doc == 0 && bp_ndc == 0 && ep_ndc == 0 &&  bp_cs_doc == 0 && ep_cs_doc == 0 && bp_class_code == 0 && ep_class_code == 0 && bp_name == 0 && ep_name == 0 &&  ep_comments == 0 )

            {
				
				$.post("ajax/CatalogueAjax.php", {methodName : "create_product_catalog", p_name : p_name,  p_code : p_code, p_class_code : p_class_code, p_cs_doc : p_cs_doc, p_ndc : p_ndc, p_patgrp_anal_doc: p_patgrp_anal_doc,p_tm_file : p_tm_file,p_um_file : p_um_file,p_bar_code : p_bar_code,p_unit_wt : p_unit_wt,p_eval_doc : p_eval_doc,p_kb : p_kb,p_outcome_doc : p_outcome_doc, p_comments: p_comments, p_retail_pr : p_retail_pr, urlArray : urlArray, p_unit_lwh : p_unit_lwh }, function(data){


               checkInsertResponse(jQuery.parseJSON(data));
               // alert(data);
				
				});
			}
	   
	
    });


    function checkInsertResponse(data){
        if(data.status)
            {
            $.modal.close();
            jAlert('warning', 'Sucessfully Inserted', 'Success');
        }

    }



   

    function checkSearchVResponse(jsonResponse,id){ 
        if(jsonResponse.status) { 
            $('#vp_code').val(jsonResponse.result_set[0].p_code);
            $('#vp_name').val(jsonResponse.result_set[0].p_name);
            $('#vp_class_code').val(jsonResponse.result_set[0].p_class_code);
            $('#vp_cs_doc').val(jsonResponse.result_set[0].p_cs_doc);
            $('#vp_sup_id').val(jsonResponse.result_set[0].p_sup_id);
            $('#vp_ndc').val(jsonResponse.result_set[0].p_ndc);
            $('#vp_patgrp_anal_doc').val(jsonResponse.result_set[0].p_patgrp_anal_doc);
            $('#vp_tm_file').val(jsonResponse.result_set[0].p_tm_file);

            $('#vp_urls').val(jsonResponse.result_set[0].p_urls);
            $('#vp_image_list').val(jsonResponse.result_set[0].p_image_list);
            $('#vp_icd_list').val(jsonResponse.result_set[0].p_icd_list);

            $('#vp_tech_spec').val(jsonResponse.result_set[0].p_tech_spec);
            $('#vp_ct_doc').val(jsonResponse.result_set[0].p_ct_doc);
            $('#vp_um_file').val(jsonResponse.result_set[0].p_um_file);
            $('#vp_bar_code').val(jsonResponse.result_set[0].p_bar_code);
            $('#vp_eval_doc').val(jsonResponse.result_set[0].p_eval_doc);
            $('#vp_kb').val(jsonResponse.result_set[0].p_kb);
            $('#vp_outcome_doc').val(jsonResponse.result_set[0].p_outcome_doc);
			$('#ctdfile').append(jsonResponse.result_set[0].p_ct_doc);
			$('#imgfile').append(jsonResponse.result_set[0].p_image_list[0]);
			$('#tsfile').append(jsonResponse.result_set[0].p_tech_spec);
			$('#umfile').append(jsonResponse.result_set[0].p_um_file);
			$('#delPath').val(jsonResponse.result_set[0].p_ct_doc);
			//alert(jsonResponse.result_set[0].p_ct_doc);
			//alert(id);
			$('#ctdid').val(id);
			$('#fid').val(id);
			$('#tid').val(id);
			$('#uid').val(id);
			
			
        }
    }

    $('#back').click(function (e) { 
        $.modal.close();
    });
    //view ends

    //Reply Start
    $('.edit').live('click',function (e) {
        dispView = 0;
        var vId=$(this).find('#vId').val();

        $('#basic-modal-content2').modal();
        $('#basic-modal-content2').width(550);
        
        $('#simplemodal-container').draggable({ 
            containment: 'window', 
            scroll: false, 
            handle: '#viewCat',
            cursor: 'move'

        });

        $('#vId').val(vId);
        $.post("ajax/CatalogueAjax.php", {_id : vId}, function(data){ 
            checkSearchUResponse(jQuery.parseJSON(data));
        })

    });

    function checkSearchUResponse(jsonResponse){ 
        if(jsonResponse.status) { 
            $('#up_code').val(jsonResponse.result_set[0].p_code);
            $('#up_name').val(jsonResponse.result_set[0].p_name);
            $('#up_class_code').val(jsonResponse.result_set[0].p_class_code);
            $('#up_cs_doc').val(jsonResponse.result_set[0].p_cs_doc);
            $('#up_sup_id').val(jsonResponse.result_set[0].p_sup_id);
            $('#up_ndc').val(jsonResponse.result_set[0].p_ndc);
            $('#up_patgrp_anal_doc').val(jsonResponse.result_set[0].p_patgrp_anal_doc);
            $('#up_tm_file').val(jsonResponse.result_set[0].p_tm_file);

            $('#up_urls').val(jsonResponse.result_set[0].p_urls);
            $('#up_image_list').val(jsonResponse.result_set[0].p_image_list);
            $('#up_icd_list').val(jsonResponse.result_set[0].p_icd_list);

            $('#up_tech_spec').val(jsonResponse.result_set[0].p_tech_spec);
            $('#up_ct_doc').val(jsonResponse.result_set[0].p_ct_doc);
            $('#up_um_file').val(jsonResponse.result_set[0].p_um_file);
            $('#up_bar_code').val(jsonResponse.result_set[0].p_bar_code);
            $('#up_eval_doc').val(jsonResponse.result_set[0].p_eval_doc);
            $('#up_kb').val(jsonResponse.result_set[0].p_kb);
            $('#up_outcome_doc').val(jsonResponse.result_set[0].p_outcome_doc); 
        }
    } 

    $('#updateCat').click(function() {
        
        var p_code = $('#up_code').val(); 
        var p_name = $('#up_name').val();
        var p_class_code = $('#up_class_code').val();
        var p_cs_doc = $('#up_cs_doc').val();
        var p_sup_id = 's001';
        var p_ndc = $('#up_ndc').val();
        var p_patgrp_anal_doc = $('#up_patgrp_anal_doc').val();
        var p_unit_lwh = $('#up_unit_lwh').val();
        var p_urls = $('#up_urls').val();
        // alert(p_urls);
       /* var urlArray = new Array();				
        var temp = new Array();
        temp = p_urls.split(",");
        var i = 0;
        for (a in temp ) {
            temp[a] = temp[a];
            if(!i)
                {
                urlArray[a] = '"'+temp[a]+'"';
            }
            else
                {
                urlArray[a] = urlArray+','+'"'+temp[a]+'"';
            }

        }
        //var p_urls = '[]';
        urlArray = '['+urlArray+']';*/


        var p_retail_pr = $('#up_retail_pr').val();
        var p_image_list = $('#up_image_list').val();
        //var p_image_list = '[]';

      /*  var temp = new Array();
        var imageListArray = new Array();
        temp = p_image_list.split(",");
        var i = 0;
        for (a in temp ) {
            temp[a] = temp[a];
            if(!i)
                {
                imageListArray[a] = '"'+temp[a]+'"';
            }
            else
                {
                imageListArray[a] = imageListArray+','+'"'+temp[a]+'"';
            }

        }

        imageListArray = '['+imageListArray+']';*/

        var p_tm_file = $('#up_tm_file').val();
        var p_tech_spec = $('#up_tech_spec').val();
        var p_ct_doc = $('#up_ct_doc').val();
        var p_um_file = $('#up_um_file').val();
        var p_comments = $('#p_comments').val();
        var p_bar_code = $('#up_bar_code').val();
        var p_unit_wt = $('#up_unit_wt').val();
        var p_icd_list = $('#up_icd_list').val();
        var vid = $('#vId').val();

        //var p_icd_list = '[]';

       /* var temp = new Array();
        var icdListArray = new Array();
        temp = p_icd_list.split(",");
        var i = 0;
        for (a in temp ) {
            temp[a] = temp[a];
            if(!i)
                {
                icdListArray[a] = '"'+temp[a]+'"';
            }
            else
                {
                icdListArray[a] = icdListArray+','+'"'+temp[a]+'"';
            }

        }

        icdListArray = '['+icdListArray+']';*/

        var p_eval_doc = $('#up_eval_doc').val();
        var p_kb = $('#up_kb').val();
        var p_outcome_doc = $('#up_outcome_doc').val();
        //var p_sup_item = '8585';
        var vid = $('#vId').val();
        
        $.post("ajax/CatalogueAjax.php", {action : "update",v_id : vid,p_code : p_code, p_name : p_name, p_class_code : p_class_code, p_cs_doc : p_cs_doc, p_sup_id : p_sup_id, p_ndc : p_ndc, p_patgrp_anal_doc: p_patgrp_anal_doc,  p_tm_file : p_tm_file,p_tech_spec : p_tech_spec, p_ct_doc : p_ct_doc,p_um_file : p_um_file,p_bar_code : p_bar_code,p_unit_wt : p_unit_wt,p_eval_doc : p_eval_doc,p_kb : p_kb,p_outcome_doc : p_outcome_doc}, function(data){ 
          checkUpdateResponse(jQuery.parseJSON(data));
			//alert(data);
        }) 
    });

    function checkUpdateResponse(data){ 
	
	   if(data.status)
	   {
       
        jAlert('warning', 'Sucessfully Updated', 'Update');
	   }
	   else{
		   //alert(data.err_msg1);
		   jAlert('warning', data.err_msg1, 'Error');
	   }
    }
    //Reply End

    //Delete Start
    $('.delete').live('click',function (e) {
        dispView = 0;
        var vId=$(this).find('#vId').val();

        $('#basic-modal-content').modal();
        $('#simplemodal-container').draggable({ 
            containment: 'window', 
            scroll: false, 
            handle: '#viewCat',
            cursor: 'move'

        });
        $.post("ajax/CatalogueAjax.php", {_id : vId}, function(data){ 
            showDeletData(jQuery.parseJSON(data));
        })
    });

    function showDeletData(jsonResponse){ 
        if(jsonResponse.status) {
            $('#dp_code').val(jsonResponse.result_set[0].p_code);
            $('#dp_name').val(jsonResponse.result_set[0].p_name);
            $('#dp_class_code').val(jsonResponse.result_set[0].p_class_code);
            $('#dp_cs_doc').val(jsonResponse.result_set[0].p_cs_doc);
            $('#dp_sup_id').val(jsonResponse.result_set[0].p_sup_id);
            $('#dp_ndc').val(jsonResponse.result_set[0].p_ndc);
            $('#dp_patgrp_anal_doc').val(jsonResponse.result_set[0].p_patgrp_anal_doc);
            $('#dp_tm_file').val(jsonResponse.result_set[0].p_tm_file);

            $('#dp_urls').val(jsonResponse.result_set[0].p_urls);
            $('#dp_image_list').val(jsonResponse.result_set[0].p_image_list);
            $('#dp_icd_list').val(jsonResponse.result_set[0].p_icd_list);

            $('#dp_tech_spec').val(jsonResponse.result_set[0].p_tech_spec);
            $('#dp_ct_doc').val(jsonResponse.result_set[0].p_ct_doc);
            $('#dp_um_file').val(jsonResponse.result_set[0].p_um_file);
            $('#dp_bar_code').val(jsonResponse.result_set[0].p_bar_code);
            $('#dp_eval_doc').val(jsonResponse.result_set[0].p_eval_doc);
            $('#dp_kb').val(jsonResponse.result_set[0].p_kb);
            $('#dp_outcome_doc').val(jsonResponse.result_set[0].p_outcome_doc);
            $('#did').val(jsonResponse.result_set[0]._id);
        }
    }

    $('#delete').click(function() {
        var did = $('#did').val();
        $.post("ajax/CatalogueAjax.php", {did : did}, function(data){ 
            resDeletData(jQuery.parseJSON(data));
        })
    });	

    function resDeletData(data){ 
        $.modal.close();
        jAlert('warning', 'Sucessfully Deleted', 'Delete');
    }
    //Delete End
	
	 $('#backWard').click(function (e) { 
									
				$('.catlog_boxDiv').hide('fast', function() {
					
				});
									
				$('.catlog_actionDiv').show('fast', function() {
					
				});
       
    });
	 
	  //function for confirm which close the popup after confirm message.
	 $('#backClose').click(function() {
		

		 var p_code = $('#p_code').val(); 
         var p_name = $('#p_name').val();
         var p_class_code = $('#p_class_code').val();
		 var p_cs_doc = $('#p_cs_doc').val();
		 var p_urls = $('#p_urls').val();
		 var p_retail_pr = $('#p_retail_pr').val();
         var p_ndc = $('#p_ndc').val();
         var p_unit_lwh = $('#p_unit_lwh').val();
         var p_bar_code = $('#p_bar_code').val();
         var p_unit_wt = $('#p_unit_wt').val();
		 var p_tm_file = $('#p_tm_file').val();
		 var p_um_file = $('#p_um_file').val();
		 var p_comments = $('#p_comments').val();
         var p_eval_doc = $('#p_eval_doc').val();
		 var p_outcome_doc = $('#p_outcome_doc').val();
		 var p_patgrp_anal_doc = $('#p_patgrp_anal_doc').val(); 
		 var p_kb = $('#p_kb').val();
		 

	  if(p_code != "" || p_name != "" || p_class_code != "" || p_cs_doc != "" || p_urls != "" || p_retail_pr != "" || p_ndc != "" || p_unit_lwh != "" || p_bar_code != "" || p_unit_wt != "" || p_tm_file != "" || p_um_file != "" || p_comments != "" || p_eval_doc != "" || p_outcome_doc != "" || p_patgrp_anal_doc != "" || p_kb != ""  )
			{
				jConfirm('Are you sure you want to close this window?', 'Confirmation', '1');
			}
			else
			{
				$.modal.close();
			}
	  
    });
	 
	 //function for confirm  message.
	  $('#con_popup_ok').live('click',function (e) {
												
						storeArray = [];
    					storeIdArray = [];
						$.modal.close();
					});
	  
	 
	  $('.view').live('click',function (e) {
					
					var vId=$(this).find('#vId').val();
					// alert(vId);
				$('.catlog_actionDiv').hide('fast', function() {
					
				});	
				$('.catlog_boxDiv').show('fast', function() {
					
					     				    $.post("ajax/CatalogueAjax.php", {_id : vId}, function(data){ 
																								   
											//alert(data);
           									checkSearchVResponse(jQuery.parseJSON(data),vId);
											
       					 })
				});
									
				
       
    });
	  
	   $('#showTView').click(function (e) { 
					
			if(!showTView)
            {
				$('#showTCView').show('fast', function() {
					// Animation complete.
					$('#showTView').empty();
					showTView = 1;
					$('#showTView').append('HIDE');
					$('#clinicalTDocDiv').hide();
					$('#imagesDiv').hide();
					$('#techSpecDiv').hide();
					$('#userManualDiv').hide();
				});
				
       		 }
           else
            {

				$('#showTCView').hide('fast', function() {
					// Animation complete.
					$('#showTView').empty();
					showTView = 0;
					$('#showTView').append('SHOW');
					$('#clinicalTDocDiv').show();
					$('#imagesDiv').show();
					$('#techSpecDiv').show();
					$('#userManualDiv').show();
				});
				
       	     }
			       
    });
	   
	   
	  $('#SaveCTD').click(function (e) { 
									  
									  
				//alert('hello');	
				var comments = $('#comments').val();
				var remarks = $('#remarks').val();
									  
									  });
	  
	  
	  $( "#searchType" ).change(function() {
  			
			var searchType = $("#searchType").val();
			if(searchType == 'prodName')
			{
				$('#pCodeSDiv').hide();
				$('#pNameSDiv').show();
			}
			if(searchType == 'prodCode')
			{
				$('#pNameSDiv').hide();
				$('#pCodeSDiv').show();
			}
		});
	  
	   
	   
});
