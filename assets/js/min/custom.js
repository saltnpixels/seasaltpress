'use strict';

jQuery(function ($) {

    var $body = $('body');

    //console.log(seasaltpressScreenReaderText);

    /**
     * Test if an iOS device.
     */
    function checkiOS() {
        return (/iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream
        );
    }

    function checkIEedge() {
        // detect IE8 and above, and edge
        return document.documentMode || /Edge/.test(navigator.userAgent);
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
'use strict';

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/*!
 * jQuery.scrollTo
 * Copyright (c) 2007-2015 Ariel Flesler - aflesler<a>gmail<d>com | http://flesler.blogspot.com
 * Licensed under MIT
 * http://flesler.blogspot.com/2007/10/jqueryscrollto.html
 * @projectDescription Lightweight, cross-browser and highly customizable animated scrolling with jQuery
 * @author Ariel Flesler
 * @version 2.1.2
 */
;(function (factory) {
    'use strict';

    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery'], factory);
    } else if (typeof module !== 'undefined' && module.exports) {
        // CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Global
        factory(jQuery);
    }
})(function ($) {
    'use strict';

    var $scrollTo = $.scrollTo = function (target, duration, settings) {
        return $(window).scrollTo(target, duration, settings);
    };

    $scrollTo.defaults = {
        axis: 'xy',
        duration: 0,
        limit: true
    };

    function isWin(elem) {
        return !elem.nodeName || $.inArray(elem.nodeName.toLowerCase(), ['iframe', '#document', 'html', 'body']) !== -1;
    }

    $.fn.scrollTo = function (target, duration, settings) {
        if ((typeof duration === 'undefined' ? 'undefined' : _typeof(duration)) === 'object') {
            settings = duration;
            duration = 0;
        }
        if (typeof settings === 'function') {
            settings = { onAfter: settings };
        }
        if (target === 'max') {
            target = 9e9;
        }

        settings = $.extend({}, $scrollTo.defaults, settings);
        // Speed is still recognized for backwards compatibility
        duration = duration || settings.duration;
        // Make sure the settings are given right
        var queue = settings.queue && settings.axis.length > 1;
        if (queue) {
            // Let's keep the overall duration
            duration /= 2;
        }
        settings.offset = both(settings.offset);
        settings.over = both(settings.over);

        return this.each(function () {
            // Null target yields nothing, just like jQuery does
            if (target === null) {
                return;
            }

            var win = isWin(this),
                elem = win ? this.contentWindow || window : this,
                $elem = $(elem),
                targ = target,
                attr = {},
                toff;

            switch (typeof targ === 'undefined' ? 'undefined' : _typeof(targ)) {
                // A number will pass the regex
                case 'number':
                case 'string':
                    if (/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(targ)) {
                        targ = both(targ);
                        // We are done
                        break;
                    }
                    // Relative/Absolute selector
                    targ = win ? $(targ) : $(targ, elem);
                /* falls through */
                case 'object':
                    if (targ.length === 0) {
                        return;
                    }
                    // DOMElement / jQuery
                    if (targ.is || targ.style) {
                        // Get the real position of the target
                        toff = (targ = $(targ)).offset();
                    }
            }

            var offset = $.isFunction(settings.offset) && settings.offset(elem, targ) || settings.offset;

            $.each(settings.axis.split(''), function (i, axis) {
                var Pos = axis === 'x' ? 'Left' : 'Top',
                    pos = Pos.toLowerCase(),
                    key = 'scroll' + Pos,
                    prev = $elem[key](),
                    max = $scrollTo.max(elem, axis);

                if (toff) {
                    // jQuery / DOMElement
                    attr[key] = toff[pos] + (win ? 0 : prev - $elem.offset()[pos]);

                    // If it's a dom element, reduce the margin
                    if (settings.margin) {
                        attr[key] -= parseInt(targ.css('margin' + Pos), 10) || 0;
                        attr[key] -= parseInt(targ.css('border' + Pos + 'Width'), 10) || 0;
                    }

                    attr[key] += offset[pos] || 0;

                    if (settings.over[pos]) {
                        // Scroll to a fraction of its width/height
                        attr[key] += targ[axis === 'x' ? 'width' : 'height']() * settings.over[pos];
                    }
                } else {
                    var val = targ[pos];
                    // Handle percentage values
                    attr[key] = val.slice && val.slice(-1) === '%' ? parseFloat(val) / 100 * max : val;
                }

                // Number or 'number'
                if (settings.limit && /^\d+$/.test(attr[key])) {
                    // Check the limits
                    attr[key] = attr[key] <= 0 ? 0 : Math.min(attr[key], max);
                }

                // Don't waste time animating, if there's no need.
                if (!i && settings.axis.length > 1) {
                    if (prev === attr[key]) {
                        // No animation needed
                        attr = {};
                    } else if (queue) {
                        // Intermediate animation
                        animate(settings.onAfterFirst);
                        // Don't animate this axis again in the next iteration.
                        attr = {};
                    }
                }
            });

            animate(settings.onAfter);

            function animate(callback) {
                var opts = $.extend({}, settings, {
                    // The queue setting conflicts with animate()
                    // Force it to always be true
                    queue: true,
                    duration: duration,
                    complete: callback && function () {
                        callback.call(elem, targ, settings);
                    }
                });
                $elem.animate(attr, opts);
            }
        });
    };

    // Max scrolling position, works on quirks mode
    // It only fails (not too badly) on IE, quirks mode.
    $scrollTo.max = function (elem, axis) {
        var Dim = axis === 'x' ? 'Width' : 'Height',
            scroll = 'scroll' + Dim;

        if (!isWin(elem)) {
            return elem[scroll] - $(elem)[Dim.toLowerCase()]();
        }

        var size = 'client' + Dim,
            doc = elem.ownerDocument || elem.document,
            html = doc.documentElement,
            body = doc.body;

        return Math.max(html[scroll], body[scroll]) - Math.min(html[size], body[size]);
    };

    function both(val) {
        return $.isFunction(val) || $.isPlainObject(val) ? val : { top: val, left: val };
    }

    // Add special hooks so that window scroll properties can be animated
    $.Tween.propHooks.scrollLeft = $.Tween.propHooks.scrollTop = {
        get: function get(t) {
            return $(t.elem)[t.prop]();
        },
        set: function set(t) {
            var curr = this.get(t);
            // If interrupt is true and user scrolled, stop animating
            if (t.options.interrupt && t._last && t._last !== curr) {
                return $(t.elem).stop();
            }
            var next = Math.round(t.now);
            // Don't waste CPU
            // Browsers don't render floating point scroll
            if (curr !== next) {
                $(t.elem)[t.prop](next);
                t._last = this.get(t);
            }
        }
    };

    // AMD requirement
    return $scrollTo;
});
'use strict';

/* global seasaltpressScreenReaderText */
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

(function ($) {
    var page, menuToggle, siteNavContain, siteNavigation, $body, $mobileMenuWidth, $sidebarWidth;

    $mobileMenuWidth = 600; //change to match your scss variable for mobile menu media query
    $sidebarWidth = 800; //change to match sidebar mobile width media query

    function initMainNavigation(container) {

        // Add dropdown toggle that displays child menu items. Used on mobile and screenreaders.
        var dropdownToggle = $('<button />', { 'class': 'dropdown-toggle', 'aria-expanded': false }).append(seasaltpressScreenReaderText.icon).append($('<span />', { 'class': 'screen-reader-text', text: seasaltpressScreenReaderText.expand }));

        container.find('.menu-item-has-children > a, .page_item_has_children > a').after(dropdownToggle);

        // Set the active submenu dropdown toggle button initial state.
        container.find('.current-menu-ancestor > button, .current-menu-parent').addClass('toggled-on').attr('aria-expanded', 'true').find('.screen-reader-text').text(seasaltpressScreenReaderText.collapse);
        // Set the active submenu initial state.
        container.find('.current-menu-ancestor > .sub-menu').addClass('toggled-on').slideDown(); //added slidedown


        container.find('.dropdown-toggle').click(function (e) {
            var _this = $(this),
                screenReaderSpan = _this.find('.screen-reader-text');

            e.preventDefault();
            _this.toggleClass('toggled-on');
            _this.closest('li').toggleClass('toggled-on'); //added for styling the item clicked
            _this.closest('li').children('.children, .sub-menu').toggleClass('toggled-on').slideToggle();

            _this.attr('aria-expanded', _this.attr('aria-expanded') === 'false' ? 'true' : 'false');

            screenReaderSpan.text(screenReaderSpan.text() === seasaltpressScreenReaderText.expand ? seasaltpressScreenReaderText.collapse : seasaltpressScreenReaderText.expand);
        });
    }

    initMainNavigation($('.main-navigation'));
    initMainNavigation($('.widget-area')); //added for widgets

    //cool menu addition
    $body = $(document.body);
    page = $('#page');
    menuToggle = page.find('.menu-toggle');
    siteNavContain = page.find('.mobile-popout');
    siteNavigation = page.find('.main-navigation > div > ul');

    // Enable menuToggle.
    (function () {

        // Return early if menuToggle is missing.
        if (!menuToggle.length) {
            return;
        }

        // Add an initial value for the attribute.
        menuToggle.attr('aria-expanded', 'false');

        //menu opens. click event

        menuToggle.on('click.seasaltpress', function (e) {
            siteNavContain.toggleClass('toggled-on');
            menuToggle.attr('aria-expanded', siteNavContain.hasClass('toggled-on')).toggleClass('toggled-on');

            //cool menu work takes over to make sure things are done in transition order
            if ($body.hasClass('cool-menu')) {

                toggleCoolMenu();
            } else {

                $('.site-top').toggleClass('toggled-on');
                //regular menu, close menu if they click on the page
                if (menuToggle.hasClass('toggled-on')) {
                    //button becomes fixed so make sure its height is no longer 100%
                    menuToggle.css('height', $('.site-top').height());
                    $('.site-content').one('click.seasaltpress', function () {
                        menuToggle.trigger('click'); //recursively calls togglecoolmenu
                    });
                } else {
                    menuToggle.css('height', '100%');
                    $('.site-content').off('.seasaltpress');
                }
            }
        });
    })();

    // Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
    (function () {
        if (!siteNavigation.length || !siteNavigation.children().length) {
            return;
        }

        // Toggle `focus` class to allow submenu access on tablets.
        function toggleFocusClassTouchScreen() {
            if ('none' === $('.menu-toggle').css('display')) {

                $(document.body).on('touchstart.seasaltpress', function (e) {
                    if (!$(e.target).closest('.main-navigation li').length) {
                        $('.main-navigation li').removeClass('focus');
                    }
                });

                siteNavigation.find('.menu-item-has-children > a, .page_item_has_children > a').on('touchstart.seasaltpress', function (e) {
                    var el = $(this).parent('li');

                    if (!el.hasClass('focus')) {
                        e.preventDefault();
                        el.toggleClass('focus');
                        el.siblings('.focus').removeClass('focus');
                    }
                });
            } else {
                siteNavigation.find('.menu-item-has-children > a, .page_item_has_children > a').unbind('touchstart.seasaltpress');
            }
        }

        if ('ontouchstart' in window) {
            $(window).on('resize.seasaltpress', toggleFocusClassTouchScreen);
            toggleFocusClassTouchScreen();
        }

        siteNavigation.find('a').on('focus.seasaltpress blur.seasaltpress', function () {
            $(this).parents('.menu-item, .page_item').toggleClass('focus');
        });
    })();

    /*--------------------------------------------------------------
     # Cool Menu addition
     --------------------------------------------------------------*/
    function toggleCoolMenu() {

        if (menuToggle.hasClass('toggled-on')) {
            $($body).addClass('menu-lock'); //somewhat locks on ios... can use return false if needed...

            //wrap the inner of #page and transition that with css. This way we dont have to animate #page,
            //#page keeps overflow hidden so on ios you cant scroll all over. This was needed.
            page.wrapInner("<div class='page-holder' />");

            //toggle the transitions and click action one AFTER the wrap is made
            setTimeout(function () {
                page.addClass('mobile-menu-open');
                siteNavContain.addClass('open'); //shows the menu removes hidden

                $('.page-holder').one('click', function (e) {

                    if (!$(e.target).closest('.menu-toggle').length) {
                        menuToggle.trigger('click'); //recursively calls togglecoolmenu to close
                    }
                });

                //close menu if they click on the page holder
            }, 100);
        }
        //closing menu and unwrapping pageholder
        if (!menuToggle.hasClass('toggled-on')) {
            page.removeClass('mobile-menu-open'); //closes menu by removing this class and putting page holder back in place.
            $body.removeClass('menu-lock');

            $('.page-holder').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
                siteNavContain.removeClass('open'); //only remove toggle and hide menu once page holder finishes its transition to cover it.
                $('.page-holder').children().unwrap('.page-holder');
            });
        }
    } //end cool-menu


    /*--------------------------------------------------------------
     # Resize for cool menu and logo in middle of menu
     --------------------------------------------------------------*/
    //this code runs on resize and moves the cool menu into place. It also is responsible for a logo in middle of menu if thats as chosen in customizer
    var mainNavigationLi = $('.main-navigation ul.menu>li, .main-navigation .menu>ul>li');

    function resizeMobileMenu() {

        if ($(window).width() < $mobileMenuWidth) {
            //if the body doesn't have the mobile popout already, put it there.
            if (!$('body>.mobile-popout').length && $body.hasClass('cool-menu')) {
                $(siteNavContain.prependTo($body));
            }

            //if middle logo, take it out and put it like it would be a left logo on mobile.
            if ($('.li-logo-holder').length) {
                $('.site-logo').prependTo('.site-top-inner-container');
                $('.li-logo-holder').remove();
            }
        }
        //else its desktop
        else {
                siteNavigation.find('.sub-menu').attr('style', ''); //may have hidden from dropdown mobile version if sub menu was closed

                if ($('body>.mobile-popout').length && $body.hasClass('cool-menu')) {
                    $(siteNavContain.appendTo('.site-top-inner-container'));

                    //close menu and unwrap page
                    if (menuToggle.hasClass('toggled-on')) {
                        $('.page-holder').trigger('click'); //turns this off and closes everything in one fell swoop
                        siteNavContain.toggleClass('open'); //only remove toggle on and hide menu once page holder finishes its transition to cover it.
                        $('.page-holder').children().unwrap('.page-holder');
                    }
                }

                //move logo in middle of menu on desktop if logo is middle position
                if ($('.logo-in-middle').length && $(window).width() > $mobileMenuWidth && !$('.li-logo-holder').length) {

                    var middle = Math.floor($(mainNavigationLi).length / 2) - 1;
                    $('<li class="menu-item li-logo-holder"></li>').insertAfter(mainNavigationLi.filter(':eq(' + middle + ')')).prepend($('.site-logo'));
                    //check if custom logo is there and hide site title if it is
                    if ($('.site-top .custom-logo-link').is(':visible')) {
                        $('.site-top .site-title').hide();
                    }
                }
            }
    }

    $(window).on('load resize', resizeMobileMenu); //run on load and resize


    //swipe right to open menu too
    page.on('swiperight', function (e) {
        if (e.swipestart.coords[0] < 30 && !siteNavContain.hasClass('toggled-on')) {
            menuToggle.trigger('click');
        }
    });

    //swipe right to open menu too
    page.on('swipeleft', function (e) {
        var $windowWidth = $(window).width() - 30;

        if (e.swipestart.coords[0] > $windowWidth && !$body.hasClass('sidebar-open')) {
            $('.sidebar-toggle').trigger('click');
        }
    });

    /*------- Sidebar Button Stuff --------*/

    //add toggle button. Hidden via css on desktop if not using cool sidebar.
    var $checksidebar = $('.js #secondary');
    if ($checksidebar.length) {
        $('#page').append('<button aria-expanded="false" class="sidebar-toggle" style="height: ' + $('.site-top').height() + 'px;">' + seasaltpressScreenReaderText.sidebar_icon + '</div>');

        $body.addClass('sidebar-active');

        $('.sidebar-toggle').on('click', function () {
            $body.toggleClass('sidebar-open');
            $('#secondary').toggleClass('sidebar-open');
            $(this).toggleClass('sidebar-open').attr('aria-expanded', $(this).hasClass('sidebar-open'));
        });

        //swipe left to open sidebar
        page.on('swipeleft', function (e) {
            //make sure swipe starts within 30 pixels from left edge
            var $windowWidth = $(window).width() - 30;

            if (e.swipestart.coords[0] > $windowWidth && !$body.hasClass('sidebar-open')) {
                $('.sidebar-toggle').trigger('click');
            }
        });

        //swipe right to close
        $('#secondary').on('swiperight', function (e) {
            var $windowWidth = $(window).width() - $sidebarWidth;

            var $swipeSize = e.swipestop.coords[0] - e.swipestart.coords[0];

            if (e.swipestart.coords[0] > $windowWidth && $body.hasClass('sidebar-open') && $swipeSize > 20) {
                $('.sidebar-toggle').trigger('click');
            }
        });
    }

    /*------- Inline Sidebar Placement. --------*/
    //make regular sidebar inline. Remove if you dont want it to be inline but under site-top
    var $coolSidebar = $('.js .cool-sidebar #secondary');
    if (!$coolSidebar.length && $checksidebar.length) {
        //if not cool sidebar, but there is a sidebar

        $(window).on('resize', function () {

            if ($(window).width() < $sidebarWidth && $('.content-sidebar-holder').length) {
                $('.content-sidebar-holder').children().unwrap($('.content-sidebar-holder'));
                $('.site-content').append($('#secondary'));
            }
            if ($(window).width() > $sidebarWidth && !$('.content-sidebar-holder').length) {

                $('.page .entry-content, .single .entry-content, .archive .posts-holder, .blog .posts-holder').wrap('<div class="wrap content-sidebar-holder"></div>');
                $('.content-sidebar-holder').append($('#secondary'));
            }
        }).resize();
    }
})(jQuery);
'use strict';

/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
(function () {
    var isIe = /(trident|msie)/i.test(navigator.userAgent);

    if (isIe && document.getElementById && window.addEventListener) {
        window.addEventListener('hashchange', function () {
            var id = location.hash.substring(1),
                element;

            if (!/^[A-z0-9_-]+$/.test(id)) {
                return;
            }

            element = document.getElementById(id);

            if (element) {
                if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
                    element.tabIndex = -1;
                }

                element.focus();
            }
        }, false);
    }
})();