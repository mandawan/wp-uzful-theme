function initanchorsListMenu(){console.log("initanchorsListMenu");console.log("--------------->",$(".antiscroll-inner"));console.log($(".antiscroll-inner"));$(".antiscroll-inner").length&&($.fn.waypoint.defaults.context=$(".antiscroll-inner"));$.fn.waypoint.defaults.onlyOnScroll=!0;$.fn.waypoint.defaults.continuous=!0;$($myEventDisatchObj).on(customEvents.newContentDisplayed,$.waypoints("refresh"));constructanchorsListMenu()}function constructanchorsListMenu(e){$anchors&&$anchors.length&&$anchors.unbind("waypoint.reached",anchorReached);$("#content:first #inner-content:first #main:first a.anchor");$anchors=$("#content:first #inner-content:first #main:first a.anchor");if($anchors&&$anchors.length){$anchors.waypoint(function(e,t){t&&console.log(t);$anchors.each(function(){$(this).data("button")&&$(this).data("button").hasClass("selected")&&$(this).data("button").removeClass("selected")});$(this).data("button")&&$(e.target).data("button").addClass("selected")},{offset:200});$anchorsListMenu.html("");$anchors.each(function(){var e=$(this),t='<li id="anchor-to-'+e.attr("id")+'" class="anchor-link" name="'+e.attr("name")+'"><a title="'+e.attr("data-title")+'" subtitle="'+e.attr("data-sub")+'" href="#'+e.attr("name")+'"><span class="a-title">'+e.attr("data-title").toString()+'</span><span class="a-sub">'+e.attr("data-sub").toString()+"</span></a></li>";$anchorsListMenu.append(t);var n=$anchorsListMenu.children("#anchor-to-"+e.attr("id"));n.data("target",e);e.data("button",n);$anchorsListMenu.children("li").css("height",100/$anchors.length+"%")});$.waypoints("refresh")}$anchors=$("#content:first #inner-content:first #main:first a.anchor-to-ajax");if($anchors&&$anchors.length){$anchors.waypoint(function(e,t){t&&console.log(t);$anchors.each(function(){$(this).data("button")&&$(this).data("button").hasClass("selected")&&$(this).data("button").removeClass("selected")});$(this).data("button")&&$(e.target).data("button").addClass("selected")},{offset:function(){return-10}});$anchorsListMenu.html("");$anchors.each(function(){var e=$(this),t='<li id="ajax-link-to-'+e.attr("id")+'" class="anchor-link" onClick="clickNavigate(this)" name="'+e.attr("name")+'"><a title="'+e.attr("data-title")+'" subtitle="'+e.attr("data-sub")+'"><span class="a-title">'+e.attr("data-title").toString()+'</span><span class="a-sub">'+e.attr("data-sub").toString()+"</span></a></li>";$anchorsListMenu.append(t);var n=$anchorsListMenu.children("#ajax-link-to-"+e.attr("id"));n.data("target",e);e.data("button",n);$anchorsListMenu.children("li").css("height",100/$anchors.length+"%")});$.waypoints("refresh")}}function anchorReached(e,t){console.log(e,t)}function initNavListeners(){$myEventDisatchObj.on(customEvents.AJAXLoadEventReady,transFadeIn);$myEventDisatchObj.on(customEvents.AJAXLoadEventComplete,transFadeOut);$myEventDisatchObj.on(customEvents.contentFadeInComplete,transitionOutComplete)}function getRootURL(){var e=window.location.href;if(params.rootURL&&e.indexOf(params.rootURL)>=0)return params.rootURL;params.rootURL=e.indexOf("uzful.fr/")>=0?e.substring(0,e.indexOf("uzful.fr/")+String("uzful.fr/").length):params.rootURL;return params.rootURL}function clickNavigate(e){console.log("clickNavigate");var t=$(e).attr("rel"),n=$(e);t?navigateTo(t):$(e).is(".anchor-link")&&navigateTo(e)}function navigateTo(e){console.log("navigate to "+e);params.firstLoad||(params.firstPage=!1);var t;if(typeof e=="string"){t=e;var n=t.indexOf("#!/")>=0?t.substring(t.indexOf(hashtag)+3):"";if(n.indexOf("#")>-1){n=n.split();n=n[0]}var r=new RegExp("[ /;]+","g");dataToLoad=String(n).split(r);requestedURI=t;var i=getRootURL()+dataToLoad[0];console.log("parameters:",n,getRootURL());t&&$("#history li:last-child").attr("rel")!==t?entirePageAjaxNavigateTo(i):console.log("ABANDON on tente de recharger la page courante")}else{var s=$(e).attr("name");if(s){dataToLoad[1]=s;dataToLoad[0]=dataDisplayed[0];i=getRootURL()+dataDisplayed[0]+"/"+dataToLoad[1]+"/";requestedURI=getRootURL()+hashtag+dataDisplayed[0]+"/"+dataToLoad[1]+"/";i&&$("#history li:last-child").attr("rel")!==i?ajaxLoad(i):console.log("ABANDON on tente de recharger la page courante")}}}function ajaxLoad(e){console.log("ajaxLoad");if(dataDisplayed[1]===dataToLoad[1])return;$.ajax({url:e,processData:!0,dataType:"html",success:function(t){dataLoaded=t;$($myEventDisatchObj).trigger({type:customEvents.AJAXLoadEventComplete,data:e});transiting||transitionOutComplete()},error:function(t,n,r){window.location.href=e;return!1}})}function entirePageAjaxNavigateTo(e){console.log("entirePageAjaxNavigateTo "+e);var t=$(document.body),n={duration:800,easing:"swing"};if(dataDisplayed[0]===dataToLoad[0]){if(!dataToLoad[1])return;ajaxLoad(getRootURL()+dataToLoad[0]+"/"+dataToLoad[1]);return}$($myEventDisatchObj).one(customEvents.contentFadeOutComplete,function(n){$.scrollTo(0);console.log("loading level 1 start ->"+e);t.addClass("loading");$.ajax({url:e,processData:!0,dataType:"html",success:function(n){var r=$(n).filter("title").text(),i=$(mainContentSelector).filter(":first"),s=$(headerContentSelector),o=$(n).find(mainContentSelector),u=$(n).find(headerContentSelector);i.length===0&&(i=t);document.title=r;i.html(o.html());s.html(u.html());i.show();if(!dataToLoad[1]||dataToLoad[1]===""){t.removeClass("loading");$.debounce(function(){$($myEventDisatchObj).trigger({type:customEvents.AJAXLoadEventComplete,data:e,to:undefined})},300)()}else{ajaxLoad(getRootURL()+dataToLoad[0]+"/"+dataToLoad[1]);constructanchorsListMenu()}dataDisplayed[0]=dataToLoad[0];dataToLoad[0]=null},error:function(t,n,r){window.location.href=e;return!1}})});$($myEventDisatchObj).trigger({type:customEvents.AJAXLoadEventReady,data:e,to:undefined})}function transFadeIn(e){console.log("transFadeIn");var t=$("#transition-pane");if(e.type===customEvents.AJAXLoadEventReady&&!transiting){transiting=!0;t.css("margin-right","0").css("left",$("body").width()+"px").show().animate({left:0,easing:"easeOutQuad"},{duraction:400,step:function(e,t){},complete:function(){console.log(dataDisplayed);buildHistory();$($myEventDisatchObj).trigger({type:customEvents.contentFadeOutComplete})}})}else t.show().css("left",0)}function transFadeOut(e){console.log("transFadeOut",transiting);var t=$("#transition-pane");if(e.type===customEvents.AJAXLoadEventComplete&&transiting){var t=$("#transition-pane");t.css("margin-left",0).css("width",$("body").width()+"px").show().animate({width:"20px",easing:"easeOutQuad"},{duration:400,step:function(e,t){},complete:function(){console.log("pane right to left -> ok");t.animate({height:0},{duraction:500,complete:function(){console.log("pane bottom to top -> ok");t.hide();$($myEventDisatchObj).trigger({type:customEvents.contentFadeInComplete});transiting=!1}})}})}else{transiting=!1;t.hide();$($myEventDisatchObj).trigger({type:customEvents.contentFadeInComplete})}}function transitionOutComplete(e){targetToScrollTo=$('a[name$="'+dataToLoad[1]+'"]');console.log("transitionOutComplete",targetToScrollTo);targetToScrollTo.length===1&&$(".antiscroll-inner").scrollTo(targetToScrollTo,800,{easing:"swing",onAfter:function(){showTheNewContent()}})}function showTheNewContent(){var e=$('#main div[data-rel="'+dataToLoad[1]+'"]');if(!dataLoaded)return;console.log("showTheNewContent ",e);if(!e.length){console.log("ABANDON : pas de conteneur destiné à ce chargement");return}e.hasClass("loading")||e.addClass("loading");var t="#main,article:first,.article:first,.post:first",n=$(dataLoaded).filter("title").text(),r=$(dataLoaded).find(t);$toReplace=$("#sum-"+e.attr("data-rel"));$toReplace.fadeOut("100",function(){$toReplace.hide();$(e).html(r.html()).fadeIn("100");document.title=n;e.removeClass("loading");dataDisplayed[1]=dataToLoad[1];dataToLoad[1]=null;dataLoaded=null;$($myEventDisatchObj).trigger({type:customEvents.newContentDisplayed})})}function hideContent(e){console.log("hideContent ",param);$(e);var t=$('#main div[data-fullcontent="'+param+'/"]'),n=$("#sum-"+t.attr("removeClass"));if(t&&t.html()){t.html("");n.hide().show()}}var speed=30,history=window.history,$anchors,$anchorsListMenu,$=window.jQuery,cookieName="uzful_fr_cookie",cookieOptions={expires:1,domain:"uzful.fr",secure:!0,raw:!0,path:"/"},requestedURI,document=window.document,dataToLoad=[],dataDisplayed=[],dataLoaded=null,mainContentSelector="#content,article:first,.article:first,.post:first",headerContentSelector="#inner-header:first",transiting=!1,histArray=[],targetToScrollTo=null;