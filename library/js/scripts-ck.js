/*
Bones Scripts File -> Uzful
Author: Eddie Machado ->  Emmanuel Baufils

*//***********************************************************************************************************
EventDispatcher singleton class --> for custom jQuery (or native custom events if u like) events
***********************************************************************************************************/function EventDispatcher(){this.id=Math.floor(Math.random()*1e3);if(EventDispatcher.caller!=EventDispatcher.getInstance)throw new Error("This object cannot be instanciated")}function responsiveRoutine(){var e=viewport;console.log("responsiveRoutine",e);e.width<=768&&$("#right-navigation-container").hide();e.width<481;e.width>481;if(e.width>768){$("#right-navigation-container").show();$(".comment img[data-gravatar]").each(function(){$(this).attr("src",$(this).attr("data-gravatar"))})}e.width>1030;console.log("#right-navigation-container",$("#right-navigation-container").css("display"))}function randomArrayValue(e){return e.length?e[Math.floor(Math.random()*length)]:0}function refreshDisplay(){$("#transition-pane").css({left:0,top:0,margin:0});$("#transition-pane").height(viewport.height);$("#transition-pane").width(viewport.width)}EventDispatcher.instance=null;EventDispatcher.getInstance=function(){this.instance==null&&(this.instance=new EventDispatcher);console.log("id ED : "+this.instance.id);return this.instance};var $mainwrapper=jQuery("#main-wrapper"),scroller,customEvents={AJAXLoadEventComplete:"AJAXLoadEventComplete",AJAXLoadEventReady:"AJAXLoadEventReady",imagesLoadEventComplete:"imagesLoadEventComplete",contentFadeOut:"contentFadeOut",contentFadeIn:"contentFadeIn",contentFadeOutComplete:"contentFadeOutComplete",contentFadeInComplete:"contentFadeInComplete"};viewport={width:jQuery(window).width(),height:jQuery(window).height(),firstResize:!0},params={firstLoad:!0,firstPage:!0,rootURL:""};$myEventDisatchObj=jQuery(EventDispatcher.getInstance()),$anchorsListMenu=jQuery("#anchors-list");jQuery(document).ready(function(e){function f(e){console.log("init map");var t={zoom:16,center:new google.maps.LatLng(48.855034,2.422319),disableDefaultUI:!0,panControl:!1,zoomControl:!0,scaleControl:!1,MapTypeId:google.maps.MapTypeId.ROADMAP},n=new google.maps.Map(document.getElementById(e),t),r=new google.maps.Marker({clickable:!1,map:n,position:new google.maps.LatLng(48.85385,2.421933),draggable:!1})}function c(e){if(e.find("p")){console.log(e.find("p").height());e.css("overflow","hidden");e.find("p").css("height",e.find("p").height());return!0}return!1}e(function(){$mainwrapper.wrap('<div id="box-antiscroll" class="box-wrap antiscroll-wrap" />').wrap('<div class="box" />').wrap('<div class="antiscroll-inner" />').wrap('<div class="box-inner" />');e(".antiscroll-inner, .box-inner").css({height:viewport.height,width:viewport.width});scroller=e("#box-antiscroll").antiscroll().data("antiscroll");e($myEventDisatchObj).on(customEvents.AJAXLoadEventComplete+" "+customEvents.imagesLoadEventComplete,function(e){scroller.refresh();refreshDisplay()})});var t=e("#right-navigation-container"),n=e("#vert-scrol-bg, .antiscroll-scrollbar-vertical");console.log("$vsbg:",n);n.hover(function(){console.log("mouseover!");t.addClass("large");t.find("#right-anchor-nav-container").addClass("open");t.one("mouseleave",function(){console.log("mouseout!");t.removeClass("large");t.find("#right-anchor-nav-container").removeClass("open")})});var r=e("#home-works"),i=!0;if(r.length&&i){var s=e(r).find(".item-work img"),o=s.length,u=0;r.addClass("loading");s.hide().load(function(){u++;r.removeClass("loading");var t=e(this);t.parent().parent().find("#work-title").css("width",t.width());t.parent().parent().find("#work-subtitle").css("width",t.width());t.show();e(r).find(".masonry").masonry({itemSelector:".item-work",gutterWidth:25,columnWidth:function(e){return(e-189)/8}});$myEventDisatchObj.trigger(customEvents.imagesLoadEventComplete);if(u===o){i=!1;var n=0;s.show(0,function(){n++;n===o})}}).each(function(){this.complete&&e(this).load()})}var a=e("#map");console.log(a);a.length&&f(a.attr("id"));var l=e("a.button-more");if(l.length){l.each(function(t){var n=e(this);if(!n.parent().find("."+e(this).attr("rel")).length)return;var r=e(n.parent().find("."+e(this).attr("rel")).find("p:first"));n.parent().find("."+e(this).attr("rel")).css({position:"absolute",visibility:"hidden",display:"block"});n.parent().find("."+e(this).attr("rel")).data("heightTo",r.outerHeight());n.parent().find("."+e(this).attr("rel")).css({position:"static",visibility:"visible"})});l.click(function(){var t=e(this);if(!t.parent().find("."+e(this).attr("rel")).length)return;$dta=t.parent().find("."+e(this).attr("rel"));if(t.hasClass("plus")){t.removeClass("plus");t.addClass("moins");$dta.animate({height:$dta.data("heightTo")},{duration:"250px",easing:"swing"})}else{t.removeClass("moins");t.addClass("plus");$dta.animate({height:0},{duration:"250px",easing:"swing"})}})}console.log(e("#helper"));initNavListeners();initanchorsListMenu();initHistory();e(window).hashchange(function(){navigateTo(window.location.href)});if(document.location.hash.substring(3)!==""){console.log("hashchange on ready "+window.location.hash.substring(3));e(window).trigger("hashchange")}e(window).on("resize",function(){viewport.width=e(window).width();viewport.height=e(window).height();viewport.firstResize=!1;e(".antiscroll-inner, .box-inner").css({height:viewport.height,width:viewport.width});scroller&&scroller.refresh();refreshDisplay();responsiveRoutine()}).trigger("resize");params.firstLoad=!1});window.getComputedStyle||(window.getComputedStyle=function(e,t){this.el=e;this.getPropertyValue=function(t){var n=/(\-([a-z]){1})/g;t=="float"&&(t="styleFloat");n.test(t)&&(t=t.replace(n,function(){return arguments[2].toUpperCase()}));return e.currentStyle[t]?e.currentStyle[t]:null};return this});(function(e){function c(){n.setAttribute("content",s);o=!0}function h(){n.setAttribute("content",i);o=!1}function p(t){l=t.accelerationIncludingGravity;u=Math.abs(l.x);a=Math.abs(l.y);f=Math.abs(l.z);!e.orientation&&(u>7||(f>6&&a<8||f<8&&a>6)&&u>5)?o&&h():o||c()}if(!(/iPhone|iPad|iPod/.test(navigator.platform)&&navigator.userAgent.indexOf("AppleWebKit")>-1))return;var t=e.document;if(!t.querySelector)return;var n=t.querySelector("meta[name=viewport]"),r=n&&n.getAttribute("content"),i=r+",maximum-scale=1",s=r+",maximum-scale=10",o=!0,u,a,f,l;if(!n)return;e.addEventListener("orientationchange",c,!1);e.addEventListener("devicemotion",p,!1)})(this);