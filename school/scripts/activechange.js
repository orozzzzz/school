 $(document).ready(function(){  
      $('input[type="checkbox"]').click(function(){  
           var number = $(this).val();  
           $.ajax({  
                url:"req/activechange.php",  
                method:"POST",  
                data:{id1:number}
           });  
      });  
 });  

  $(document).ready(function(){  
      $('button').click(function(){  
            if($(this).hasClass("photo")){
            	var cid = $(this).val();  
            	var number = $(this).attr("name");  
                var confirmed = $(this).attr("confirmed");  
            	$.ajax({  
	                url:"req/activechange.php",  
	                method:"POST",  
	                data:{photo:cid,status:confirmed},
	                success:function(data){  
                     if(data=='Ошибка'){
                     	alert(data);
                     }
                     else{
                    	var els = document.getElementsByClassName("consideration")[number];
						els.hidden=true;
                     }
                }  
         		});  
            }
            if($(this).hasClass("hcert")){
            	var cid = $(this).val();  
            	var number = $(this).attr("name");  
                var confirmed = $(this).attr("confirmed");  
            	$.ajax({  
	                url:"req/activechange.php",  
	                method:"POST",  
	                data:{hcert:cid,status:confirmed},
	                success:function(data){  
                     if(data=='Ошибка'){
                     	alert(data);
                     }
                     else{
                    	var els = document.getElementsByClassName("consideration")[number];
						els.hidden=true;
                     }
                }  
         		});  
            }
            if($(this).hasClass("cert")){
            	var cid = $(this).val();  
            	var number = $(this).attr("name");  
                var confirmed = $(this).attr("confirmed");  
            	$.ajax({  
	                url:"req/activechange.php",  
	                method:"POST",  
	                data:{cert:cid,status:confirmed},
	                success:function(data){  
                     if(data=='Ошибка'){
                     	alert(data);
                     }
                     else{
                    	var els = document.getElementsByClassName("consideration")[number];
						els.hidden=true;
                     }
                }  
         		});  
            }
            
      });  
 });  