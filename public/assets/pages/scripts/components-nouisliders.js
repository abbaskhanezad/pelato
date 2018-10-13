var ComponentsNoUiSliders = function() {

    var demo8 = function() {
        var tooltipSlider = document.getElementById('demo8');

        noUiSlider.create(tooltipSlider, {
            start: [40, 50],
            connect: true,
            direction: 'rtl',
            range: {
                'min': 30,
                '30%': 40,
                'max': 50
            }
        });

        var tipHandles = tooltipSlider.getElementsByClassName('noUi-handle'),
            tooltips = [];

        // Add divs to the slider handles.
        for ( var i = 0; i < tipHandles.length; i++ ){
            tooltips[i] = document.createElement('div');
            tipHandles[i].appendChild(tooltips[i]);
        }

        // Add a class for styling
        tooltips[1].className += 'noUi-tooltip';
        // Add additional markup
        tooltips[1].innerHTML = '<strong>Value: </strong><span></span>';
        // Replace the tooltip reference with the span we just added
        tooltips[1] = tooltips[1].getElementsByTagName('span')[0];

        // Add a class for styling
        tooltips[0].className += 'noUi-tooltip';
        // Add additional markup
        tooltips[0].innerHTML = '<strong>Value: </strong><span></span>';
        // Replace the tooltip reference with the span we just added
        tooltips[0] = tooltips[0].getElementsByTagName('span')[0];

        // When the slider changes, write the value to the tooltips.
        tooltipSlider.noUiSlider.on('update', function( values, handle ){
            tooltips[handle].innerHTML = values[handle];
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            demo8();
        }

    };

}();

jQuery(document).ready(function() {
   ComponentsNoUiSliders.init();
});
