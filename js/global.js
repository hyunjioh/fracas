$OBJ = {
	'win' : $(window),
	'doc' : $(document),
	'html' : $('html')
}

function winW(){//창 너비
	return $OBJ.win.width();
}

function winH(){// 창 높이
	return $OBJ.win.height();
}

function winSh(){// 스크롤 값
	return $OBJ.win.scrollTop();
}

function ajaxLink(href,type,idx){//a:주소, b:type, c:넘길 값
	$.ajax({
		type: type,
		url: href,
		data : idx,
		success : function(data) {
			$('body').find('._pop-ajax').remove().end().append(data).find('._pop-ajax').fadeIn(500);
		}
	});
}

function ajaxClose(a){
	$(a).fadeOut(500,function(){$(this).remove()});
}


var bookmark = {
	init : function(){
		this.action();
	},
	action : function(){
		var set = {
			btn : $('._favorite')
		};

		var isIE = /*@cc_on!@*/false || !!document.documentMode;//익스플로러
		var mainUrl = document.location.href.match(/(http[s]*:\/\/[a-zA-Z0-9\-\.]*)/)[1];
		var title = document.title;

		set.btn.on({
			'click' : function(){
				if(isIE){
					window.external.AddFavorite(mainUrl, title);
				}else{
					alert('확인을 클릭하신 후 주소창에서 <Ctrl-D>를 누르시면 즐겨찾기에 등록됩니다.');
				}
				return false;
			}
		});
	}
};

function mChk(){// 모바일 체크
	return $('#mchk').is(':visible');
}


var head = {
	init : function(){
		this.action();
	},
	action : function(){
		var a = $('#header');
		var gnb = a.find('.gnb');
		var mnu = a.find('.mnu');

		gnb.on('mouseenter',function(){
			if(mChk()==false){
				$OBJ.html.addClass('navOn');
			}
		}).on('mouseleave',function(){
			if(mChk()==false){
				$OBJ.html.removeClass('navOn');
			}
		}).on('click','> li > a',function(){
			if(mChk()==true){
				$(this).closest('li').toggleClass('active').siblings().removeClass('active');
				return false;
			}
		});

		mnu.on('click',function(){
			$OBJ.html.toggleClass('navOn');
		});

	}
};


var vis = {
	init : function(){
		this.action();
	},
	action : function(){
		var a = $('#vis .roll');

		a.slick({
			arrows: false,
			dots: true,
			infinite: true,
			speed: 1000,
			autoplay: true,
			autoplaySpeed: 4000,
			fade: true
		});

	}
};

var pgm = {
	init : function(){
		this.action();
	},
	action : function(){
		var row1 = $('._pgmRow1 .area');
		var row2 = $('._pgmRow2 .area');

		row1.slick({
			arrows: true,
			dots: true,
			slidesToShow: 4,
			slidesToScroll: 4,
			infinite: true,
			autoplay: true,
			autoplaySpeed: 3000,
			speed: 300,
			responsive: [
				{
					breakpoint: 1024,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 2,
						arrows: false
					}
				}
			]
		});

		row2.slick({
			arrows: true,
			dots: true,
			slidesPerRow: 4,
			rows: 2,
			infinite: true,
			autoplay: true,
			autoplaySpeed: 3000,
			speed: 300,
			responsive: [
				{
					breakpoint: 1024,
					settings: {
						slidesPerRow: 2,
						rows: 2,
						arrows: false
					}
				}
			]
		});

	}
};


var notice = {
	init : function(){
		this.action();
	},
	action : function(){
		var a = $('#notice');
		var roll = a.find('.roll');
		var tab = a.find('.tab a');
		var area = a.find('.sec .area');

		roll.slick({
			arrows: false,
			dots: true,
			infinite: true,
			speed: 1000,
			autoplay: true,
			autoplaySpeed: 4000,
			fade: true
		});

		tab.on('click',function(){
			$(this).addClass('active').siblings().removeClass('active');
			area.eq($(this).index()).addClass('active').siblings().removeClass('active');
			return false;
		});

	}
};


//GOTOP
var gotop = {
	init : function(){
		this.action();
	},
	action : function(){
		var a = $('#gotop');

		function goTopShow(){
			if(winSh() > 100){
				a.addClass('show');
			}else{
				a.removeClass('show');
			}
		}

		a.on('click',function(){
			$.scrollTo($OBJ.html,300);
		});

		$OBJ.win.on('load scroll',function(){
			goTopShow();
		});

	}
}

$OBJ.doc.ready(function(){
	head.init();
	gotop.init();
});

$OBJ.win.on('load',function(){
	AOS.init({
		duration:1000,
		offset: 20
	});
});


var mBan = {
	init : function(){
		this.action();
	},
	action : function(){
		var a = $('#mban');
		var roll = a.find('.roll');

		roll.bxSlider({
			auto: true,
			pager: false,
			stopAutoOnClick: true,
			adaptiveHeight: true,
			autoControls: true,
			autoControlsCombine: true,
			pause: 5000,
			speed: 200
		});
	}
}

$(document).ready(function(){
	bookmark.init();
	//head.init();
	tab.init();
	wows.init();
});
function ajaxLink(href,type,idx){//a:주소, b:type, c:넘길 값
	$.ajax({
		type: type,
		url: href,
		data : idx,
		success : function(data) {
			$('body').find('._popAjax').remove().end().append(data).find('._popAjax').fadeIn(500);
		}
	});
}
