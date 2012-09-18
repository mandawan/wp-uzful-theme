/*
Bones Scripts File -> Uzful
Author: Eddie Machado ->  Emmanuel Baufils

*/



/***********************************************************************************************************
EventDispatcher singleton class --> for custom jQuery (or native custom events if u like) events
***********************************************************************************************************/

function EventDispatcher() {
  
  // quelques propriétés
  this.id = Math.floor(Math.random()*1000);
  if ( EventDispatcher.caller != EventDispatcher.getInstance ) {
      throw new Error("This object cannot be instanciated");
  }
}
  
// propriété statique qui contient l'instance unique
EventDispatcher.instance = null;
  
EventDispatcher.getInstance = function() {
    if (this.instance == null) {
        this.instance = new EventDispatcher();
    }
  console.log("id ED : "+this.instance.id);
  return this.instance;
}




/**********************************************************************************************************
VARIABLES AND CONSTANTS
***********************************************************************************************************/


var $mainwrapper = $('#main-wrapper'),
    scroller,
    customEvents = {
        AJAXLoadEventComplete:      'AJAXLoadEventComplete',
        AJAXLoadEventReady:         'AJAXLoadEventReady',
        imagesLoadEventComplete:    'imagesLoadEventComplete',
        contentFadeOut:             'contentFadeOut',
        contentFadeIn:              'contentFadeIn',
        contentFadeOutComplete:     'contentFadeOutComplete',
        contentFadeInComplete:      'contentFadeInComplete'
    }
    viewport = {
        width:$(window).width(),
        height:$(window).height(),
        firstResize:true
    },
    params = {
        firstLoad:true,
        firstPage:true,
        rootURL:''
    }
    $myEventDisatchObj = $(EventDispatcher.getInstance()),
    $anchorsListMenu = $('#anchors-list');
  


// as the page loads, call these scripts
jQuery(document).ready(function($) {
    //on resize
    $(window).on('resize', function()
    {
        //VIEWPORT object update
        viewport.width = $(window).width();
        viewport.height = $(window).height();
        viewport.firstResize = false;

        console.log($("resize", '.antiscroll-inner'));

        //JS scrollbar object update
        //antiscroll
        scroller.refresh();

        refreshDisplay();
    });

/*
    nice scroll set up - Antiscroll.js
    */   
    $(function () {
        $mainwrapper
        .wrap('<div id="box-antiscroll" class="box-wrap antiscroll-wrap" />')
        .wrap('<div class="box" />')
        .wrap('<div class="antiscroll-inner" />')
        .wrap('<div class="box-inner" />');

        
        $('.antiscroll-inner, .box-inner').css({'height':viewport.height, 'width':viewport.width});
        console.log("setup antiscroll", $('.antiscroll-inner'));
        scroller = $('#box-antiscroll').antiscroll().data('antiscroll');

        // $(window).resize(function() {
        //    
        // });
        
        //refresh du scroll on content ajax load
        $($myEventDisatchObj).on(customEvents.AJAXLoadEventComplete+' '+customEvents.imagesLoadEventComplete, function(o) {

          scroller.refresh();
          refreshDisplay();
          //console.log("content loaded -> refresh scrollbar");
          
        });
    });    

    var $rp = $('#right-pane');
    console.log("$rp:",$rp);

    $rp.hover(function()
    {
        console.log('mouseover!');
        var span = $(this).children('a').children('div');
        $rp.stop();
        $rp.animate({
                width:350
            }, {
                duration:300,
                easing:'linear',
                complete:function(){
                    $anchorsListMenu.children('li').children('a').show(100);       
                }   
           
         });
    },
    function()
    {
        console.log('mouseout!');
        $rp.stop();
        $anchorsListMenu.children('li').children('a').hide(100, function()
        {
            $rp.animate({
                width:13
                }, {    
                duration:300,
                easing:'swing'
                }, {
                complete:function(){
                }
            });
        });
        
    })
    //hide the lateral bar on the first load
    $rp.animate({width:13}, {duration:300});
    

    //Home item-work loading & masonry
    var hw = $('#home-works');
    var firstLoad = true;
    if(hw.length && firstLoad)
    {
        var itemW = $(hw).find('.item-work img');
        var itemWCount = itemW.length;
        var iwloadedCount = 0;
        hw.addClass('loading');
        itemW.hide().load(function(){
            iwloadedCount++;

            hw.removeClass('loading');

            
            //console.log('image work loaded', iwloadedCount);

            var target = $(this);
            console.log(target.width());
            //cosmeto wordings
            target.parent().parent().find('#work-title').css('width', target.width());
            target.parent().parent().find('#work-subtitle').css('width', target.width());
            
            target.show();

            $(hw).find('.masonry').masonry({ itemSelector: '.item-work', gutterWidth: 25, columnWidth: function( containerWidth ) { return (containerWidth-189) / 8; }});


            $myEventDisatchObj.trigger(customEvents.imagesLoadEventComplete);
            //toutes les images sont chargées, on execute masonry et on montre la section
            if(iwloadedCount === itemWCount)
            {
                //console.log('all images work loaded -> show section');
                
                
               
                firstLoad = false;
                var iwShownCount = 0;
                itemW.show(0, function()
                    {

                       iwShownCount++;
                       //console.log(iwShownCount, itemWCount);
                        if(iwShownCount === itemWCount)
                        {
                            
                            
                           
                        }
                    });


            }
        }).each(function() {
          if(this.complete) $(this).load();
        });//prevents the case when image is cached and nothing happens
        
    }


    
    //Google maps (footer)
    var $map = $('#map');
    console.log($map);
    if($map.length)
    {
        initialiserMap($map.attr('id'));
    }
    function  initialiserMap(id){
        console.log("init map");
           
        var mapOptions = {
            zoom: 16,
            center: new google.maps.LatLng(48.855034, 2.422319),
            disableDefaultUI: true,
            panControl: false,
            zoomControl: true,
            scaleControl: false,
            //styles:styles,
            MapTypeId: google.maps.MapTypeId.ROADMAP
        };
        
        
        var map = new google.maps.Map(document.getElementById(id),
            mapOptions);
        
        var markerUzful = new google.maps.Marker({clickable:false, map:map, position:new google.maps.LatLng(48.85385,2.421933), draggable:false});

    }

    
    //Button-more (load more content panel AJAX)
    var bm = $('a.button-more');
    if(bm.length)
    {
        bm.each(function(index){
            var target = $(this);
            
            //si le bouton n'est lié à aucune div "content-more" ou du genre à montrer en ajax
            if(!target.parent().find('.'+$(this).attr('rel')).length) return;
            var p = $(target.parent().find('.'+$(this).attr('rel')).find('p:first'));
            
            target.parent().find('.'+$(this).attr('rel')).css({'position':'absolute','visibility':'hidden','display':'block'});
            target.parent().find('.'+$(this).attr('rel')).data('heightTo',p.outerHeight());
            target.parent().find('.'+$(this).attr('rel')).css({'position':'static','visibility':'visible'});
        });
        bm.click(function(){
                
            var target = $(this);

            //si le bouton n'est lié à aucune div "content-more" ou du genre à montrer en ajax
            if(!target.parent().find('.'+$(this).attr('rel')).length) return;

            //initSlideMore(target.parent());
            $dta = target.parent().find('.'+$(this).attr('rel'));

            if(target.hasClass('plus'))
            {

                target.removeClass('plus');
                target.addClass('moins');

                $dta.animate(
                    {height: $dta.data('heightTo')},
                    {
                    'duration': '250px',
                    'easing': 'swing',
                });
            }
            else
            {
                target.removeClass('moins');
                target.addClass('plus');
                
                $dta.animate(
                    {height: 0},
                    {
                    'duration': '250px',
                    'easing': 'swing',
                });
                
            }         
        });
    }

    function initSlideMore(element){
        if(element.find('p'))
        {
            console.log(element.find('p').height());
            element.css('overflow', 'hidden')
            element.find('p').css('height', element.find('p').height());
            return true;
        }
        else
            return false;
    }
    //TODO : to inform about cookies
    //helper
    console.log($('#helper'));
	/*    
    $('#helper').each(function() {
        var $dialog = $(this);
        $dialog
            .dialog({
                title: $dialog.attr('data-title'),
                autoOpen: true,
                width: 500,
                height: 300,
                resizable:false,
                draggable:false
            })
    //load($dialog.attr('data-rel'));
       
        $dialog.dialog('open');
    });
	*/

    //listen to hashchange and act so..
    initNavListeners();
    //anchors nav on scrollbar
    initanchorsListMenu();
    //history left menu
    initHistory();
    


    //hash change
    $(window).hashchange( function(){
        
        //requete navigation
        navigateTo(window.location.href);
    });
    
    //détection d'un hash onload   
    if(document.location.hash.substring(3)!==''){
        console.log('hashchange on ready '+window.location.hash.substring(3));
        $(window).trigger( 'hashchange' );
    }
  


    /*
    Responsive jQuery is a tricky thing.
    There's a bunch of different ways to handle
    it so, be sure to research and find the one
    that works for you best.
    */
    
    /* getting viewport width */
    var responsive_viewport = viewport.width;
    
    /* if is below 481px */
    if (responsive_viewport < 481) {
    
    } /* end smallest screen */
    
    /* if is larger than 481px */
    if (responsive_viewport > 481) {
        
    } /* end larger than 481px */
    
    /* if is above or equal to 768px */
    if (responsive_viewport >= 768) {
    
        /* load gravatars */
        $('.comment img[data-gravatar]').each(function(){
            $(this).attr('src',$(this).attr('data-gravatar'));
        });
        
    }
    
    /* off the bat large screen actions */
    if (responsive_viewport > 1030) {
        
    }


    //OK TOUT EST FINI
    params.firstLoad = false;

    
     
}); /* end of as page load scripts */



// IE8 ployfill for GetComputed Style (for Responsive Script below)
if (!window.getComputedStyle) {
    window.getComputedStyle = function(el, pseudo) {
        this.el = el;
        this.getPropertyValue = function(prop) {
            var re = /(\-([a-z]){1})/g;
            if (prop == 'float') prop = 'styleFloat';
            if (re.test(prop)) {
                prop = prop.replace(re, function () {
                    return arguments[2].toUpperCase();
                });
            }
            return el.currentStyle[prop] ? el.currentStyle[prop] : null;
        }
        return this;
    }
}

/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT License.
*/
(function(w){
	// This fix addresses an iOS bug, so return early if the UA claims it's something else.
	if( !( /iPhone|iPad|iPod/.test( navigator.platform ) && navigator.userAgent.indexOf( "AppleWebKit" ) > -1 ) ){ return; }
    var doc = w.document;
    if( !doc.querySelector ){ return; }
    var meta = doc.querySelector( "meta[name=viewport]" ),
        initialContent = meta && meta.getAttribute( "content" ),
        disabledZoom = initialContent + ",maximum-scale=1",
        enabledZoom = initialContent + ",maximum-scale=10",
        enabled = true,
		x, y, z, aig;
    if( !meta ){ return; }
    function restoreZoom(){
        meta.setAttribute( "content", enabledZoom );
        enabled = true; }
    function disableZoom(){
        meta.setAttribute( "content", disabledZoom );
        enabled = false; }
    function checkTilt( e ){
		aig = e.accelerationIncludingGravity;
		x = Math.abs( aig.x );
		y = Math.abs( aig.y );
		z = Math.abs( aig.z );
		// If portrait orientation and in one of the danger zones
        if( !w.orientation && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) ) ){
			if( enabled ){ disableZoom(); } }
		else if( !enabled ){ restoreZoom(); } }
	w.addEventListener( "orientationchange", restoreZoom, false );
	w.addEventListener( "devicemotion", checkTilt, false );
})( this );

//MISC
function randomArrayValue(array) {
    if(array.length)
        return array[Math.floor(Math.random()*length)];
    else return 0;
}
function refreshDisplay()
{   
    $('#transition-pane').css({'left':0, 'top':0, 'margin':0});
    $('#transition-pane').height(viewport.height);    
    $('#transition-pane').width(viewport.width);    
}   