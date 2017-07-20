jQuery(function ($) {

    var $body = $('body');


    //console.log(seasaltpressScreenReaderText);

    /**
     * Test if an iOS device.
     */
    function checkiOS() {
        return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    }

    function checkIEedge() {
        // detect IE8 and above, and edge
        return (document.documentMode || /Edge/.test(navigator.userAgent));
    }

    if (checkiOS()) {
        $('body').addClass('ios');
    }

    if (checkIEedge()) {
        var $headerImage = $('.header-image');

        if ($headerImage.css('object-fit') === 'cover') {
            $headerImage.parent().css({
                "background-image": "url(" + $headerImage.attr('src') + ")"
            });
            $headerImage.hide();
        }
    }


});