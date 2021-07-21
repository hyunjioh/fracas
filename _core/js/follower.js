/***********************/
/* fireskill@gmail.com */
/* http://blog.bits.kr */
/*          2009/11/25 */
/***********************/

/*
jquery플러그인이므로 jquery를 필수로 사용해야 동작하는 스크립트입니다.

pageAlign : center 또는 left
pageWidth : 컨텐츠 블럭의 폭(필수값)
type      : right 또는 left(pageAlign의 값을 center로 했을때만 left값 사용가능)
topMargin : 페이지 최상단과의 거리
minTop    : 스크롤 했을때 브라우저 상단과의 거리(topMargin과 같은 값을 넣으면 같은 높이 유지)
margin    : 컨텐츠 블럭과의 좌 또는 우의 마진(left일때는 오른쪽 마진, right일때는 왼쪽 마진)
speed     : 따라다니는 속도
easing    : linear 또는 swing (easing plugin 플러그인을 쓴다면 플러그인 옵션값을 모두 사용할 수 있음)
zindex    : 필요하다면...
*/
(function($) {
  var $doc = $(document);
  var $win = $(window);
  $.fn.scrollFollower = function (options){
    var options = $.extend({}, $.fn.scrollFollower.defaults, options);
		if (options.pageWidth)
			var pageWidth    = parseInt(options.pageWidth);
		else
		{
			alert('pageWidth는 필수 옵션값입니다.');
			return false;
		}
    var $layer = $(this);
    var varType      = options.varType;
    var pageAlign    = options.pageAlign;
    var offset       = pageWidth/2;
    var layerPositon = options.type;
    var margin       = parseInt(options.margin);
    var speed        = parseInt(options.speed);
    var easing       = options.easing;
    var topMargin    = parseInt(options.topMargin);
    var minTop       = parseInt(options.minTop);
    var marginResult = offset + margin;
    var settedtop    = topMargin + minTop;
    $layer.css('z-index', options.zindex);
    $layer.css("position","absolute");
    if (layerPositon === 'left')
     varType = 'right';
    function resetXPosition()
    {
      if (pageAlign === 'center')
      {
        var $screenSize = $('body').width();
        var halfScreenSize = $screenSize/2;
        xPosition = halfScreenSize + marginResult;
      }
      else if (pageAlign === 'left')
      {
        varType   = 'left';
        xPosition = pageWidth + margin;
      }
      //$layer.css(varType, xPosition);
    }
    resetXPosition();
    $layer.css('top',topMargin);
    $win.resize(resetXPosition);
    $win.scroll(function(){
      $top = $doc.scrollTop();
      if ($top > settedtop){
        yPosition = $top - settedtop;
//	  } else if ($top <= topMargin){
//        yPosition = 0;
	  }else{
		  yPosition = minTop;
	  }

	  if(yPosition < minTop ) yPosition = minTop;

      $layer.animate({"top":yPosition }, {duration:speed, easing:easing, queue:false});
    });
  };
  $.fn.scrollFollower.defaults = {
    varType:'left',
    pageAlign:'left',
    type:'left',
    topMargin:0,
    minTop:0,
    margin:0,
    speed:1000,
    easing:'linear',
    zindex:10
    };
})( jQuery );