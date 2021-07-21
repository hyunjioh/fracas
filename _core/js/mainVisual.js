$(function() {
	var mainOnNum = 1;
	var timer;
	var topIndex = 1;
	var width = $(window).width();

	function onTimer() {
		if (mainOnNum > 4) {
			mainOnNum = 1;
		} else {
			mainOnNum++;
		}

		$(".control li").eq(mainOnNum-1).trigger("click");
	}

	function changeSceneSelector($num) {
		mainOnNum = $num+1;

		changeScene(mainOnNum);
	}

	function changeScene($num) {
		clearInterval(timer);

		mainOnNum = $num;

		topIndex++;

		switch($num) {
			case 1:
				timer = setInterval(onTimer,6000);

				$("#scene1").css({"z-index":topIndex});

				motion($num);
			break;
			
			case 2:
				timer = setInterval(onTimer,6000);

				$("#scene2").css({"z-index":topIndex});

				motion($num);
			break;

			case 3:
				timer = setInterval(onTimer,6000);

				$("#scene3").css({"z-index":topIndex});

				motion($num);
			break;

			case 4:
				timer = setInterval(onTimer,6000);

				$("#scene4").css({"z-index":topIndex});

				motion($num);
			break;
		}
	}

	function clearFunctions(){
		$("li").clearQueue();
		$("li").stop();

		$("p").clearQueue();
		$("p").stop();

		$("h2").clearQueue();
		$("h2").stop();

		$("ul").clearQueue();
		$("ul").stop();
	}

	function motion($mc) {
		clearFunctions();

		$("#scene1").stop().css("left",width);
		$("#scene1 h2").stop().css("top","-400px");
		$("#scene1 .link").stop().css("top","-400px");

		$("#scene2").stop().css("left",width);
		$("#scene2 h2").stop().css("top","-400px");
		$("#scene2 .link").stop().css("top","-400px");


		$("#scene3").stop().css("left",width);
		$("#scene3 h2").stop().css("top","-400px");
		$("#scene3 .link").stop().css("top","-400px");

		$("#scene4").stop().css("left",width);
		$("#scene4 h2").stop().css("top","-400px");
		$("#scene4 .link").stop().css("top","-400px");


		if($mc == 1) {
			$("#scene1").animate({"left":"0"},{duration:700, easing:"easeOutExpo"});
			$("#scene1 h2").delay(300).animate({"top":"35px"},{duration:1000, easing:"easeInOutCirc"});
			$("#scene1 .link").delay(100).animate({"top":"175px"},{duration:1000, easing:"easeInOutCirc"});


		} else if($mc == 2) {
			$("#scene2").animate({"left":"0"},{duration:700, easing:"easeOutExpo"});
			$("#scene2 h2").delay(300).animate({"top":"35px"},{duration:1000, easing:"easeInOutCirc"});
			$("#scene2 .link").delay(100).animate({"top":"175px"},{duration:1000, easing:"easeInOutCirc"});

		} else if($mc == 3) {
			$("#scene3").animate({"left":"0"},{duration:700, easing:"easeOutExpo"});
			$("#scene3 h2").delay(300).animate({"top":"35px"},{duration:1000, easing:"easeInOutCirc"});
			$("#scene3 .link").delay(100).animate({"top":"175px"},{duration:1000, easing:"easeInOutCirc"});

		} else {
			$("#scene4").animate({"left":"0"},{duration:700, easing:"easeOutExpo"});
			$("#scene4 h2").delay(300).animate({"top":"35px"},{duration:1000, easing:"easeInOutCirc"});
			$("#scene4 .link").delay(100).animate({"top":"175px"},{duration:1000, easing:"easeInOutCirc"});

		}
	}

	function init() { //초기화
		var $btns = $(".control li"),
			$motionC = $(".control #btnPlay");

		$btns.bind("click", function() { //버튼 이벤트 설정
			clearInterval(timer);
			timer = setInterval(onTimer,7000);
			var $this = $(this),
				index = $btns.index($this);
			
			if(window.console) {console.log("clicked : " + mainOnNum);}
			$btns.removeClass("on"); //버튼 텍스트 /on/off
			$this.addClass("on");
			
			changeSceneSelector(index);
			return false;
		});

		$motionC.bind("click", function() {
			var $this = $(this);
			if($this.hasClass("on")) {
				$this.text("자동재생");
				$this.attr("title","자동재생");
				$this.removeClass("on");
				clearInterval(timer);
			} else {
				$this.text("자동재생 멈춤");
				$this.attr("title","자동재생 멈춤");
				$this.addClass("on");
				clearInterval(timer);
				timer = setInterval(onTimer,3000);
			}
			return false;
		});

		changeScene(1);
	}

	var goInit = setTimeout(function() {
		init();
	}, 10);

	$(".scene").css("display","block");
	$(".scene").css("left",width);

});