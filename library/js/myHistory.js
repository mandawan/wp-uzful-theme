
function initHistory()
{
  console.log('initHistoryNav');

  // Check to see if History.js is enabled for our Browser

  if ( history && !history.enabled )
  {
    //TODO a terme n'utiliser que window.history et virer hashchange ?
    //initCookie();
    //return false;
  }

    //TODO virer ces bouteau et les écouteurs correspondants
  $("#history #prev").click(function() {
    console.log('back');
    history.go(-1);
  });

  $("#history #next").click(function() {
    console.log('fw');
    history.go(+1);
  });
}


function buildHistory()
{
  console.log("addToHistory :"+window.location.href);
  var pUrl = rootURL+'#!/'+dataDisplayed[0] + '/' +  dataDisplayed[1];
  var pTitle = document.title;
    
  //if($.session.get('histArray') && $.session.get('histArray') != 'undefined')
    //histArray = Array($.session.get('histArray'));

  console.log('histArray'+histArray);
  var histIndex = histArray.length;
  
  if (histArray.length)
  {
    for(var i=0;i<histArray.length;i++){

      $target=histArray[i].button;
      
      if($target.children('a').attr('href')==='#') $target.children('a').attr('href', histArray[i].url);

      //NOTE: on identifie la première url indentique déjà présente dans l'historique
      console.log("histArray[i].url "+histArray[i].url);
      console.log("pUrl "+pUrl);
      if(histArray[i].url === pUrl && histIndex > i)
      {
        histIndex = i;
        console.log('HAVE TO REMOVE FROM '+i);
      }
      //NOTE:suppression de tout élément d'historique  postérieur à l'index à conserver
      if(histIndex <= i)
      {
        $target.remove();
        console.log(i+'REMOVED');
      }

     // $.session.set('histArray', histArray);
    }

  }
  
  //NOTE:on a reculé dans l'historique visuel -> MAJ l'historique data
  if(histIndex >= histArray.length)
    histArray.splice(histIndex, (histArray.length - histIndex --));

 //nouvelle entrée cliquable dans l'historique visuel ()
  var htm = '<li class="history-page-but hist-'+(histArray.length+1)+'" onClick="clickNavigate(this)" rel="'+pUrl+'"><a href="#" title="'+pTitle+'"><div><span>'+pTitle+'</span></div></a></li>';
  $('#history').append(htm);

  var myBut = $('#history li[rel="'+pUrl+'"]');

  //TODO ici utiliser plutot le slot data() de jquery pour stocker les données historique dans chaque <li>
  var pageObj = { title: pTitle, url:pUrl, button: myBut};
  histArray.push(pageObj);

  //console.log($('#history li[rel="'+pTitle+'"]'));

  myBut.hover(function()
  {
    var span = $(this).children('a').children('div');
    console.log('hover !', $(this), $(this).children('a').children('div').width());
    $(this).stop();
    $(this).animate({
      width:span.outerWidth()+15
    }, {
      duration:300,
      easing:'linear'
    });
  },
  function()
  {
    $(this).stop();
    $(this).animate({
      width:15
    }, {
      easing:'swing'
    });
  });
  
  /*
  

  //if that url already is in out historic array
  if(histArray.histIndexOf(url) != -1)
  {
    
  }*/
}

function initCookie()
{
  if($.cookie(cookieName)) removeCookie(cookieName);
  
  var data= []
  console.log('hist -> '+history[0])
  if(history)

  $.cookie(cookieName, data, cookieOptions)

var t=[1,2,3,4];

$.session.set('some key', t);

console.log($.session.get('some key'));

return;
$.session.clear();

$.session.get('some key');


$.session.set('some key', 'a value').get('some key');


$.session.delete('some key');

$.session.get('some key');



// To Read
alert( $.session("myVar") );
  

}
