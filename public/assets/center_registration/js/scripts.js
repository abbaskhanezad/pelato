
function scroll_to_class(element_class, removed_height) {
	var scroll_to = $(element_class).offset().top - removed_height;
	if($(window).scrollTop() != scroll_to) {
		$('html, body').stop().animate({scrollTop: scroll_to}, 0);
	}
}

function bar_progress(progress_line_object, direction) {
	var number_of_steps = progress_line_object.data('number-of-steps');
	var now_value = progress_line_object.data('now-value');
	var new_value = 0;
	if(direction == 'right') {
		new_value = now_value + ( 100 / number_of_steps );
	}
	else if(direction == 'left') {
		new_value = now_value - ( 100 / number_of_steps );
	}
	progress_line_object.attr('style', 'width: ' + new_value + '%;').data('now-value', new_value);
}

jQuery(document).ready(function() {

    /*
        Fullscreen background
    */
    $.backstretch("assets/img/backgrounds/1.jpg");

    $('#top-navbar-1').on('shown.bs.collapse', function(){
    	$.backstretch("resize");
    });
    $('#top-navbar-1').on('hidden.bs.collapse', function(){
    	$.backstretch("resize");
    });

    /*
        Form
    */
    $('.f1 fieldset:first').fadeIn('slow');

    $('.f1 input[type="text"], .f1 input[type="password"], .f1 textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });

    // next step
    $('.f1 .btn-next').on('click', function() {
    	var parent_fieldset = $(this).parents('fieldset');
    	var next_step = true;
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');

    	// fields validation
        $('form[id="registration"]').validate({

            rules: {
                username: {
                    required: true,
                },
                name: {
                    required: true,
                },
                mobile: {
                    required: true,
                    number: true,
                    minlength: 11,
                    // accept: "/^09\d{9}$/",
                },
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 6,
                },
                password_confirm: {
                    required: true,
                    equalTo: "#password"
                },
                // 'user_images[]' : {
                //     required : true,
                // },
                center_name : {
                    required : true,
                },
                center_type : {
                    required : true
                },
                'center_attribute[]' : {
                    required : true
                 },
                center_address : {
                    required : true,
                },
                center_phone : {
                    minlength: 8,
                    required: true,
                    number: true,
                },
                // center_image : {
                //     required : true,
                // },
                rules : {
                    required: true,
                },
                // 'room_name[]' : {
                //     required : true,
                // },
                // 'room_size[]' : {
                //     required : true,
                //     number : true,
                //     minlength : 0
                // },
                // 'chair_count[]' : {
                //     number : true,
                //     minlength : 0,
                // },
                // 'room_price[]' : {
                //     required : true,
                //     number : true,
                //     minlength : 0,
                // },
                // 'floor_type[]' : {
                //     required : true,
                // },
                // 'room_images[]' : {
                //     required : true,
                // }
            }
            ,
            messages: {
                username: {
                    required: '<span class="badge badge-danger">  وارد کردن نام کاربری الزامیست </span>',
                },
                name: {
                    required: '<span class="badge badge-danger"> وارد کردن نام و نام خانوادگی الزامیست </span>',
                },
                mobile: {
                    required: '<span class="badge badge-danger"> وارد کردن موبایل الزامیست </span>',
                    number :  '<span class="badge badge-danger"> موبایل وارد شده صحیح نمی باشد </span>',
                    minlength: '<span class="badge badge-danger">  موبایل وارد شده صحیح نمی باشد  </span>',
                },
                email: {
                    required: '<span class="badge badge-danger"> وارد کردن ایمیل الزامیست </span>',
                    email : '<span class="badge badge-danger"> ایمیل وارد نشده صحیح نمی باشد </span>',
                },
                password: {
                    required: '<span class="badge badge-danger">  وارد کردن رمز عبور الزامیست </span>',
                    minlength: '<span class="badge badge-danger"> رمز عبور حداقل میبایست 6 حرف باشد </span>',
                },
                password_confirm: {
                    required: '<span class="badge badge-danger">  وارد کردن تایید رمز عبور الزامیست </span>',
                    equalTo:  '<span class="badge badge-danger">  عدم تطابق رمزهای عبور </span>',
                },
                'user_images[]': {
                    required: '<span class="badge badge-danger">  ارسال عکس کارت ملی و شناسنامه الزامیست </span>',
                    // accept:  '<span class="badge badge-danger">  فرمت عکس صحیح نمی باشد </span>',
                },
                center_name : {
                    required : '<span class="badge badge-danger">  وارد کردن نام مرکز الزامی است </span>',
                },
                center_type : {
                    required : '<span class="badge badge-danger"> انتخاب نوع کاربری مرکز الزامیست </span>',
                },
                'center_attribute[]' : {
                    required : '<span class="badge badge-danger"> انتخاب ویژگی برای مرکز الزامیست </span>',
                },
                center_address : {
                    required : '<span class="badge badge-danger"> وارد کردن آدرس مرکز الزامیست </span>',
                },
                center_phone: {
                    required: '<span class="badge badge-danger"> وارد کردن شماره مرکز الزامیست </span>',
                    number :  '<span class="badge badge-danger"> شماره وارد شده صحیح نمی باشد </span>',
                    minlength :  '<span class="badge badge-danger"> شماره وارد شده صحیح نمی باشد </span>',
                },
                center_image : {
                    required : '<span class="badge badge-danger"> انتخاب عکس برای مرکز الزامیست </span>',
                },
                rules : {
                    required: '<span class="badge badge-danger">  ادامه کار ملزم به قبول کردن شرایط و قوانین سایت پلاتو می باشد </span>',
                },
                // 'room_name[]' : {
                //     required :  '<span class="badge badge-danger"> وارد کردن نام اتاق الزامیست </span>',
                // },
                // 'room_size[]' : {
                //     required :  '<span class="badge badge-danger"> وارد کردن اندازه اتاق الزامیست </span>',
                //     number :  '<span class="badge badge-danger"> مقدار وارد شده صحیح نمی باشد </span>',
                //     minlength :  '<span class="badge badge-danger"> مقدار وارد شده صحیح نمی باشد </span>',
                // },
                // 'chair_count[]' : {
                //     number :  '<span class="badge badge-danger"> مقدار وارد شده صحیح نمی باشد </span>',
                //     minlength :  '<span class="badge badge-danger"> مقدار وارد شده صحیح نمی باشد </span>',
                // },
                // 'room_price[]' : {
                //     required :  '<span class="badge badge-danger"> وارد کردن هزینه اتاق الزامیست </span>',
                //     number :  '<span class="badge badge-danger"> مقدار وارد شده صحیح نمی باشد </span>',
                //     minlength :  '<span class="badge badge-danger"> مقدار وارد ش`ده صحیح نمی باشد </span>',
                // },
                // 'floor_type[]' : {
                //     required : '<span class="badge badge-danger"> وارد کردن نوع کف اتاق الزامیست </span>',
                // },
                // 'room_images[]' : {
                //     required : '<span class="badge badge-danger"> انتخاب عکس برای اتاق الزامیست </span>',
                // }
            },
        });



            if($("#registration").valid())
            {
                $(this).removeClass('input-error');
            }
            else
            {
                $(this).addClass('input-error');
                next_step = false;
            }

            if( next_step ) {
                parent_fieldset.fadeOut(400, function() {
                    // change icons
                    current_active_step.removeClass('active').addClass('activated').next().addClass('active');
                    // progress bar
                    bar_progress(progress_line, 'right');
                    // show next step
                    $(this).next().fadeIn();
                    // scroll window to beginning of the form
                    scroll_to_class( $('.f1'), 20 );
                });
            }
    	// fields validation

    });

    // previous step
    $('.f1 .btn-previous').on('click', function() {
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');

    	$(this).parents('fieldset').fadeOut(400, function() {
    		// change icons
    		current_active_step.removeClass('active').prev().removeClass('activated').addClass('active');
    		// progress bar
    		bar_progress(progress_line, 'left');
    		// show previous step
    		$(this).prev().fadeIn();
    		// scroll window to beginning of the form
			scroll_to_class( $('.f1'), 20 );
    	});
    });
});

