function initanchorsListMenu(){console.log("initanchorsListMenu");console.log($(".antiscroll-inner"));$($myEventDisatchObj).on(customEvents.AJAXLoadEventComplete,constructanchorsListMenu);constructanchorsListMenu()}function constructanchorsListMenu(e){console.log("constructanchorsListMenu");$(".antiscroll-inner").length&&($.fn.waypoint.defaults.context=$(".antiscroll-inner"));$anchors&&$anchors.length&&$anchors.unbind("waypoint.reached",anchorReached);$anchors=$("#content:first #inner-content:first #main:first a.anchor");if($anchors&&$anchors.length){$anchors.waypoint(function(e,t){t&&console.log(t);$anchors.each(function(){$(this).data("button").removeClass("selected")});$(e.target).data("button").addClass("selected")},{offset:function(e){var t;return $("header:first").height()}});$anchorsListMenu.html("");$anchors.each(function(){var e=$(this),t='<li id="anchor-link-'+e.attr("id")+'" class="anchor-link" onClick="clickNavigate(this)" name="'+e.attr("name")+'"><a title="'+e.attr("data-title")+'" subtitle="'+e.attr("data-sub")+'"><span class="a-title">'+e.attr("data-title").toString()+'</span><span class="a-sub">'+e.attr("data-sub").toString()+"</span></a></li>";$anchorsListMenu.append(t);var n=$anchorsListMenu.children("#anchor-link-"+e.attr("id"));n.data("target",e);e.data("button",n);$anchorsListMenu.children("li").css("height",100/$anchors.length+"%")})}}function anchorReached(e,t){console.log(e,t)}function initNavListeners(){$myEventDisatchObj.on(customEvents.AJAXLoadEventReady,transFadeIn);$myEventDisatchObj.on(customEvents.AJAXLoadEventComplete,transFadeOut);$myEventDisatchObj.on(customEvents.contentFadeInComplete,transitionOutComplete)}function clickNavigate(e){console.log("clickNavigate");var t=$(e).attr("rel"),n=$(e);t?navigateTo(t):$(e).is(".anchor-link")&&navigateTo(e)}function navigateTo(e){console.log("navigate to "+e);params.firstLoad||(params.firstPage=!1);var t;if(typeof e=="string"){t=e;var n=t.indexOf("#!/")>=0?t.substring(t.indexOf(hashtag)+3):"";params.rootURL=String(t).slice(0,String(t).indexOf(hashtag));var r=new RegExp("[ /;]+","g");dataToLoad=String(n).split(r);requestedURI=t;var i=params.rootURL+dataToLoad[0];console.log("parameters:",n,params.rootURL);t&&$("#history li:last-child").attr("rel")!==t?entirePageAjaxNavigateTo(i):console.log("ABANDON on tente de recharger la page courante")}else{var s=$(e).attr("name");if(s){dataToLoad[1]=s;dataToLoad[0]=dataDisplayed[0];i=params.rootURL+dataDisplayed[0]+"/"+dataToLoad[1]+"/";requestedURI=params.rootURL+hashtag+dataDisplayed[0]+"/"+dataToLoad[1]+"/";i&&$("#history li:last-child").attr("rel")!==i?ajaxLoadToContainer(i):console.log("ABANDON on tente de recharger la page courante")}}}function ajaxLoadToContainer(e){if(dataDisplayed[1]===dataToLoad[1])return;var t=$('#main div[data-fullcontent="'+requestedURI+'"]');console.log("ajaxLoadToContainer ",e,t);if(!t.length){console.log("ABANDON : pas de conteneur destiné à ce chargement");return}t.hasClass("loading")||t.addClass("loading");var n=$('#main div[data-fullcontent="'+params.rootURL+"#!/"+dataDisplayed[0]+"/"+dataDisplayed[1]+'/"]'),r=$("#sum-"+n.attr("rel"));if(n&&n.html()){console.log("oldFull:",n);console.log("oldSum:",r,r[0]);n.html("");r.hide().show()}$.ajax({url:e,processData:!0,dataType:"html",success:function(n){var r="#main,article:first,.article:first,.post:first",i=$(n).filter("title").text(),s=$(n).find(r);$toReplace=$("#sum-"+t.attr("rel"));$toReplace.fadeOut("100",function(){$toReplace.hide();$(t).html(s.html()).fadeIn("100");document.title=i;t.removeClass("loading");dataDisplayed[1]=dataToLoad[1];dataToLoad[1]=null;$.debounce(function(){$($myEventDisatchObj).trigger({type:customEvents.AJAXLoadEventComplete,data:e,to:t});transiting||transitionOutComplete()},300)()})},error:function(t,n,r){window.location.href=e;return!1}})}function entirePageAjaxNavigateTo(e){console.log("entirePageAjaxNavigateTo "+e);var t=$(document.body),n={duration:800,easing:"swing"};if(dataDisplayed[0]===dataToLoad[0]){if(!dataToLoad[1])return;ajaxLoadToContainer(params.rootURL+dataToLoad[0]+"/"+dataToLoad[1]);return}$($myEventDisatchObj).one(customEvents.contentFadeOutComplete,function(n){$.scrollTo(0);console.log("loading level 1 start ->"+e);t.addClass("loading");$.ajax({url:e,processData:!0,dataType:"html",success:function(n){var r=$(n).filter("title").text(),i=$(mainContentSelector).filter(":first"),s=$(headerContentSelector),o=$(n).find(mainContentSelector),u=$(n).find(headerContentSelector);i.length===0&&(i=t);document.title=r;i.html(o.html());s.html(u.html());i.show();if(!dataToLoad[1]||dataToLoad[1]===""){t.removeClass("loading");$.debounce(function(){$($myEventDisatchObj).trigger({type:customEvents.AJAXLoadEventComplete,data:e,to:undefined})},300)()}else ajaxLoadToContainer(params.rootURL+dataToLoad[0]+"/"+dataToLoad[1]);dataDisplayed[0]=dataToLoad[0];dataToLoad[0]=null},error:function(t,n,r){window.location.href=e;return!1}})});$($myEventDisatchObj).trigger({type:customEvents.AJAXLoadEventReady,data:e,to:undefined})}function transFadeIn(e){console.log("transFadeIn");var t=$("#transition-pane");if(e.type===customEvents.AJAXLoadEventReady&&!transiting){transiting=!0;t.css("margin-right","0").css("left",$("body").width()+"px").show().animate({left:0},{duraction:500,step:function(e,t){},complete:function(){buildHistory();$($myEventDisatchObj).trigger({type:customEvents.contentFadeOutComplete})}})}else t.show().css("left",0)}function transFadeOut(e){console.log("transFadeOut",transiting);var t=$("#transition-pane");if(e.type===customEvents.AJAXLoadEventComplete&&transiting){var t=$("#transition-pane");t.css("margin-left",0).css("width",$("body").width()+"px").show().animate({width:"20px"},{duration:1500,step:function(e,t){},complete:function(){console.log("pane right to left -> ok");t.animate({height:0},{duraction:500,complete:function(){console.log("pane bottom to top -> ok");t.hide();$($myEventDisatchObj).trigger({type:customEvents.contentFadeInComplete});transiting=!1}})}})}else{transiting=!1;t.hide();$($myEventDisatchObj).trigger({type:customEvents.contentFadeInComplete})}}function transitionOutComplete(e){targetToScrollTo=$('a[name$="'+dataDisplayed[1]+'"]');console.log("transitionOutComplete",targetToScrollTo);targetToScrollTo.length===1&&$(".antiscroll-inner").scrollTo(targetToScrollTo,800,{easing:"swing"})}var speed=30,history=window.history,$anchors,$anchorsListMenu,$=window.jQuery,cookieName="uzful_fr_cookie",cookieOptions={expires:1,domain:"uzful.fr",secure:!0,raw:!0,path:"/"},requestedURI,hashtag="#!/",document=window.document,dataToLoad=[],dataDisplayed=[],mainContentSelector="#content,article:first,.article:first,.post:first",headerContentSelector="#inner-header:first",transiting=!1,histArray=[],targetToScrollTo=null;