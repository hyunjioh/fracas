
function goPage(i){
	frm = $("input[name=pagenumber]").parent();
	$("input[name=pagenumber]").val(i);
	frm.submit();
}


function checkAll(){
	var allcheck = $("input[name=checkall]").is(":checked");
	$("input[name='gidx[]']").each(function(){

		if(allcheck){ 
			$(this).attr("checked","checked");
		}else{
			$(this).removeAttr('checked');
		}
				
	})
}


function checkDelete(){
	var f = document.lform;
	var checkLength = $("input[name='gidx[]']:checked").length;
	if(checkLength < 1){
		alert("선택된 항목이 없습니다.");
		return ;
	}

	if(confirm("정말로 삭제하시겠습니까?")){
		f.am.value = 'checkDelete';
		f.submit();
	}else{
		return;
	}
}
function checkDelete_2(){
	var f = document.lform;
	var checkLength = $("input[name='gOrderNum[]']:checked").length;
	if(checkLength < 1){
		alert("선택된 항목이 없습니다.");
		return ;
	}

	if(confirm("정말로 삭제하시겠습니까?")){
		f.am.value = 'checkDelete';
		f.submit();
	}else{
		return;
	}
}

function setDate(date,period, ptype){
	if(date){
	var eDate = date.split("-");   
  var year = eDate[0];
  var month = eDate[1]; 
	var day = eDate[2]; 

	var sdate = new Date();
	if(ptype == "Y"){
		sdate.setYear(sdate.getFullYear() - period) ;
	}
	if(ptype == "M"){
		sdate.setMonth(sdate.getMonth() - period) ;
	}
	if(ptype == "D"){
		sdate.setDate(sdate.getDate() - period);
	}


	var syear  = sdate.getFullYear();
	var smonth = sdate.getMonth()+1;
	var sday   = sdate.getDate();
	if(smonth < 10) smonth = "0"+smonth;
	if(sday < 10) sday = "0"+sday;
  var startdate = syear+"-"+smonth+"-"+sday;

	$("#startdate").val(startdate);
	$("#enddate").val(date);
	}else{
		$("#startdate").val('');
		$("#enddate").val('');	
	}
}


function setDate02(date,period, ptype){
	if(date){
	var eDate = date.split("-");   
  var year = eDate[0];
  var month = eDate[1]; 
	var day = eDate[2]; 

	var sdate = new Date();
	if(ptype == "Y"){
		sdate.setYear(sdate.getFullYear() - period) ;
	}
	if(ptype == "M"){
		sdate.setMonth(sdate.getMonth() - period) ;
	}
	if(ptype == "D"){
		sdate.setDate(sdate.getDate() - period);
	}


	var syear  = sdate.getFullYear();
	var smonth = sdate.getMonth()+1;
	var sday   = sdate.getDate();
	if(smonth < 10) smonth = "0"+smonth;
	if(sday < 10) sday = "0"+sday;
  var startdate = syear+"-"+smonth+"-"+sday;

	$("#startdate02").val(startdate);
	$("#enddate02").val(date);
	}else{
		$("#startdate02").val('');
		$("#enddate02").val('');	
	}
}

function goExcel(actUrl){
	var f = document.sfrm;
	f.action = actUrl;
	f.method = "post";
	f.submit();	
}

// This is a very simple demo that shows how a range of elements can
// be paginated.
// The elements that will be displayed are in a hidden DIV and are
// cloned for display. The elements are static, there are no Ajax 
// calls involved.

/**
 * Callback function that displays the content.
 *
 * Gets called every time the user clicks on a pagination link.
 *
 * @param {int} page_index New Page index
 * @param {jQuery} jq the container with the pagination links as a jQuery object
 */
function pageselectCallback(page_index, jq){
		to_page = page_index;
		$(".pagination a").click(function(){
			goPage(to_page+1);
			return false;
		});
		return false;
}

/** 
 * Initialisation function for pagination
 */
function initPagination(pagenum, pagelimit) {
		// count entries inside the hidden content
		var num_entries = jQuery('#total_entries').val();


		// Create content inside pagination element
		$("#Pagination").pagination(num_entries, {

				callback: pageselectCallback,
				current_page:pagenum,
				items_per_page:pagelimit // Show only one item per page
		});
 }




$(document).ready(function() {

	// 조회기간 설정 검색
	if($("#startdate").length > 0){
		$("#startdate").datepicker( {
			showOn: "button"
		});
		$("#enddate").datepicker( {
			showOn: "button"
		});
	}

	if($("#startdate02").length > 0){
		$("#startdate02").datepicker( {
			showOn: "button"
		});
		$("#enddate02").datepicker( {
			showOn: "button"
		});
	}
});