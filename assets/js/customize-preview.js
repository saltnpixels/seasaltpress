/**
 * File customize-preview.js.
 *
 * Instantly live-update customizer settings in the preview for improved user experience.
 */


function swapImgToSvg(selector) {
    var $img = $(selector),
        imgURL = $img.attr('src'),
        imgID = $img.attr('id');

    $.get(imgURL, function (data) {
        // Get the SVG tag, ignore the rest
        var $svg = $(data).find('svg');
        // Add replaced image's ID to the new SVG
        if (typeof imgID !== 'undefined') {
            $svg = $svg.attr('id', imgID);
        }

        $svg = $svg.removeAttr('xmlns:a');
        $img.replaceWith($svg);
    }, 'xml');

};
swapImgToSvg('.custom-logo-link img');


(function ($) {

    //check if custom logo is there and hide site title if it is
    if ($('.site-top .custom-logo-link').is(':visible')) {
        $('.site-top .site-title').hide();
    }

    // Collect information from customize-controls.js about which panels are opening.

    // Site title and description.
    wp.customize( 'blogname', function( value ) {

        // If logo isn't set then bind site-title for live update.
        if ( ! parent.wp.customize( 'custom_logo' )() ) {
            value.bind( function( to ) {
                $( '.site-title a' ).text( to );
            } );
        }
    } );

    wp.customize('blogdescription', function (value) {

        value.bind(function (to) {
            $('.site-description').text(to);
        });
    });


    wp.customize('site_top_wrap', function (value) {
        value.bind(function (to) {
            $('.site-top-inner-container').removeClass('wrap');
            $('.site-top-inner-container').addClass(to);
        });
    });


    // Switch logo side by adding clas to site-top
    wp.customize('site_top_layout', function (value) {
        //console.log( value );
        value.bind(function (to) {

            $('.site-top .flex').removeClass('no-logo logo-left logo-right logo-center logo-in-middle logo-center-under');
            $('.site-top .flex').addClass(to);

            //if logo was min middle move it out on logo position change or move it in if it becomes middle
            if (to == 'logo-in-middle') {
                $(document).trigger('resize'); //triggers the resize function making me not have to repeat code
            }

            //if its not in the middle but it was. move it out
            if (to != 'logo-in-middle' && $('.li-logo-holder').length) {

                $('.site-logo').prependTo('.site-top-inner-container');
                $('.li-logo-holder').remove();
            }

        });
    });


    //site logo make svg inline
    wp.customize('custom_logo', function (value) {

        value.bind(function (to) {

            if (to != '') {
                $('.site-top .site-title').hide();
            }
            else {
                $('.site-top .site-title').show();
            }

        });

    });


    // Header text color.
    wp.customize('header_textcolor', function (value) {
        value.bind(function (to) {
            if ('blank' === to) {
                $('.site-title, .site-description').css({
                    clip: 'rect(1px, 1px, 1px, 1px)',
                    position: 'absolute'
                });
                // Add class for different logo styles if title and description are hidden.
                $('body').addClass('title-tagline-hidden');
            } else {

                // Check if the text color has been removed and use default colors in theme stylesheet.
                if (!to.length) {
                    $('#seasaltpress-custom-header-styles').remove();
                }
                $('.site-title, .site-description').css({
                    clip: 'auto',
                    position: 'relative'
                });
                $('.site-branding, .site-branding a, .site-description, .site-description a').css({
                    color: to
                });
                // Add class for different logo styles if title and description are visible.
                $('body').removeClass('title-tagline-hidden');
            }
        });
    });

    // Color scheme.
    wp.customize('colorscheme', function (value) {
        value.bind(function (to) {

            // Update color body class.
            $('body')
                .removeClass('colors-light colors-dark colors-custom')
                .addClass('colors-' + to);
        });
    });

    // Custom color hue.
    wp.customize('colorscheme_hue', function (value) {
        value.bind(function (to) {

            // Update custom color CSS.
            var style = $('#custom-theme-colors'),
                hue = style.data('hue'),
                css = style.html();

            // Equivalent to css.replaceAll, with hue followed by comma to prevent values with units from being changed.
            css = css.split(hue + ',').join(to + ',');
            style.html(css).data('hue', to);
        });
    });

    // Page layouts.
    wp.customize('page_layout', function (value) {
        value.bind(function (to) {
            if ('one-column' === to) {
                $('body').addClass('page-one-column').removeClass('page-two-column');
            } else {
                $('body').removeClass('page-one-column').addClass('page-two-column');
            }
        });
    });

    // Whether a header image is available.
    function hasHeaderImage() {
        var image = wp.customize('header_image')();
        return '' !== image && 'remove-header' !== image;
    }

    // Whether a header video is available.
    function hasHeaderVideo() {
        var externalVideo = wp.customize('external_header_video')(),
            video = wp.customize('header_video')();

        return '' !== externalVideo || ( 0 !== video && '' !== video );
    }

    // Toggle a body class if a custom header exists.
    $.each(['external_header_video', 'header_image', 'header_video'], function (index, settingId) {
        wp.customize(settingId, function (setting) {
            setting.bind(function () {
                if (hasHeaderImage()) {
                    $(document.body).addClass('has-header-image');
                } else {
                    $(document.body).removeClass('has-header-image');
                }

                if (!hasHeaderVideo()) {
                    $(document.body).removeClass('has-header-video');
                }
            });
        });
    });

})(jQuery);
