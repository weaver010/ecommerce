$(document).ready(function() {
  /*$('#sort').on('change', function() {
    this.form.submit();
  });*/
  $(".getPrice").change(function(){
    var size = $(this).val();
    var product_id = $(this).attr("product-id");
    /*alert(product_id); return false;*/
    $.ajax({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
      url:'/get-attribute-price',
      data:{size:size,product_id:product_id},
      type:'post',
      success:function(resp){
        if(resp['discount']>0){
          $(".getAttributePrice").html("<span class='pd-detail__price'>₹"+resp['final_price']+"</span><span class='pd-detail__discount'>(10% OFF)</span><del class='pd-detail__del'>₹"+resp['product_price']+"</del>");
        }else{
          $(".getAttributePrice").html("<div class='pd-detail__price'>₹"+resp['final_price']+"</span>");
        }
      },error:function(){
        alert("Error");
      }
    });
  });

  // Apply Coupon
    $(document).on('click','#ApplyCoupon',function(){ 
      var user = $(this).attr("user");
      /*alert(user);*/
      if(user==1){
        // do nothing
      }else{
        alert("Please login to apply Coupon!");
        return false;
      }
      var code = $("#code").val();
      $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'post',
        data:{code:code},
        url:'/apply-coupon',
        success:function(resp){
          if(resp.status==false){
          // alert(resp.message);
          $('.print-error-msg').show();
          $('.print-error-msg').delay(3000).fadeOut('slow');
          $(".print-error-msg").html("<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Error! </strong>"+resp['message']+"</div>");
        }else if(resp.status==true){
          if(resp.couponAmount>0){
            $(".couponAmount").text("Rs."+resp.couponAmount);
          }else{
            $(".couponAmount").text("Rs.0");
          }
          if(resp.grand_total>0){
            $(".grand_total").text("Rs."+resp.grand_total);
          } 
          $('.print-success-msg').show();
          $('.print-success-msg').delay(3000).fadeOut('slow');
          $(".print-success-msg").html("<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success! </strong>"+resp['message']+"</div>");
        }
        $(".totalCartItems").html(resp.totalCartItems);
        $("#appendCartItems").html(resp.view);
        $("#appendMiniCartItems").html(resp.minicartview);
          
        },error:function(){
          alert("Error");
        }
      })
    });


  $("#addToCart").submit(function(e){
           e.preventDefault();
           $('.PleaseWaitDiv').show();
           var formdata = $("#addToCart").serialize();
           var actionType = $(document.activeElement).attr('id');
           /*alert(actionType); return false;*/
           $.ajax({
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
               url: '/add-to-cart',
               type:'POST',
               data: formdata,
               success: function(resp) {
                    if(resp['status']==true){
                        $(".totalCartItems").html(resp.totalCartItems);
                        $("#appendMiniCart").html(resp.minicartview);
                        $('.print-success-msg').show();
                        $('.print-success-msg').delay(3000).fadeOut('slow');
                        $(".print-success-msg").html("<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success! </strong>"+resp['message']+"</div>");
                    }else{
                      $('.print-error-msg').show();
                        $('.print-error-msg').delay(3000).fadeOut('slow');
                        $(".print-error-msg").html("<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Error! </strong>"+resp['message']+"</div>");
                    }
               },error:function(){
                  alert("Error");
               }
           });
       });

  // Update Cart Items Qty
  $(document).on('click','.updateCartItem',function(){
    if($(this).hasClass('fa-plus')){
      // Get Qty
      var quantity = $(this).data('qty');
      // increase the qty by 1
      new_qty = parseInt(quantity) + 1;
      /*alert(new_qty);*/
    }
    if($(this).hasClass('fa-minus')){
      // Get Qty
      var quantity = $(this).data('qty');
      // Check Qty is atleast 1
      if(quantity<=1){
        alert("Item quantity must be 1 or greater!");
        return false;
      }
      // decrease the qty by 1
      new_qty = parseInt(quantity) - 1;
      /*alert(new_qty);*/
    }
    var cartid = $(this).data('cartid');
    $.ajax({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
      data:{cartid:cartid,qty:new_qty},
      url:'/update-cart-item-qty',
      type:'post',
      success:function(resp){
        if(resp.status==false){
         alert(resp.message);
         }
        $("#appendCartItems").html(resp.view);
        $(".totalCartItems").html(resp.totalCartItems);
        $("#appendMiniCart").html(resp.minicartview);
      },error:function(){
        alert("Error");
      }
    });
  });

  // Delete Cart Item
  $(document).on('click','.deleteCartItem',function(){
    var cartid = $(this).data('cartid');
    var page = $(this).data("page");
    var result = confirm("Are you sure you want to delete this Cart Item?");
    if(result){
      $.ajax({
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data:{cartid:cartid,page:page},
          url:'/delete-cart-item',
          type:'post',
          success:function(resp){
            $(".totalCartItems").html(resp.totalCartItems);
            $("#appendCartItems").html(resp.view);  
            $("#appendMiniCartItems").html(resp.minicartview);  
            if(page=="Checkout"){
              window.location.href='/checkout';
            }
          },
          error:function(){
            alert("Error");
          }
      }); 
    }
  });

    // Empty Cart
    $(document).on('click','.emptyCart',function(){
        var result = confirm("Want to empty the Cart?");
        if (result) {
        $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
              url : '/empty-cart',
              type : 'post',
              success:function(resp){
                $(".totalCartItems").html(resp.totalCartItems);
                  $('#appendCartItems').html(resp.view);
                  $("#appendMiniCart").html(resp.minicartview);
              },  
              error:function(){
                  alert("Error");
              }
          })
      }
    })

    // Register Form Validation
    $("#registerForm").submit(function(){
        $(".loader").show();
        var formdata = $("#registerForm").serialize();
        /*alert(formdata); return false;*/
        $.ajax({
            url: "/user/register",
            type:'POST',
            data: formdata,
            success:function(data){
                if(data.type=="validation"){
                  $(".loader").hide();
                  $.each(data.errors, function (i, error) {
                  $('#register-'+i).attr('style', 'color:red');
                  $('#register-'+i).html(error);
                  setTimeout(function () {
                    $('#register-'+i).css({
                    'display': 'none'
                        });
                      }, 3000);
                   });
                }else if(data.type=="success"){
                  $(".loader").hide();
                  /*alert(data.message);*/
                  $("#register-success").attr('style','color:green');
                  $("#register-success").html(data.message);
                }
              },error:function(){
                $(".loader").hide();
                alert("Error");
            }
        });
    });

    // Login Form Validation
  $("#loginForm").submit(function(){
    var formdata = $(this).serialize();
    $.ajax({
      headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
      url:"/user/login",
      type:"POST",
      data:formdata,
      success:function(resp){
        if(resp.type=="error"){
          $.each(resp.errors,function(i,error){
            $(".login-"+i).attr('style','color:red');
            $(".login-"+i).html(error);
          setTimeout(function(){
            $(".login-"+i).css({
              'display':'none'
            });
          },3000);
          });
        }else if(resp.type=="incorrect"){
          alert(resp.message);
          $("#login-error").attr('style','color:red');
          $("#login-error").html(resp.message);
        }else if(resp.type=="inactive"){
          alert(resp.message);
          $("#login-error").attr('style','color:red');
          $("#login-error").html(resp.message);
        }else if(resp.type=="success"){
          window.location.href = resp.url;  
        }
        
      },error:function(){
        alert("Error");
      }
    })
  });

  // forgot form validation
  $("#forgotForm").submit(function(){
    $(".loader").show();
    var formData = $(this).serialize();
    $.ajax({
      headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url:"/user/forgot-password",
          type:'post',
          data:formData,
          success:function(resp){
            $(".loader").hide();
            if(resp.type=="error"){
            $.each(resp.errors, function (i,error) {
              $('.forgot-'+i).attr('style','color:red');
              $('.forgot-'+i).html(error);
              setTimeout(function(){
                $('.forgot-'+i).css({
                  'display':'none'
                })
              }, 4000);
            });
            }else if(resp.type=="success"){
              $(".forgot-success").attr('style','color:green');
            $(".forgot-success").html(resp.message);
            }
          },error:function(){
            $(".loader").hide();
            alert("Error");
          }
    })
  });

  // Reset Password form validation
  $("#resetPwdForm").submit(function(){
    $(".loader").show();
    var formData = $(this).serialize();
    $.ajax({
      headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url:"/user/reset-password",
          type:'post',
          data:formData,
          success:function(resp){
            $(".loader").hide();
            if(resp.type=="error"){
            $.each(resp.errors, function (i,error) {
              $('.reset-'+i).attr('style','color:red');
              $('.reset-'+i).html(error);
              setTimeout(function(){
                $('.reset-'+i).css({
                  'display':'none'
                })
              }, 4000);
            });
            }else if(resp.type=="success"){
              $(".reset-success").attr('style','color:green');
            $(".reset-success").html(resp.message);
            }
          },error:function(){
            $(".loader").hide();
            alert("Error");
          }
      })
    });

  // Account Form Validation
  $("#accountForm").submit(function(){
    $('#pageloader').show();
    $(".loader").show();
    var formdata = $(this).serialize();
    $.ajax({
      url:"/user/account",
      type:"POST",
      data:formdata,
      success:function(resp){
        if(resp.type=="error"){
          $('#pageloader').hide();
          $(".loader").hide();
          $.each(resp.errors,function(i,error){
            $("#account-"+i).attr('style','color:red');
            $("#account-"+i).html(error);
          setTimeout(function(){
            $("#account-"+i).css({
              'display':'none'
            });
          },3000);
          });
        }else if(resp.type=="success"){
          /*alert(resp.message);*/
          $('#pageloader').hide();
          $(".loader").hide();
          $("#account-success").attr('style','color:green');
          $("#account-success").html(resp.message);
          /*window.location.href = resp.url;*/  
        }
        
      },error:function(){
        alert("Error");
      }
    })
  });

  // Update User Password Form Validation
  $("#passwordForm").submit(function(){
    $('#pageloader').show();
    $(".loader").show();
    var formdata = $(this).serialize();
    $.ajax({
      url:"/user/change-password",
      type:"POST",
      data:formdata,
      success:function(resp){
        if(resp.type=="error"){
          $('#pageloader').hide();
          $(".loader").hide();
          $.each(resp.errors,function(i,error){
            $("#password-"+i).attr('style','color:red');
            $("#password-"+i).html(error);
          setTimeout(function(){
            $("#password-"+i).css({
              'display':'none'
            });
          },3000);
          });
        }else if(resp.type=="incorrect"){
          /*alert(resp.message);*/
          $('#pageloader').hide();
          $(".loader").hide();
          $("#password-error").attr('style','color:red');
          $("#password-error").html(resp.message);
          setTimeout(function(){
            $("#password-error").css({
              'display':'none'
            });
          },3000);  
        }else if(resp.type=="success"){
          /*alert(resp.message);*/
          $('#pageloader').hide();
          $(".loader").hide();
          $("#password-success").attr('style','color:green');
          $("#password-success").html(resp.message);
          setTimeout(function(){
            $("#password-success").css({
              'display':'none'
            });
          },3000);
        }
        
      },error:function(){
        $(".loader").hide();
        alert("Error");
      }
    })
  });

  // Save Delivery Address
    $(document).on('submit',"#addressAddEditForm",function(){
      var formdata = $("#addressAddEditForm").serialize();
      $.ajax({
        url: '/save-delivery-address',
        type:'post',
        data:formdata,
        success:function(resp){
          if(resp.type=="error"){
          $(".loader").hide();
          $.each(resp.errors,function(i,error){
            $("#delivery-"+i).attr('style','color:red');
            $("#delivery-"+i).html(error);
          setTimeout(function(){
            $("#delivery-"+i).css({
              'display':'none'
            });
          },3000);
          });
        }else{
          $('#addressAddEditForm').trigger("reset");
          $("#deliveryAddresses").html(resp.view);
          window.location.href = "checkout";  
        }
        },error:function(){
          alert("Error");
        }
      });
    })

    // Edit Delivery Address
    $(document).on('click','.editAddress',function(){
      var addressid = $(this).data("addressid");
      $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{addressid:addressid},
        url:'/get-delivery-address',
        type:'post',
        success:function(resp){
          $("#showdifferent").removeClass("collapse");
          $(".newAddress").hide();
          $(".deliveryText").text("Edit Delivery Address");
          $('[name=delivery_id]').val(resp.address['_id']);
          $('[name=delivery_name]').val(resp.address['name']);
          $('[name=delivery_address]').val(resp.address['address']);
          $('[name=delivery_city]').val(resp.address['city']);
          $('[name=delivery_state]').val(resp.address['state']);
          $('[name=delivery_country]').val(resp.address['country']);
          $('[name=delivery_pincode]').val(resp.address['pincode']);
          $('[name=delivery_mobile]').val(resp.address['mobile']);
          window.location.href = "checkout";
        },error:function(){
          alert("Error");
        }
      });
    });

    // Remove Delivery Address
    $(document).on('click','.removeAddress',function(){
      if(confirm("Are you sure to remove this?")){
        var addressid = $(this).data("addressid");
        $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url:'/remove-delivery-address',
          type:'post',
          data:{addressid:addressid},
          success:function(resp){
            $("#deliveryAddresses").html(resp.view);
            window.location.href = "checkout";    
          },error:function(){
            alert("Error");
          }
        });
      }
    });

    // Set Default Address
  $(document).on('click','.setDefaultAddress',function(){
      var addressid = $(this).data('addressid');
      $.ajax({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        data:{addressid:addressid},
        url:'/set-default-delivery-address',
        type:'post',
        success:function(resp){
          //alert(resp);
          $("#deliveryAddresses").html(resp.view);
          window.location.href = "checkout";
        },error:function(){
          alert("Error");
        }
      }); 
    
  });

});