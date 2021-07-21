/*=================================================================================================
 common 
=================================================================================================*/
// element id로 객체 반화
function getElement(id){ 
      if(document.all) return document.all(id); 
      if(document.getElementById) return document.getElementById(id); 
}

// 링크 타겟 포커스 감추기
function bluring(){
	if(event.srcElement.tagName=="A"||event.srcElement.tagName=="IMG") document.body.focus();
}

document.onfocusin=bluring;

if(navigator.userAgent.indexOf('Firefox') >= 0){  
	(function(){   
		var events = ["mousedown", "mouseover", "mouseout", "mousemove", "mousedrag", "click", "dblclick"];     
		for (var i = 0; i < events.length; i++){    
			window.addEventListener(events[i], function(e){
				window.event = e;
			}, true);   
		}  
	}()	); 
};

/* png24 이미지 파일을 웹에서 투명하게 변경하는 스크립트 */
function setPng24(obj) {
    obj.width=obj.height=1;
    obj.className=obj.className.replace(/\bPNG24\b/i,'');
    obj.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+ obj.src +"',sizingMethod='image');"
    obj.src='';
    return '';
}
/*=================================================================================================
 Ajax 
=================================================================================================*/
var httpRequest = null;
function getXMLHttpRequest(){
     if(window.ActiveXObject){
        try{
                return new ActiveXObject("Msxml2.XMLHTTP");
        }catch(e){
                try{
                        return new ActiveXObject("Microsoft.XMLHTTP");
                }catch(e1){
                        return(null);
                }
        }
     }else if(window.XMLHttpRequest){
           return new XMLHttpRequest();
     }else{
           return null;
     }
}

function load(url, postvar, returnfn){
	httpRequest = getXMLHttpRequest();
	httpRequest.onreadystatechange = returnfn;
	httpRequest.open("POST", url, true);
	//httpRequest.setRequestHeader('Content-Type','application/x-www-form-urlencoded');  //한글 
	httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=euc-kr");
	httpRequest.send(postvar);
}

/*=================================================================================================
 cookie 
=================================================================================================*/
//쿠키생성
function setCookie( name, value, expiredays ){
	var today = new Date();
	today.setDate( today.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + today.toGMTString() + ";";
}

// 쿠키정보
function getCookie( name ) { 
	var nameOfCookie = name + "="; 
	var x = 0; 
	while ( x <= document.cookie.length ) { 
		var y = (x+nameOfCookie.length); 
		if ( document.cookie.substring( x, y ) == nameOfCookie ) { 
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 ) 
				endOfCookie = document.cookie.length; 
			return unescape( document.cookie.substring( y, endOfCookie ) ); 
		} 
		x = document.cookie.indexOf( " ", x ) + 1; 
		if ( x == 0 ) 
		break; 
	} 
	return ""; 
}

/*=================================================================================================
 memu 
=================================================================================================*/

/** 롤오버 버튼 **/
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

/*=================================================================================================
 browser 
=================================================================================================*/
// 새창띄우기
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

// 새창띄우기
function popup_Open(src,w,h){ 
	winpos = "left=" + ((window.screen.width-w)/2) + ",top=" + ((window.screen.height-h)/2);
	winstyle="width="+w+",height="+h+",status=no,toolbar=no,menubar=no,location=no,resizable=no,scrollbars=yes,copyhistory=no," + winpos;
	popwin = window.open(src,"팝업",winstyle);
	popwin = window.show;
} 


function enable_click(){
    document.PopupCheck.clickcontrol.value = "enable"
}

function opener_enable_click(){
    opener.document.PopupCheck.clickcontrol.value = "enable"
 }

function disable_click(){
    document.PopupCheck.clickcontrol.value = "disable"
}

function opener_disable_click(){
    opener.document.PopupCheck.clickcontrol.value = "disable"
}

function focus_control(){
    if(document.PopupCheck.clickcontrol.value == "disable"){
        if(Hannet_OpenWin == null){
            enable_click();
        }else{
            if(Hannet_OpenWin.closed == false) {
              Hannet_OpenWin.focus();
            }else{
              Hannet_OpenWin = null;
            }
        }
    }
}

function PopupClose(){
    opener_enable_click();
    self.close();
}

/*=================================================================================================
 from 
=================================================================================================*/
//다음 INPUT박스로 포커스 이동
function nextFocus(num,fromform,toform){
	var str = fromform.value.length;
	if(str == num)
	toform.focus();
}

// 라디오버튼이 선택되었는지 체크
function radioChecked(frm,objname, msg){
	CheckCount = 0;
	for(var i=0;i<frm.length;i++) {
		if(frm[i].type == "radio") {
			if(frm[i].name == objname){
				if(frm[i].checked == true){
					CheckCount = CheckCount + 1;
				}
			}
		}
	}
	if(CheckCount < 1){
		if(msg)	alert(msg);
		return false;
	}else{
		return true;
	}
}

function inputfocus(el, elvalue) {
	var inputContainer = document.getElementById(el);
	infocus = inputContainer.getElementsByTagName("input");

	for(i = 0; i < infocus.length; i++) {
		if (infocus.item(i).type == "text" || infocus.item(i).type == "password") {
			infocus.item(i).onfocus = function () {
				this.className = this.className.replace("input-blur", "input-focus");
				if(this.value == elvalue){
					this.value = ""
				}
			}
			infocus.item(i).onblur = function () {
				this.className = this.className.replace("input-focus", "input-blur");
			}
		}
	}
}
function inputclear(cel, elvalue) {
	var inputc = document.getElementById(cel);
	if(inputc.value == elvalue){
		inputc.value = ""
	}
}


function CheckLength(objTextarea, objByte, limitLength) { 
  var msgtext, msglen; 
    
    msgtext = objTextarea.value; 
    limitLengthKor = limitLength/2;
    
    var i=0,l=0; 
    var temp,lastl; 
    
    //길이를 구한다. 
    while(i < msgtext.length) 
    { 
        temp = msgtext.charAt(i); 
        
        if (escape(temp).length > 4) 
            l+=2; 
        else if (temp!='\r') 
            l++; 
        // OverFlow 
        if(l>limitLength) 
        { 
            //alert(l); 
            alert("한글 "+limitLengthKor+"자, 영문"+limitLength+"자까지만 쓰실 수 있습니다."); 
            temp = objTextarea.value.substr(0,i); 
            objTextarea.value = temp; 
            l = lastl; 
            break; 
        } 
        lastl = l; 
        i++; 
    } 
	if(objByte != false)  objByte.value=l; 
} 


/*=================================================================================================
 string 
=================================================================================================*/


// 문자열 좌,우 공백제거
function trim(str){   
	var leftI = 0;
	var rightI = 0;
	for(i = 0; i<str.length;i++){
		if(str.substring(i,i+1)==" " || str.substring(i,i+1)=="　"){//半角、全角
			leftI++;
		}else{
			break;
		}
	}
    str = str.substring(leftI,str.length);
	for(j=str.length; j>0;j--){
		if(str.substring(j-1,j)==" " || str.substring(j-1,j)=="　"){//半角、全角
			rightI++;
		}else{
			break;
		}
	}
    str = str.substring(0,str.length - rightI);
    return str;
}

// 숫자만 허용
function onlyNumber(obj){
 for (var i = 0; i < obj.value.length ; i++){
  chr = obj.value.substr(i,1);  
  chr = escape(chr);
  key_eg = chr.charAt(1);
  if (key_eg == 'u'){
   key_num = chr.substr(i,(chr.length-1));   
   if((key_num < "AC00") || (key_num > "D7A3")) { 
    event.returnValue = false;
   }    
  }
 }
 if (event.keyCode >= 48 && event.keyCode <= 57) {
  
 } else {
  event.returnValue = false;
 }
}



//--> 문자열이 영문/숫자 조합인지 확인하는 함수
function checkAlpahNum(str) {
	 EngStr = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	 NumStr = "1234567890";
	 var HoldEng = false;
	 var HoldNum = false;
	 for (i=0 ; i<EngStr.length ; i++) {
		for (j=0 ; j<str.length ; j++) {
			if (EngStr.substring(i, i+1) == str.substring(j, j+1) ) {
				HoldEng = true;
			}
		}
	}

  for (i=0 ; i<NumStr.length ; i++) {
		for (j=0 ; j<str.length ; j++) {
			if (NumStr.substring(i, i+1) == str.substring(j, j+1) ) {
				HoldNum = true;
			}
		}
	}

  if (HoldEng && HoldNum)
   return true;
  else
   return false;
}



// 특수문자체크
function htmlspecialchars(obj){
	var strobj = obj;
	re = /[~!@\#$%^&*\()\-=+_\:/;`']/gi;
	if(re.test(strobj.value)){
		strobj.value = strobj.value.replace(re,"");
		alert('특수문자는 사용할 수 없습니다.');
		return;
	}
}

function checkSpecialchars(obj){
	var val = obj.value;
	var sp_char = " !@#$%^&*()_-+|/;:,.?`~{}[]ㄱㄴㄷㄹㅁㅂㅅㅇㅈㅊㅋㅌㅍㅎㅏㅑㅓㅕㅗㅛㅜㅠㅣㅡㅐㅔㅒㅖㄲㅆㅃㅉㄸ'"; 	 

	for(var i = 0; i < val.length;i++)
	{

		if(	sp_char.indexOf(val.charAt(i)) != -1)
		{ 
			alert("한글, 특수문자, 공백은 입력 할 수 없습니다.");
			obj.select();								
			return false;
		}
	}
	check = /[ㄱ-ㅎ|ㅏ-ㅣ|가-힝]/;
	if(check.test(val)) {
		alert("한글, 특수문자, 공백은 입력 할 수 없습니다.");
		obj.select();
		return false;
	}
}


// 자바스크립트 숫자체크 및 콤마찍기
function replaceComma(str) { // 콤마 없애기 
  while(str.indexOf(",") > -1) { 
   str = str.replace(",", ""); 
  } 
  return str; 
} 

// 자바스크립트 숫자체크 및 콤마찍기
function numChk(num){
  
  var rightchar = replaceComma(num.value);
  var moneychar = "";

  for(index = rightchar.length-1; index>=0; index--){
     splitchar = rightchar.charAt(index);
     if (isNaN(splitchar)) {
    alert(splitchar +"는 숫자가 아닙니다. \n다시 입력해주세요");
    num.value = "";
    num.focus();
    return;
     }
     moneychar = splitchar+moneychar;
     if(index%3==rightchar.length%3&&index!=0){ moneychar=','+moneychar; }
  }
  num.value = moneychar;
}


function display_comma(value) {
    var src;
    var i;
    var factor;
    var su;
    var Spacesize = 0;
    
    var String_val = value.toString();
    
    factor = String_val.length % 3;
    su = (String_val.length - factor) /3;
    src = String_val.substring(0,factor);

    for(i=0; i<su ; i++)
    {
       if ((factor==0)&&(i==0))// " XXX "の場合
        {
             src += String_val.substring(factor+(3*i), factor+3+(3*i));
        }
        else 
        {
            if ( String_val.substring(factor+(3*i) - 1, factor+(3*i)) != "-" ) src +=",";
            src += String_val.substring(factor+(3*i), factor+3+(3*i));
        }
    }
    return src;
}
    
function reduce_comma(value) {
    var x, ch;
    var i=0;
    var newVal="";
    for(x=0; x <value.length ; x++){
        ch=value.substring(x,x+1);
        if(ch != ",")  newVal += ch;
    }
    return newVal;
}





function stripHTMLtag(string) {
   var objStrip = new RegExp();
   objStrip = /[<][^>]*[>]/gi;
   return string.replace(objStrip, "");
}


// 널 체크
function nullCheck(obj,msg){
  if(!trim(obj.value)){
    alert(msg);
    obj.focus();
    return false;
  }
}


// 길이 체크
function lengthCheck(obj,min, max){
	str = trim(obj.value);
	if(str.length < min){
		alert(min + "자 이상 입력하셔야 합니다.");
	    obj.focus();
		return false;
	}
	if(str.length > max){
		alert(max + "자 이하로 입력하셔야 합니다.");
	    obj.focus();
		return false;
	}
}


//--> 아이디체크 함수  
function checkId(obj){
	var str = obj.value;
  if(!trim(str)){
    alert("아이디를 입력하세요.");
		obj.focus();
    return false;
  }else{
		if(str.length < 4 || str.length > 16){
			alert("아이디는 4자리부터 16자리까지의 영문과 숫자의 조합이어야 합니다.");
			obj.focus();
			return false;
		}
//		if(checkAlpahNum(str) == false){
//			alert('아이디는 영문과 숫자조합으로 사용하실 수 있습니다.');
//			obj.focus();
//			return false;
//		}	
	}
} 

//--> 비밀번호 체크
function checkPassword(obj1, obj2)
{
	if(!trim(obj1.value)){
		alert('비밀번호를 입력하세요.');
		obj1.focus();
		return false;
	}

	if(obj1.value.length < 4 || obj1.value.length > 12 ){
		alert('비밀번호는 4자리이상 12자리 이내, 영문숫자조합으로 입력하세요.');
		obj1.focus();
		return false;
	}

	if(checkAlpahNum(obj1.value) == false){
		alert('영문과 숫자조합으로 입력하세요.');
		obj1.focus();
		return false;
	}	

	if(!trim(obj2.value)){
		alert('비밀번호 확인을 입력하세요.');
		obj2.focus();
		return false;
	}

	if(trim(obj1.value) != trim(obj2.value)){
		alert("비밀번호가 동일하지 않습니다");
		obj1.focus();
		return false;
	}
}

//--> 주민등록번호체크 함수  
function checkJumin(obj1, obj2){
	var str_serial1 = trim(obj1.value);
	var str_serial2 = trim(obj2.value);
  if (str_serial1.length == ""){
    alert("주민등록번호를 입력해주세요.");
    obj1.focus();
    return false;
  }
  else if (str_serial2.length == ""){
    alert("주민등록번호를 입력해주세요.");
    obj2.focus();
    return false;
  }

  if (str_serial1.length != 6){
    alert("올바른 주민등록번호를 입력해주세요.");
    obj1.focus();
    return false;
  }
  else if (str_serial2.length != 7){
    alert("올바른 주민등록번호를 입력해주세요.");
    obj2.focus();
    return false;
  }
  else {
    var digit=0;
    for (var i=0;i<str_serial1.length;i++){
      var str_dig=str_serial1.substring(i,i+1);
      if (str_dig<'0' || str_dig>'9'){ 
          digit=digit+1 ;
      }
    }

    if ((str_serial1 == '') || ( digit != 0 )){
      alert('잘못된 주민등록번호입니다.\n\n다시 확인하시고 입력해 주세요.');
      obj1.focus();
      return false;   
    }

    var digit1=0;
    for (var i=0;i<str_serial2.length;i++){
      var str_dig1=str_serial2.substring(i,i+1);
      if (str_dig1<'0' || str_dig1>'9'){ 
          digit1=digit1+1 ;
      }
    }

    if ((str_serial2 == '') || ( digit1 != 0 )){
      alert('잘못된 주민등록번호입니다.\n\n다시 확인하시고 입력해 주세요.');
      obj2.focus();
      return false;   
    }

    if (str_serial1.substring(2,3) > 1){
      alert('잘못된 주민등록번호입니다.\n\n다시 확인하시고 입력해 주세요.');
      obj1.focus();
      return false;   
    }

    if (str_serial1.substring(4,5) > 3){
      alert('잘못된 주민등록번호입니다.\n\n다시 확인하시고 입력해 주세요.');
      obj1.focus();
      return false;   
    } 

    if (str_serial2.substring(0,1) > 4 || str_serial2.substring(0,1) == 0){
      alert('잘못된 주민등록번호입니다.\n\n다시 확인하시고 입력해 주세요.');
      obj2.focus();
      return false;   
    }

    var a1=str_serial1.substring(0,1);
    var a2=str_serial1.substring(1,2);
    var a3=str_serial1.substring(2,3);
    var a4=str_serial1.substring(3,4);
    var a5=str_serial1.substring(4,5);
    var a6=str_serial1.substring(5,6);
    
    var check_digit=a1*2+a2*3+a3*4+a4*5+a5*6+a6*7;

    var b1=str_serial2.substring(0,1);
    var b2=str_serial2.substring(1,2);
    var b3=str_serial2.substring(2,3);
    var b4=str_serial2.substring(3,4);
    var b5=str_serial2.substring(4,5);
    var b6=str_serial2.substring(5,6);
    var b7=str_serial2.substring(6,7);
    
    var check_digit=check_digit+b1*8+b2*9+b3*2+b4*3+b5*4+b6*5 ;
    
    check_digit = check_digit%11;
    check_digit = 11 - check_digit;
    check_digit = check_digit%10;

    if (check_digit != b7){
      alert('잘못된 주민등록번호입니다.\n\n다시 확인하시고 입력해 주세요.');
      obj2.focus();
      return false;   
    }
  }
  return true;
}

//--> 사업자등록번호 체크
function checkBizNo(obj1, obj2, obj3) { 
	var biz1 = obj1.value;
	var biz2 = obj2.value;
	var biz3 = obj3.value;
	if(!trim(obj1.value)){
		alert("사업자등록번호를 입력하세요.");
		obj1.focus();
		return false;
	}
	if(!trim(obj2.value)){
		alert("사업자등록번호를 입력하세요.");
		obj2.focus();
		return false;
	}
	if(!trim(obj3.value)){
		alert("사업자등록번호를 입력하세요.");
		obj3.focus();
		return false;
	}
	bizID = biz1+biz2+biz3;
	if(bizID.length != 10){
		alert("사업자등록번호가 올바르지 않습니다.");
		obj1.focus();
		return false;
	}
	// bizID는 숫자만 10자리로 해서 문자열로 넘긴다. 
	var checkID = new Array(1, 3, 7, 1, 3, 7, 1, 3, 5, 1); 
	var tmpBizID, i, chkSum=0, c2, remander; 
	bizID = bizID.replace(/-/gi,''); 

	for (i=0; i<=7; i++) chkSum += checkID[i] * bizID.charAt(i); 
	c2 = "0" + (checkID[8] * bizID.charAt(8)); 
	c2 = c2.substring(c2.length - 2, c2.length); 
	chkSum += Math.floor(c2.charAt(0)) + Math.floor(c2.charAt(1)); 
	remander = (10 - (chkSum % 10)) % 10 ; 

  if (Math.floor(bizID.charAt(9)) == remander) {
		return true ; // OK! 
	}else{
		alert("올바른 사업자등록번호를 입력하세요.");
		obj1.focus();
		return false; 
	}
} 

//--> 이메일 체크
function checkEmail(obj1, obj2, obj3)
{
	if(!trim(obj1.value)){
		alert('이메일을 입력하세요.');
		obj1.focus();
		return false;
	}

	if(obj3.value == "00"){
		alert("도메인을 선택하세요.");
		obj3.focus();
		return false;
	}else if(obj3.value == "99"){
		if(!trim(obj2.value)){
			alert('이메일을 입력하세요.');
			obj2.focus();
			return false;
		}else{
			email = obj1.value + "@" + obj2.value;	
		}
	}else{
		email = obj1.value+"@" + obj3.value;	
	}
	
	if(!isValidEmail(email)){
		alert("이메일이 잘못된 형식입니다.");
		obj2.focus();
		return false;
	}
}

//--> 이메일 체크
function onChangeEmail(obj1, obj2, obj3){
	var frm = document.hform;
	var emailId = obj1;
	var emailInput = obj2;
	var emailDomain = obj3;
	if(emailDomain.options[emailDomain.selectedIndex].value == '00'){
		emailInput.disabled = true;
		emailInput.value = "";
	}else if(emailDomain.options[emailDomain.selectedIndex].value == '99'){
		emailInput.disabled = false;
		emailInput.value = "";
		emailInput.focus();
	} else{
		emailInput.disabled = true;
		emailInput.value = emailDomain.options[emailDomain.selectedIndex].value;
	}
}

function isValidEmail(mail){

  var t = escape(mail);
  if(t.match(/^(\w+)@(\w+)[.](\w+)$/ig) == null && t.match(/^(\w+)@(\w+)[.](\w+)[.](\w+)$/ig) == null){
	return false;
  } else {
    return true;
  }
}


function setup(src){
	popup_Open(src,"850","600");
}