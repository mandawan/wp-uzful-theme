function initHistory(){console.log("initHistoryNav");history&&!history.enabled;$("#history #prev").click(function(){console.log("back");history.go(-1)});$("#history #next").click(function(){console.log("fw");history.go(1)})}function buildHistory(){console.log("addToHistory :"+window.location.href);var e=rootURL+"#!/"+dataDisplayed[0]+"/"+dataDisplayed[1],t=document.title;console.log("histArray"+histArray);var n=histArray.length;if(histArray.length)for(var r=0;r<histArray.length;r++){$target=histArray[r].button;$target.children("a").attr("href")==="#"&&$target.children("a").attr("href",histArray[r].url);console.log("histArray[i].url "+histArray[r].url);console.log("pUrl "+e);if(histArray[r].url===e&&n>r){n=r;console.log("HAVE TO REMOVE FROM "+r)}if(n<=r){$target.remove();console.log(r+"REMOVED")}}n>=histArray.length&&histArray.splice(n,histArray.length-n--);var i='<li class="history-page-but hist-'+(histArray.length+1)+'" onClick="clickNavigate(this)" rel="'+e+'"><a href="#" title="'+t+'"><div><span>'+t+"</span></div></a></li>";$("#history").append(i);var s=$('#history li[rel="'+e+'"]'),o={title:t,url:e,button:s};histArray.push(o);s.hover(function(){var e=$(this).children("a").children("div");console.log("hover !",$(this),$(this).children("a").children("div").width());$(this).stop();$(this).animate({width:e.outerWidth()+15},{duration:300,easing:"linear"})},function(){$(this).stop();$(this).animate({width:15},{easing:"swing"})})}function initCookie(){$.cookie(cookieName)&&removeCookie(cookieName);var e=[];console.log("hist -> "+history[0]);history&&$.cookie(cookieName,e,cookieOptions);var t=[1,2,3,4];$.session.set("some key",t);console.log($.session.get("some key"));return};