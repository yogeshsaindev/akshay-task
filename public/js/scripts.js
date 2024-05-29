/**
 * Custom Javascript and Jquery
 */

$(document).ready(function (){

    /**
     * Stop form submit and reload the page
     */

    $('body').on('submit' , 'form' , function($e){
        $e.preventDefault();
    });

    /**
     * Create User By Using Ajax and Apply Validations 
     */

    $('body').on('click' , '.createUser' , function(){
        var form = $(this).closest('form'),
        t = $(this),
        error = validateForm(form);
        console.log("Error" , error);
        
        if( error == true ){
            return false;
        }

        t.attr({'disabled':'disabled'}).find('.fa').removeClass('d-none');

        $.ajax({
            url:form.attr('action'),
            type:"POST",
            data:new FormData(form[0]),
            dataType:'json',
            success:function(res){
                t.removeAttr('disabled').find('.fa').addClass('d-none');;
                handleSuccess( res , form );
            },
            error:function(error){
                t.removeAttr('disabled').find('.fa').addClass('d-none');;
                handleError( error , form );
            },
            processData:false,
            cache:false,
            contentType:false,

        });
    });

     /**
      * Trigger Event for remvoing validation error message or border
      */
     $('body').on('keyup , change','input,select,textarea',function(){
        removeValidation(this);
    });

    /**
     * Apply Email Validation on Keyup
     */
    $('body').on('keyup', 'input[type="email"]', function () { 
        var t = $(this),email = $.trim(t.val()),e = t.closest('.form-group');
        if (email != '') {
            var result = IsEmail(email);
            if (result == false) {
              t.addClass('error');
              t.focus();
              t.next('.error-message').remove();
              t.after('<div class="error-message">Please enter valid email</div>');
              return false;
            } else {
              t.removeClass('error');
            }
        }else {
            t.removeClass('error');
        }
    });

    /**
     * Ignore White Space in Inputs
     */

    $('body').on('input','input,textarea', function() {
        var inputVal = $(this).val();
        // Remove leading spaces
        var trimmedVal = inputVal.replace(/^\s+/, '');
        $(this).val(trimmedVal);
    });

    /**
     * Check Validation for Indian Phone Number
     */

    $('body').on('keyup','#phone', function() {
        var t = $(this),
        phoneNumber = t.val(),
        phonePattern = /^\+91[6-9]\d{9}$/;

        t.nextAll('.error-message').remove();
        if (!phonePattern.test(phoneNumber)) {
            t.after(`<div class="error-message">Enter valid phone using dial code +91</div>`);
            return false;
        }    
    });

    

});

/**
 * Validate Form
 */

function validateForm(form){
    var error = 0;
    form.find( 'input,select,textarea' ).each(function(i){
        var t = $(this),req = t.attr('required'),value = $.trim(t.val());
        if( req != undefined ){
            if( value == '' ){
                var name = t.attr('name');
                t.nextAll('.error-message').remove();
                t.addClass('error').after(`<div class="error-message">This ${name} filed is required</div>`);
                if( i == 0 ){
                    t.focus();
                }
                error++;
            }else{
                t.removeClass('error');
            }
        }
        
    });
    if( error > 0 ){
        return true;
    }
    return false;

}


/**
 * Remove Error Message or border
 */

function removeValidation(t){
    var t = $(t);
    if( t.attr('required') != undefined || t.attr('req') != undefined ){
        value = $.trim(t.val()); 
        if( value == '' ){
            t.addClass('error');
        }else{
            t.removeClass('error').nextAll('.error-message').remove();
            t.closest('.form-group').find('.message').html('');
        }
    }
}

function handleSuccess( res , form ){
    console.log('Form Response',res);
    if( res.status ){
        if( res.message ) {
           
        $("#successMessage").html(res.message);
           $("#user-list").find('tbody').html(res.users);  
           
           form[0].reset();

           $(".total_records").html(res.total_records);
           
           setTimeout(function(){
            $("#successMessage").html('');
           },3000);
        }    
    }
}

// Handle Ajax Error Response
function handleError( error , form ){
   
   
    if( error && error.status == 422 ){
        errors = JSON.parse(error.responseText);
        if( errors.errors ){
            console.log("All errors" , errors.errors);
            $.each( errors.errors , function(key , values){
                el = form.find("[name="+key+"]");
                el.nextAll('.error-message').remove();
                $.each(values , function($k , $v){
                    el.after(`<div class="error-message">${$v}</div>`);
                }) 
            });
        }
        return false;
    }


    if( error && error.status == 500 ){
        resJ = JSON.parse(error.responseText);
        console.log("500 Error" , resJ);
        $("#errorMessage").html(resJ.errors);
        setTimeout(function(){
            $("#errorMessage").html('');
        },5000);
       
    }
}

/**
 * Check Valid Email
 */

function IsEmail(email) { 
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
      return false;
    } else {
      return true;
    }
}