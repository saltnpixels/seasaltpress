!function($){function e(e){var s=$("<button />",{class:"dropdown-toggle","aria-expanded":!1}).append(seasaltpressScreenReaderText.icon).append($("<span />",{class:"screen-reader-text",text:seasaltpressScreenReaderText.expand}));e.find(".menu-item-has-children > a, .page_item_has_children > a").append(s),e.find(".current-menu-ancestor > button, .current-menu-parent").addClass("toggled-on").attr("aria-expanded","true").find(".screen-reader-text").text(seasaltpressScreenReaderText.collapse),e.find(".current-menu-ancestor > .sub-menu").addClass("toggled-on").slideDown(),e.find(".dropdown-toggle").click(function(e){var s=$(this),n=s.find(".screen-reader-text");e.preventDefault(),s.toggleClass("toggled-on"),s.closest("li").toggleClass("toggled-on"),s.closest("li").children(".children, .sub-menu").toggleClass("toggled-on").slideToggle(),s.attr("aria-expanded","false"===s.attr("aria-expanded")?"true":"false"),n.text(n.text()===seasaltpressScreenReaderText.expand?seasaltpressScreenReaderText.collapse:seasaltpressScreenReaderText.expand)})}function s(){o.hasClass("toggled-on")&&($(l).addClass("menu-lock"),t.wrapInner("<div class='page-holder' />"),setTimeout(function(){t.addClass("mobile-menu-open"),a.addClass("open"),$(".page-holder").one("click",function(e){$(e.target).closest(".menu-toggle").length||o.trigger("click")})},100)),o.hasClass("toggled-on")||(t.removeClass("mobile-menu-open"),l.removeClass("menu-lock"),$(".page-holder").one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend",function(){a.removeClass("open"),$(".page-holder").children().unwrap(".page-holder")}))}function n(){if($(window).width()<r)!$("body>.mobile-popout").length&&l.hasClass("cool-menu")&&$(a.prependTo(l)),$(".li-logo-holder").length&&($(".site-logo").prependTo(".site-top-inner-container"),$(".li-logo-holder").remove());else if($("body>.mobile-popout").length&&l.hasClass("cool-menu")&&($(a.appendTo(".site-top-inner-container")),o.hasClass("toggled-on")&&($(".page-holder").trigger("click"),a.toggleClass("open"),$(".page-holder").children().unwrap(".page-holder"))),$(".logo-in-middle").length&&$(window).width()>r&&!$(".li-logo-holder").length){var e=Math.floor($(g).length/2)-1;$('<li class="menu-item li-logo-holder"></li>').insertAfter(g.filter(":eq("+e+")")).prepend($(".site-logo")),$(".site-top .custom-logo-link").is(":visible")&&$(".site-top .site-title").hide()}}var t,o,a,i,l,r,d;r=600,d=800,e($(".main-navigation")),e($(".widget-area")),l=$(document.body),t=$("#page"),o=t.find(".menu-toggle"),a=t.find(".mobile-popout"),i=t.find(".main-navigation > div > ul"),function(){o.length&&(o.attr("aria-expanded","false"),o.on("click.seasaltpress",function(){a.toggleClass("toggled-on"),o.attr("aria-expanded",a.hasClass("toggled-on")).toggleClass("toggled-on"),l.hasClass("cool-menu")?s():($(".site-top").toggleClass("toggled-on"),o.hasClass("toggled-on")?(o.css("height",$(".site-top").height()),$(".site-content").one("click",function(){o.trigger("click")})):o.css("height","100%"))}))}(),function(){function e(){"none"===$(".menu-toggle").css("display")?($(document.body).on("touchstart.seasaltpress",function(e){$(e.target).closest(".main-navigation li").length||$(".main-navigation li").removeClass("focus")}),i.find(".menu-item-has-children > a, .page_item_has_children > a").on("touchstart.seasaltpress",function(e){var s=$(this).parent("li");s.hasClass("focus")||(e.preventDefault(),s.toggleClass("focus"),s.siblings(".focus").removeClass("focus"))})):i.find(".menu-item-has-children > a, .page_item_has_children > a").unbind("touchstart.seasaltpress")}i.length&&i.children().length&&("ontouchstart"in window&&($(window).on("resize.seasaltpress",e),e()),i.find("a").on("focus.seasaltpress blur.seasaltpress",function(){$(this).parents(".menu-item, .page_item").toggleClass("focus")}))}();var g=$(".main-navigation ul.menu>li, .main-navigation .menu>ul>li");$(window).on("load resize",n),t.on("swiperight",function(e){e.swipestart.coords[0]<30&&!a.hasClass("toggled-on")&&o.trigger("click")}),t.on("swipeleft",function(e){var s=$(window).width()-30;e.swipestart.coords[0]>s&&!l.hasClass("sidebar-open")&&$(".sidebar-toggle").trigger("click")});var c=$(".js #secondary");c.length&&($("#page").append('<button aria-expanded="false" class="sidebar-toggle" style="height: '+$(".site-top").height()+'px;">'+seasaltpressScreenReaderText.sidebar_icon+"</div>"),l.addClass("sidebar-active"),$(".sidebar-toggle").on("click",function(){l.toggleClass("sidebar-open"),$("#secondary").toggleClass("sidebar-open"),$(this).toggleClass("sidebar-open").attr("aria-expanded",$(this).hasClass("sidebar-open"))}),t.on("swipeleft",function(e){var s=$(window).width()-30;e.swipestart.coords[0]>s&&!l.hasClass("sidebar-open")&&$(".sidebar-toggle").trigger("click")}),$("#secondary").on("swiperight",function(e){var s=$(window).width()-d,n=e.swipestop.coords[0]-e.swipestart.coords[0];e.swipestart.coords[0]>s&&l.hasClass("sidebar-open")&&n>20&&$(".sidebar-toggle").trigger("click")})),!$(".js .cool-sidebar #secondary").length&&c.length&&$(window).on("resize",function(){$(window).width()<d&&$(".content-sidebar-holder").length&&($(".content-sidebar-holder").children().unwrap($(".content-sidebar-holder")),$(".site-content").append($("#secondary"))),$(window).width()>d&&!$(".content-sidebar-holder").length&&($(".page .entry-content, .single .entry-content, .archive .posts-holder, .blog .posts-holder").wrap('<div class="wrap content-sidebar-holder"></div>'),$(".content-sidebar-holder").append($("#secondary")))}).resize()}(jQuery);