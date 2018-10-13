$('#changePointToWallet').click(function(event){
    event.preventDefault();
    $('#formCountPoint').slideToggle();
});


$("input#countPoint").on('keyup', function (event) {
    event.preventDefault();
    var valInput = $(this).val();

    $.ajax({
        url: '/users/points/calculator',
        type: 'get',
        dataType: 'json',
        data: {
            valInput: valInput
        },
        success: function (response) {
             $("#pricePoints").html(response + 'تومان');
             $("#pricePoints").show();
        }

    });
});