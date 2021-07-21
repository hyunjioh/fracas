// 필드들 초기화
function initArea()
{
	msg = document.smsfrm.SmsMsg.value;
	if(msg == "메세지를 입력하세요.")
		document.smsfrm.SmsMsg.value = "";
}

function sms_clear()
{
	document.smsfrm.reset();

}

// sms 창에 입력하는 데이터의 바이트길이 구하기
function cal_byte() {
	var tmpStr;
	var temp=0;
	var onechar;
	var tcount;
	tcount = 0;
	maxbyte = 80;
	aquery = document.smsfrm.SmsMsg.value;

	tmpStr = new String(aquery);
	temp = tmpStr.length;

	for (k=0;k<temp;k++)
	{
		onechar = tmpStr.charAt(k);

		if (escape(onechar).length > 4) {
			tcount += 2;
		}
		else if (onechar!='\r') {
			tcount++;
		}
	}

	document.smsfrm.msgByte.value = tcount;
	if(tcount>maxbyte) {
		reserve = tcount-maxbyte;
		alert("메시지 내용은 " + maxbyte + "바이트 이상은 전송하실수 없습니다.\r\n쓰신 메세지는 "+reserve+"바이트가 초과되었습니다.\r\n초과된 부분은 자동으로 삭제됩니다."); 
		cutText(maxbyte);
		return;
	}	
}

// 파라미터로 입력된 번호 삽입
function user_add(phoneNum) {
	//var phoneNum = document.visual_phone.recv_sms_hp.value;
	//받는 폰 번호 확인 추가
	if (phoneNum == "") {
		//alert("받는 번호를 입력하세요.");
		document.smsfrm.recv_sms_hp.focus();
		return;
	} else {		
		len = phoneNum.length;
		if ( (len != 10 ) && (len != 11 ) ) {
			//alert("받는 번호 ("+phoneNum+") 를 다시 입력해주세요");
			document.smsfrm.recv_sms_hp.focus();
			return;
		} else {
			// 사업자 번호 검사 && 무결성 검사 && 숫자만 있는지 검사
			if(checkNum(phoneNum) && checkIntegrity(phoneNum) && validNum(phoneNum))
			{
				list = document.smsfrm.tr_sms_list;
				list.options[list.options.length]  = new Option(phoneNum, phoneNum);
				document.smsfrm.recv_sms_hp.value = "";
			}
		}
	}
}

// 선택된 항목 삭제
function user_del(){
	list = document.smsfrm.tr_sms_list;
	selected = new Array(list.length);
	for (i = 0; i < list.length; i++) selected[i] = list[i].selected;
	for (i = selected.length - 1; i >= 0; i--) {
		if (selected[i]) {
			list[i] = null;
		}
	}
}

	// 입력하려는 번호의 사업자 번호가 올바른지 검사
function checkNum(num)
{
	vendorNum = num.substring(0,3);

	if(vendorNum == "010" || vendorNum == "011" || vendorNum == "016" || vendorNum == "017" || vendorNum == "018" || vendorNum == "019")
		return true;
	else
		return false;
}

// 입력하려는 번호가 리스트에 있는지 검사
function checkIntegrity(num)
{
	list = document.smsfrm.tr_sms_list;
	listLen = document.smsfrm.tr_sms_list.length;
	for(i = 0; i<listLen; i++)
	{
		if(list[i].value == num)
		return false;
	}
	return true;
}

// 숫자만 있는지 검사
function validNum(num)
{
	var isValid = true;
	var strLength = num.length;
	for ( i = 0 ; i < strLength ; i++)
	{
		ch = num.charAt(i);
		if (((ch >= '0') && (ch <= '9'))) 
			continue;
		else
		{
			isValid = false;
			break;
		}
	} 

	return isValid;
}


function cutText(maxbyte) {
	nets_check(document.smsfrm.SmsMsg.value, maxbyte);
}

function nets_check(aquery,max) {
	var tmpStr;
	var temp=0;
	var onechar;
	var tcount;
	tcount = 0;

	tmpStr = new String(aquery);
	temp = tmpStr.length;

	for(k=0;k<temp;k++)
	{
		onechar = tmpStr.charAt(k);

		if(escape(onechar).length > 4) {
			tcount += 2;
		}
		else if(onechar!='\r') {
			tcount++;
		}
		if(tcount>max) {
			tmpStr = tmpStr.substring(0,k);			
			break;
		}
	}
	
	if (max == 80) {
		document.smsfrm.SmsMsg.value = tmpStr;
		cal_byte(tmpStr);
	}
	return tmpStr;
}