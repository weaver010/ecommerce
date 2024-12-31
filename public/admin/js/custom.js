$(document).ready(function(){

	// Show/Hide Coupon Field for Manual/Automatic
	$("#ManualCoupon").click(function(){
		$("#couponField").show();
	});

	$("#AutomaticCoupon").click(function(){
		$("#couponField").hide();
	})

	// Show Courier Name and Tracking Number in case of Shipped Order Status
	$("#courier_name").hide();
	$("#tracking_number").hide();
	$("#order_status").on("change",function(){
		if(this.value=="Shipped"){
			$("#courier_name").show();
			$("#tracking_number").show();
		}else{
			$("#courier_name").hide();
			$("#tracking_number").hide();
		}
	});

	// Check Admin Password is correct or not
	$("#current_pwd").keyup(function(){
		var current_pwd = $("#current_pwd").val();
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			type:'post',
			url:'/admin/check-current-password',
			data:{current_pwd:current_pwd},
			success:function(resp){
				if(resp=="false"){
					$("#verifyCurrentPwd").html("<font color='red'>Current Password is Incorrect!</font>");
				}else if(resp=="true"){
					$("#verifyCurrentPwd").html("<font color='green'>Current Password is Correct!</font>");
				}
			},error:function(){
				alert("Error");
			}
		})
	});

	// Update CMS Page Status
	$(document).on("click",".updateCmsPageStatus",function(){	
		var status = $(this).children("i").attr("status");
		var page_id = $(this).attr("page_id");
		$.ajax({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type:'post',
			url:'/admin/update-cms-page-status',
			data:{status:status,page_id:page_id},
			success:function(resp){
				if(resp['status']==0){
					$("#page-"+page_id).html("<i class='fas fa-toggle-off' style='color:grey' aria-hidden='true' status='Inactive'></i>");	
				}else if(resp['status']==1){
					$("#page-"+page_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");	
				}
			},error:function(){
				alert("Error");
			}
		});
	});

	// Confirm the deletion of the CMS Page
	/*$(".confirmDelete").click(function(){
		var name = $(this).attr('name');
		if(confirm('Are you sure to delete this '+name+'?')){
			return true;
		}
		return false;
	});*/

	// Confirm Deletion with SweetAlert
	$(document).on("click",".confirmDelete",function(){	
		var record = $(this).attr("record");
		var recordid = $(this).attr("recordid");
		Swal.fire({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.value) {
		  	Swal.fire(
				'Deleted!',
				'Your file has been deleted.',
				'success'
				)
		    window.location.href="/admin/delete-"+record+"/"+recordid;		    
		  }
		});
	});


	// Update Subadmin Status
	$(document).on("click",".updateSubadminStatus",function(){	
		var status = $(this).children("i").attr("status");
		var subadmin_id = $(this).attr("subadmin_id");
		$.ajax({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type:'post',
			url:'/admin/update-subadmin-status',
			data:{status:status,subadmin_id:subadmin_id},
			success:function(resp){
				if(resp['status']==0){
					$("#subadmin-"+subadmin_id).html("<i class='fas fa-toggle-off' style='color:grey' aria-hidden='true' status='Inactive'></i>");	
				}else if(resp['status']==1){
					$("#subadmin-"+subadmin_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");	
				}
			},error:function(){
				alert("Error");
			}
		});
	});

	// Update Category Status
	$(document).on("click",".updateCategoryStatus",function(){
		var status = $(this).children("i").attr("status");
		var category_id = $(this).attr("category_id");
		$.ajax({
		headers: {
		       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		   },
		   type:'post',
		   url:'/admin/update-category-status',
		   data:{status:status,category_id:category_id},
		   success:function(resp){
		    if(resp['status']==0){
		    $("#category-"+category_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
		    }else if(resp['status']==1){
		    $("#category-"+category_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
		    }
		   
		   },error:function(){
		    alert("Error");
		   }
		})
	})

	// Update Brand Status
	$(document).on("click",".updateBrandStatus",function(){
		var status = $(this).children("i").attr("status");
		var brand_id = $(this).attr("brand_id");
		$.ajax({
			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
		    type:'post',
		    url:'/admin/update-brand-status',
		    data:{status:status,brand_id:brand_id},
		    success:function(resp){
		    	if(resp['status']==0){
		    		$("#brand-"+brand_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
		    	}else if(resp['status']==1){
		    		$("#brand-"+brand_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
		    	}
		    	
		    },error:function(){
		    	alert("Error");
		    }	
		})
	})


	// Update Product Status
	$(document).on("click",".updateProductStatus",function(){
		var status = $(this).children("i").attr("status");
		var product_id = $(this).attr("product_id");
		$.ajax({
			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
		    type:'post',
		    url:'/admin/update-product-status',
		    data:{status:status,product_id:product_id},
		    success:function(resp){
		    	if(resp['status']==0){
		    		$("#product-"+product_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
		    	}else if(resp['status']==1){
		    		$("#product-"+product_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
		    	}
		    	
		    },error:function(){
		    	alert("Error");
		    }	
		})
	})

	// Update Attribute Status
	$(document).on("click",".updateAttributeStatus",function(){	
		var status = $(this).children("i").attr("status");
		var attribute_id = $(this).attr("attribute_id");
		$.ajax({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type:'post',
			url:'/admin/update-attribute-status',
			data:{status:status,attribute_id:attribute_id},
			success:function(resp){
                if(resp['status']==0){
                    $("#attribute-"+attribute_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
                }else if(resp['status']==1){
                    $("#attribute-"+attribute_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
                }
			},error:function(){
				alert("Error");
			}
		});
	});

	// Update Banner Status
	$(document).on("click",".updateBannerStatus",function(){
		var status = $(this).children("i").attr("status");
		var banner_id = $(this).attr("banner_id");
		$.ajax({
			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
		    type:'post',
		    url:'/admin/update-banner-status',
		    data:{status:status,banner_id:banner_id},
		    success:function(resp){
		    	if(resp['status']==0){
		    		$("#banner-"+banner_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
		    	}else if(resp['status']==1){
		    		$("#banner-"+banner_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
		    	}
		    	
		    },error:function(){
		    	alert("Error");
		    }	
		})
	})

	// Update Coupon Status
	$(document).on("click",".updateCouponStatus",function(){
		var status = $(this).children("i").attr("status");
		var coupon_id = $(this).attr("coupon_id");
		$.ajax({
			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
		    type:'post',
		    url:'/admin/update-coupon-status',
		    data:{status:status,coupon_id:coupon_id},
		    success:function(resp){
		    	if(resp['status']==0){
		    		$("#coupon-"+coupon_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
		    	}else if(resp['status']==1){
		    		$("#coupon-"+coupon_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
		    	}
		    	
		    },error:function(){
		    	alert("Error");
		    }	
		})
	})

	// Update User Status
	$(document).on("click",".updateUserStatus",function(){
		var status = $(this).children("i").attr("status");
		var user_id = $(this).attr("user_id");
		$.ajax({
			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
		    type:'post',
		    url:'/admin/update-user-status',
		    data:{status:status,user_id:user_id},
		    success:function(resp){
		    	if(resp['status']==0){
		    		$("#user-"+user_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
		    	}else if(resp['status']==1){
		    		$("#user-"+user_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
		    	}
		    	
		    },error:function(){
		    	alert("Error");
		    }	
		})
	})

	// Update Shipping Charges
	$(document).on("click",".updateShippingStatus",function(){
		var status = $(this).children("i").attr("status");
		var shipping_id = $(this).attr("shipping_id");
		$.ajax({
			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
		    type:'post',
		    url:'/admin/update-shipping-status',
		    data:{status:status,shipping_id:shipping_id},
		    success:function(resp){
		    	if(resp['status']==0){
		    		$("#shipping-"+shipping_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
		    	}else if(resp['status']==1){
		    		$("#shipping-"+shipping_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
		    	}
		    	
		    },error:function(){
		    	alert("Error");
		    }	
		})
	});   


	// Add Attribute Script
	var maxField = 10; //Input fields increment limitation
	var addButton = $('.add_button'); //Add button selector
	var wrapper = $('.field_wrapper'); //Input field wrapper
	var fieldHTML = '<div class="controls field_wrapper" style="margin-left:0px; margin-top:10px;"><input type="text" name="sku[]" style="width:120px"/>&nbsp;<input type="text" name="size[]" style="width:120px"/>&nbsp;<input type="text" name="price[]" style="width:120px"/>&nbsp;<input type="text" name="stock[]" style="width:120px"/><a href="javascript:void(0);" class="remove_button" title="Remove field">Remove</a></div>'; //New input field html 
	var x = 1; //Initial field counter is 1
	$(addButton).click(function(){ //Once add button is clicked
	if(x < maxField){ //Check maximum number of input fields
	x++; //Increment field counter
	$(wrapper).append(fieldHTML); // Add field html
	}
	});
	$(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
	e.preventDefault();
	$(this).parent('div').remove(); //Remove field html
	x--; //Decrement field counter
	});
	 
	//Once remove button is clicked
	$(wrapper).on('click', '.remove_button', function(e){
	e.preventDefault();
	$(this).parent('div').remove(); //Remove field html
	x--; //Decrement field counter
	});



});