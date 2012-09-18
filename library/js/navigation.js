var
    //FOR AJAX HISTORY NAV
  speed=30,
  history = window.history,
  $anchors,
  $anchorsListMenu,
  //TIP
  $ = window.jQuery,
  //WEBSITE ROOT URL FOUND THROUGH JS
  cookieName = "uzful_fr_cookie",
  cookieOptions = { 
    //cookie expires after 1 day
    expires: 1,
    domain: 'uzful.fr',
    secure:true,
    raw:true,
    path:'/'
    },
  requestedURI,
  hashtag='#!/',
  document = window.document,
  //ARRAY CONTAINING THE URI SECTIONS LEADING TO DATA TO LOAD
  dataToLoad = [],
  dataDisplayed = [],
  mainContentSelector = '#content,article:first,.article:first,.post:first',
  headerContentSelector = '#inner-header:first',
  transiting=false,
  //ARRAY CONTAINING THE HISTORY ELEMENTS TO CHECK AND STORE
  histArray = [],
  targetToScrollTo=null;




/*
ANCHORS NAV
*/
function initanchorsListMenu()
{ 
  console.log('initanchorsListMenu');
  //console.log('--------------->',$('.antiscroll-inner'));

  //on init le context de la scrollbar
  console.log($('.antiscroll-inner'));
  
  // a chaque chargement ajax terminé, on reconstruit le menu par ancres
  $($myEventDisatchObj).on(customEvents.AJAXLoadEventComplete, constructanchorsListMenu);
  $($myEventDisatchObj).on(customEvents.AJAXLoadEventComplete, constructanchorsListMenu);

  //création de l'anchor menu au onLoad  
  constructanchorsListMenu(); 
}

function constructanchorsListMenu(o)
{ 

  console.log('constructanchorsListMenu');
  
  $.fn.waypoint.defaults.context = $('.antiscroll-inner');

  //clear listeners
  if($anchors && $anchors.length)
    $anchors.unbind('waypoint.reached', anchorReached);
  
  $anchors = $('#content:first #inner-content:first #main:first a.anchor');
  //console.log("anchorsListMenu :", $anchorsListMenu);
  //console.log("anchors :", $anchors);
  //listen to scroll events
  if($anchors && $anchors.length)
  {
    $anchors.waypoint(function(event, direction) {
      //console.log('waypoint!', event.target);
      
      //console.log('waypoint!', event.target, $(event.target).data('button'));

      
      if(direction)
        console.log(direction);

      

      $anchors.each(function()
      {
        $(this).data('button').removeClass('selected');
      });
      
      //console.log($(event.target).data('button'));
      $(event.target).data('button').addClass('selected');
      //$('#anchor-link-'+$(event.target).attr('id')).addClass('selected');
    
    }, {

      offset: function(direction){
        var offset;
        /*if(direction)
          offset = (direction === 'up')?'80%':'20%';
        else
          offset = '20%';
        return offset;*/
        return $('header:first').height();
      }

    });
    //on vide le menu
    $anchorsListMenu.html('');
    //on re construit le menu
    $anchors.each(function(){
      var $target = $(this);

      var htm = '<li id="anchor-link-'+$target.attr('id')+'" class="anchor-link" onClick="clickNavigate(this)" name="'+$target.attr('name')+'"><a title="'+$target.attr('data-title')+'" subtitle="'+$target.attr('data-sub')+'"><span class="a-title">'+$target.attr('data-title').toString()+'</span><span class="a-sub">'+$target.attr('data-sub').toString()+'</span></a></li>';
      $anchorsListMenu.append(htm);  

      
      var $button = $anchorsListMenu.children('#anchor-link-'+$target.attr('id'));
      $button.data('target', $target);
      
      $target.data('button', $button);
       $anchorsListMenu.children('li').css('height', 100/$anchors.length+'%')
    });

  }
}

function anchorReached(event, direction) {
   console.log(event, direction);
}


/*
AJAX LOADING
*/

function initNavListeners()
{
  //TRANSITIONS DE CHARGEMENT AJAX
  $myEventDisatchObj.on(customEvents.AJAXLoadEventReady, transFadeIn);
  $myEventDisatchObj.on(customEvents.AJAXLoadEventComplete, transFadeOut);
  $myEventDisatchObj.on(customEvents.contentFadeInComplete, transitionOutComplete);

  //'<li class="white history-page" rel="http://127.0.0.1/uzful.fr/www/" onClick="clickNavigate(this)"></li>');
  
}

function clickNavigate(element)
{

  console.log("clickNavigate");
  var url = $(element).attr('rel');
  var hash = $(element);
  if(url)
  {
    navigateTo(url);
  }
  else if($(element).is('.anchor-link'))
  {
    navigateTo(element);
    /*var target = $(element).data('target');
    console.log(target)
    $.scrollTo(target, 800, {easing:'swing'}); */
  }


}

function navigateTo(pTarget)
{

  console.log("navigate to "+pTarget);

  // ce n'est aps le premier chargement de page, donc ce n'est pas la première page vue
  if(!params.firstLoad) params.firstPage = false;

  var url;
  if(typeof(pTarget)==='string'){
    url = pTarget;
    //on retrouve le vrai lien
    var arg = (url.indexOf('#!/') >= 0) ? url.substring(url.indexOf(hashtag)+3) : '';
    //global rootURL trouvé en JS
    //TODO : remplacer par du PHP si nécessaire ?
    params.rootURL = String(url).slice(0, String(url).indexOf(hashtag));

    //ON RENSEIGNE LES DONNEES A CHARGER PAR NIVEAU
    var reg=new RegExp("[ /;]+", "g");
    dataToLoad = String(arg).split(reg);
    requestedURI = url
    //on construit l'url de niveau 1 
    var urlToLoad = params.rootURL+dataToLoad[0];
      
    console.log("parameters:",arg, params.rootURL);
    if(url && $('#history li:last-child').attr('rel') !== url)
    {
      //console.log(dataToLoad);
      //console.log(dataDisplayed);
      //si on a des données de level1 à charger ou que le conteneur de level2 est absents
        entirePageAjaxNavigateTo(urlToLoad);
    }
    else
    {
      console.log('ABANDON on tente de recharger la page courante')
    }    
  }
  else {
    var target = $(pTarget).attr('name')
    if(target)
    {
      dataToLoad[1]=target;
      dataToLoad[0]=dataDisplayed[0]
      urlToLoad = params.rootURL+dataDisplayed[0]+ '/' + dataToLoad[1] + '/';
      requestedURI = params.rootURL + hashtag + dataDisplayed[0]+ '/' + dataToLoad[1] + '/';

      if(urlToLoad && $('#history li:last-child').attr('rel') !== urlToLoad)
      {

          //on charge directement le level2
          ajaxLoadToContainer(urlToLoad);
      }
      else
      {
        console.log('ABANDON on tente de recharger la page courante')
      }      
    }
  }

}

function ajaxLoadToContainer(link)
{
  //SI même contenu de niveau 2 demandé ABANDON
  if(dataDisplayed[1] === dataToLoad[1]) return;


  //on cherche si on a un contener 'local' à dispo pour le chargement AJAX
  var $container = $('#main div[data-fullcontent="' + requestedURI + '"]');

  console.log("ajaxLoadToContainer ", link, $container);
  //console.log($container);

  if(!$container.length) 
  {
    console.log('ABANDON : pas de conteneur destiné à ce chargement');
    return;
  }
  if(!$container.hasClass('loading'))
    $container.addClass('loading');


  var $oldFull = $('#main div[data-fullcontent="' + params.rootURL + "#!/" + dataDisplayed[0]  + '/' + dataDisplayed[1] + '/"]');
  var $oldSum = $('#sum-' + $oldFull.attr('rel'));

  if($oldFull && $oldFull.html())
  { 
    console.log("oldFull:",$oldFull);
    console.log("oldSum:",$oldSum, $oldSum[0]);
    $oldFull.html('');
    $oldSum.hide().show();
  }

  $.ajax({
              url: link,
              processData: true,
              dataType:'html',
              success: function(data){
                  
                  var
                    contentSelector = '#main,article:first,.article:first,.post:first',
                    title = $(data).filter('title').text(),
                    $content = $(data).find(contentSelector);
                  
                  




                  $toReplace = $('#sum-'+ $container.attr('rel'));
                  $toReplace.fadeOut('100',function(){

                    $toReplace.hide();

                    $($container).html($content.html()).fadeIn('100');

                    document.title = title;

                    $container.removeClass('loading');

                    //NOTE:on n'historise pas la navigation ajax intra page
                    //buildHistory(link, title);


                    dataDisplayed[1] = dataToLoad[1];
                    //on vide le niveau 1 de la requête
                    dataToLoad[1] = null;



                    //loading has ended let's trigger transition

                    $.debounce(function() {
                      $($myEventDisatchObj).trigger({ type:customEvents.AJAXLoadEventComplete, data:link, to:$container});

                      if(!transiting)
                      {
                        transitionOutComplete();
                      }
                      // Will only execute 300ms after.
                    }, 300)();
                    
                  });

                  //TODO: implémenter google analytics
              },
              error: function(jqXHR, textStatus, errorThrown){
                //NOTE: débouchera généralement sur /404
                window.location.href = link;
                return false;
              }
          });//end ajax  

}


function entirePageAjaxNavigateTo (link)
{
  console.log("entirePageAjaxNavigateTo "+link);

  var $body = $(document.body),
  scrollOptions = {
                        duration: 800,
                        easing:'swing'
                    };
 
  //SI même url demandée
  //if(link && $('#history li:last-child').attr('rel') === link) return false;

  //SI même contenu de niveau 1 demandé
  if(dataDisplayed[0] === dataToLoad[0])
  {
    if(!dataToLoad[1])
    {
      //pas de navigation de niveau 2 demandée
      return;
    }
    //on lance le chargement du niveau 2
    else
    {
      ajaxLoadToContainer(params.rootURL+dataToLoad[0]+'/'+dataToLoad[1]);
      return;
    }
  }


  //we wait for transition to loading to be complete
  $($myEventDisatchObj).one(customEvents.contentFadeOutComplete, function(o) {
    $.scrollTo(0);
    console.log('loading level 1 start ->'+link);

    $body.addClass('loading');
    $.ajax({
                url: link,
                processData: true,
                dataType:'html',
                success: function(data){

                    var title = $(data).filter('title').text(),
                      $container = $(mainContentSelector).filter(':first'),
                      $headerContainer = $(headerContentSelector),
                      $content = $(data).find(mainContentSelector),
                      $headerContent = $(data).find(headerContentSelector);
                      
                    // Ensure container
                    if ($container.length === 0 ) {
                      $container = $body;
                    }

                    document.title = title;
                    $container.html($content.html())
                    $headerContainer.html($headerContent.html())

                    $container.show();

                    //console.log($container);

                    //si on n'a rien de niveau 2 à charger
                    if(!dataToLoad[1] || dataToLoad[1] === "")
                    {
                      $body.removeClass('loading');

                      //loading has ended let's trigger transition
                      $.debounce(function() {
                        
                        $($myEventDisatchObj).trigger({ type:customEvents.AJAXLoadEventComplete, data:link, to:undefined });
                        
                        // Will only execute 300ms after.
                      }, 300)();

                      //TODO: implémenter google analytics
                    }
                    //on lance le chargement du niveau 2
                    else
                      ajaxLoadToContainer(params.rootURL+dataToLoad[0]+'/'+dataToLoad[1]);

                    dataDisplayed[0] = dataToLoad[0];
                    //on vide le niveau 1 de la requête
                    dataToLoad[0] = null;

                },
                error: function(jqXHR, textStatus, errorThrown){
                  //NOTE: débouchera généralement sur /404
                  window.location.href = link;
                  return false;
                }
            });//end ajax

  }); //end one bind
  
  //on déclenche la transition out
  $($myEventDisatchObj).trigger({ type:customEvents.AJAXLoadEventReady, data:link, to:undefined });
  


}


function transFadeIn(o){
  console.log('transFadeIn');
  var pane = $('#transition-pane');

  if(o.type === customEvents.AJAXLoadEventReady && !transiting)
  {
    transiting = true;
    pane.css('margin-right', '0').css('left', $('body').width()+'px').show().animate( {

      'left':0,

    },
    {
      duraction:500,
      step: function(now,fx){
        //console.log( "marginLeft: ", now );
      },
      complete:function(){
        buildHistory(); 
        $($myEventDisatchObj).trigger({ type:customEvents.contentFadeOutComplete });
      }
      
    });
  }
  else
  {
    pane.show().css('left',0);
  }
}

function transFadeOut(o){
  console.log('transFadeOut', transiting);
  var pane = $('#transition-pane');  
  
  if(o.type === customEvents.AJAXLoadEventComplete && transiting)
  {

    //TEMP
    //$('body').css('background-color', "white");
    var pane = $('#transition-pane');

    pane.css('margin-left', 0).css('width', $('body').width()+'px').show().animate( {

      width: '20px',

    }, 
    {
      duration:1500,
      step:function(now,fx){
        //console.log('marginRight:',now);
      },
      complete:function(){
        console.log('pane right to left -> ok');
        pane.animate({
          height:0
        },
        {
          duraction:500,
          complete:function()
          {
            console.log('pane bottom to top -> ok');
            pane.hide();
            $($myEventDisatchObj).trigger({ type:customEvents.contentFadeInComplete });
            transiting = false;
          }
        });
      }
    });    
  }
  else
  {
    transiting = false;
    pane.hide();
    
    $($myEventDisatchObj).trigger({ type:customEvents.contentFadeInComplete });
  }
}

function transitionOutComplete(o)
{
  //$('#transition-pane').hide();
  targetToScrollTo = $('a[name$="'+dataDisplayed[1]+'"]');

  if(targetToScrollTo.length == 1)
    $.scrollTo(targetToScrollTo, 800, {easing:'swing'});
}
