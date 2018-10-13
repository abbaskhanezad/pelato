var $star_rating1 = $('.star-rating1 .fa');

var SetRatingStar1 = function() {
    return $star_rating1.each(function() {
        if (parseInt($star_rating1.siblings('input.rating-value1').val()) >= parseInt($(this).data('rating'))) {
            return $(this).removeClass('fa-star-o').addClass('fa-star check');
        } else {
            return $(this).removeClass('fa-star').addClass('fa-star-o');
        }
    });
};

$star_rating1.on('click', function() {
    $star_rating1.siblings('input.rating-value1').val($(this).data('rating'));
    return SetRatingStar1();
});

var $star_rating2 = $('.star-rating2 .fa');

var SetRatingStar2 = function() {
    return $star_rating2.each(function() {
        if (parseInt($star_rating2.siblings('input.rating-value2').val()) >= parseInt($(this).data('rating'))) {
            return $(this).removeClass('fa-star-o').addClass('fa-star check');
        } else {
            return $(this).removeClass('fa-star').addClass('fa-star-o');
        }
    });
};

$star_rating2.on('click', function() {
    $star_rating2.siblings('input.rating-value2').val($(this).data('rating'));
    return SetRatingStar2();
});

var $star_rating3 = $('.star-rating3 .fa');

var SetRatingStar3 = function() {
    return $star_rating3.each(function() {
        if (parseInt($star_rating3.siblings('input.rating-value3').val()) >= parseInt($(this).data('rating'))) {
            return $(this).removeClass('fa-star-o').addClass('fa-star check');
        } else {
            return $(this).removeClass('fa-star').addClass('fa-star-o');
        }
    });
};

$star_rating3.on('click', function() {
    $star_rating3.siblings('input.rating-value3').val($(this).data('rating'));
    return SetRatingStar3();
});




SetRatingStar1();
SetRatingStar2();
SetRatingStar3();
$(document).ready(function() {

});