<?
	if(!defined("_g_board_include_")) exit; 
	require_once "../include/_header.inc.php";

	$req['Depth1']	  = Request('depth1');
	$req['Depth2']	  = Request('depth2');
	$req['Depth3']	  = Request('depth3');
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;
	if($req['idx']){
		$token = new_token($Board['board_id']);

		$mode = "updateData";
		$Value = $db -> SelectOne("select *  from ".$Board['table_board']." where BoardID = '".$Board['board_id']."' and idx = ".$req['idx']);
		if(!$Value)	locationReplace($Board['Link']);	
	}else{
		$token = new_token($Board['board_id']);
		$mode = "newData";
	}

?>
<script type="text/javascript" src="http://cdn.jquerytools.org/1.2.5/all/jquery.tools.min.js"></script>
<script type="text/javascript">
$(function() {

	// if the function argument is given to overlay,
	// it is assumed to be the onBeforeLoad event listener
	$("a[rel]").overlay({
		fixed : false, 
		effect: 'myEffect',

		mask: {

			// you might also consider a "transparent" color for the mask
			color: '#999',

			// load mask a little faster
			loadSpeed: 200,

			// very transparent
			opacity: 0.7
		},




		onBeforeLoad: function() {

			// grab wrapper element inside content
			var wrap = this.getOverlay().find(".contentWrap");

			// load the page specified in the trigger
			wrap.load(this.getTrigger().attr("href"));
		},

		onLoad: function(){
			var obj = this;
			$(".close2").click(function(){
				obj.close();
			});
		}

	});
});

// adds an effect called "myEffect" to the overlay
$.tools.overlay.addEffect("myEffect", function(position, done) {

      /*
        - 'this' variable is a reference to the overlay API
        - here we use jQuery's fadeIn() method to perform the effect
      */
      this.getOverlay().css(position).fadeIn(this.getConf().speed, done);
   },

   // close function
   function(done) {

      // fade out the overlay
      this.getOverlay().fadeOut(this.getConf().closeSpeed, done);
			//location.href = location.href;
   }
);
</script>
<script type="text/javascript">
  function Category1Select(){
//   $("select#Category1").change(function(){
     var Category1Value = $('#Category1 option:selected').val();
     if( Category1Value ){
     $("#Category1Info").html('');
     $("#Category2Info").html('');
     $("#Category3Info").html('');
     $("input[name=am]").val('Depth1Select');
      $.ajax({
          type : "POST" //"POST", "GET"
          , async : true //true, false
          , url : "<?=$Board['Link']?>?at=dataprocess&am=Depth1Select" //Request URL
          , dataType : "json" //전송받을 데이터의 타입

                                     //"xml", "html", "script", "json" 등 지정 가능

                                     //미지정시 자동 판단
          , timeout : 30000 //제한시간 지정
          , cache : false  //true, false
          , data : $("#boardform").serialize() //서버에 보낼 파라메터

                           //form에 serialize() 실행시 a=b&c=d 형태로 생성되며 한글은 UTF-8 방식으로 인코딩

                           //"a=b&c=d" 문자열로 직접 입력 가능
          , contentType: "application/x-www-form-urlencoded; charset=UTF-8"
          , error : function(request, status, error) {
           //통신 에러 발생시 처리
           alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
          }
          , success : function(response, status, request) {
           //통신 성공시 처리
           var options = '';
           options = '<option value="">-- 1차를 선택하세요. --</option>';        
           $("#Category2").html(options); 
           options = '<option value="">-- 2차를 선택하세요. --</option>';        
           $("#Category3").html(options); 

           if(response){
             $("#btn_make_cate2").fadeIn();
             $("#btn_make_cate3").hide();
             var itemcount = 0;
             category1info = "<img src='../images/icon/arrow.png'> ";
             category1info += "<input type='text' id='Name1' name='Name1' value='"+$("select#Category1 option:selected").text()+"' class='input' style='width:120px'> ";
             category1info += "<img src='../images/btn_s/btn_modify.gif' onclick='Category1Update();' class='pointer'>";
             if(response.result == "YES"){
               j = response.item;
               itemcount = j.length;
               options = '';
               for (var i = 0; i < itemcount; i++) {
                options += '<option value="' + j[i].value + '">' + j[i].title + '</option>';
               }
               $("#Category2").html(options);
             }else{
               options = '<option value="">-- 등록된 항목이 없습니다. --</option>';        
               $("#Category2").html(options);              
             }
            if(response.count == 0 && itemcount == 0){
             category1info += " <img src='../images/btn_s/btn_del.gif' onclick='Category1Delete();' class='pointer'>";
            }
            $("#Category1Info").html(category1info);   
            }
          }
          , beforeSend: function() {
           //통신을 시작할때 처리
           $('#ajax_indicator').show().fadeIn('fast'); 
          }
          , complete: function() {
           //통신이 완료된 후 처리
           $('#ajax_indicator').fadeOut();
          }
      });
     } // if( $(this).val() ){
//   });   
  }





  function Category2Select(){
     var Category2Value = $('#Category2 option:selected').val();
     var Category2Text = $('#Category2 option:selected').text();
//   $("select#Category2").change(function(){
     if( Category2Value ){
     $("#Category2Info").html('');
     $("#Category3Info").html('');
     $("input[name=am]").val('Depth2Select');
      $.ajax({
          type : "POST" //"POST", "GET"
          , async : true //true, false
          , url : "<?=$Board['Link']?>?at=dataprocess&am=Depth2Select" //Request URL
          , dataType : "json" //전송받을 데이터의 타입

                                     //"xml", "html", "script", "json" 등 지정 가능

                                     //미지정시 자동 판단
          , timeout : 30000 //제한시간 지정
          , cache : false  //true, false
          , data : $("#boardform").serialize() //서버에 보낼 파라메터

                           //form에 serialize() 실행시 a=b&c=d 형태로 생성되며 한글은 UTF-8 방식으로 인코딩

                           //"a=b&c=d" 문자열로 직접 입력 가능
          , contentType: "application/x-www-form-urlencoded; charset=UTF-8"
          , error : function(request, status, error) {
           //통신 에러 발생시 처리
           alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
          }
          , success : function(response, status, request) {
           //통신 성공시 처리
           var options = '';
           options = '<option value="">-- 2차를 선택하세요. --</option>';        
           $("#Category3").html(options); 
           if(response){
             $("#btn_make_cate3").fadeIn();

             var itemcount = 0;
             category1info = "<img src='../images/icon/arrow.png'> ";
             category1info += "<input type='text' id='Name2' name='Name2' value='"+Category2Text+"' class='input' style='width:120px'> ";
             category1info += "<img src='../images/btn_s/btn_modify.gif' onclick='Category2Update();' class='pointer'>";
             if(response.result == "YES"){
               j = response.item;
               itemcount = j.length;
               options = '';
               for (var i = 0; i < itemcount; i++) {
                options += '<option value="' + j[i].value + '">' + j[i].title + '</option>';
               }
               $("#Category3").html(options);
             }else{
               options = '<option value="">-- 등록된 항목이 없습니다. --</option>';        
               $("#Category3").html(options);              
             }
            if(response.count == 0 && itemcount == 0){
             category1info += " <img src='../images/btn_s/btn_del.gif' onclick='Category2Delete();' class='pointer'>";
            }
            $("#Category2").val(Category2Value).attr("selected","selected");
            $("#Category2Info").html(category1info);             
            }
          }
          , beforeSend: function() {
           //통신을 시작할때 처리
           $('#ajax_indicator').show().fadeIn('fast'); 
          }
          , complete: function() {
           //통신이 완료된 후 처리
           $('#ajax_indicator').fadeOut();
          }
      });
     } // if( $(this).val() ){
//   });   
  }






$(function(){






   $("select#Category3").change(function(){
     $("#Category3Info").html('');
     if( $(this).val() ){
     $("input[name=am]").val('Depth3Select');
      $.ajax({
          type : "POST" //"POST", "GET"
          , async : true //true, false
          , url : "<?=$Board['Link']?>?at=dataprocess&am=Depth3Select" //Request URL
          , dataType : "json" //전송받을 데이터의 타입

                                     //"xml", "html", "script", "json" 등 지정 가능

                                     //미지정시 자동 판단
          , timeout : 30000 //제한시간 지정
          , cache : false  //true, false
          , data : $("#boardform").serialize() //서버에 보낼 파라메터

                           //form에 serialize() 실행시 a=b&c=d 형태로 생성되며 한글은 UTF-8 방식으로 인코딩

                           //"a=b&c=d" 문자열로 직접 입력 가능
          , contentType: "application/x-www-form-urlencoded; charset=UTF-8"
          , error : function(request, status, error) {
           //통신 에러 발생시 처리
           alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
          }
          , success : function(response, status, request) {
           //통신 성공시 처리
           if(response){
             var itemcount = 0;
             category1info = "<img src='../images/icon/arrow.png'> ";
             category1info += "<input type='text' id='Name3' name='Name3' value='"+$("select#Category3 option:selected").text()+"' class='input' style='width:120px'> ";
             category1info += "<img src='../images/btn_s/btn_modify.gif' onclick='Category3Update();' class='pointer'>";
             if(response.count == 0){
               category1info += " <img src='../images/btn_s/btn_del.gif' onclick='Category3Delete();' class='pointer'>";
             }
             $("#Category3Info").html(category1info);             
            }
          }
          , beforeSend: function() {
           //통신을 시작할때 처리
           $('#ajax_indicator').show().fadeIn('fast'); 
          }
          , complete: function() {
           //통신이 완료된 후 처리
           $('#ajax_indicator').fadeOut();
          }
      });
     } // if( $(this).val() ){
   });   

  var Depth1 = "<?=$req['Depth1']?>";
  var Depth2 = "<?=$req['Depth2']?>";
  var Depth3 = "<?=$req['Depth3']?>";

   $("#btn_make_cate2").hide();
   $("#btn_make_cate3").hide();
   $("#Category1").val("<?=$req['Depth1']?>").attr("selected","selected");
   Category1Select();

   if(Depth2){
     setTimeout(function(){ 
      $("#Category2").val("<?=$req['Depth2']?>").attr("selected","selected");
      Category2Select();    
     },500); 
     if(Depth3){
       setTimeout(function(){ 
        $("#Category3").val("<?=$req['Depth3']?>").attr("selected","selected");
       },500); 
     }
   }



  })


	function Category1Update(){
   var Category1Value = $('#Category1 option:selected').val();
 	 $.ajax({
		 type: "POST",
		 url: "<?=$Board['Link']?>?at=dataprocess",
     dataType : "json",
		 data: "am=Category1Update&depth1="+$('#Category1 option:selected').val()+"&Name="+$('#Name1').val(),
		 success: function(response){
       //통신 성공시 처리
       var options = '';
       options = '<option value="">-- 2차를 선택하세요. --</option>';     
       $("#Category3").html(options); 
       if(response){
         if(response.result == "YES"){
           j = response.item;
           var options = '';
           for (var i = 0; i < j.length; i++) {
            options += '<option value="' + j[i].value + '">' + j[i].title + '</option>';
           }
           $("#Category1").html(options);            
           $("#Category1").val(Category1Value).attr("selected","selected");
            alert("수정되었습니다.");
         }
          if(response.result == "EXISTS"){
            alert("같은이름의 카테고리가 존재합니다.");
          }
       }
		 }
	 });	
	}
	function Category1Delete(){
   if(confirm("정말로 삭제하시겠습니까?")){
     var Category1Value = $('#Category1 option:selected').val();
     $.ajax({
       type: "POST",
       url: "<?=$Board['Link']?>?at=dataprocess",
       dataType : "json",
       data: "am=Category1Delete&depth1="+$('#Category1 option:selected').val()+"&Name="+$('#Name1').val(),
       success: function(response){
         //통신 성공시 처리
         if(response){
           if(response.result == "YES"){
             j = response.item;
             var options = '';
             for (var i = 0; i < j.length; i++) {
              options += '<option value="' + j[i].value + '">' + j[i].title + '</option>';
             }
             $("#Category1").html(options);            
             $("#Category1").val(Category1Value).attr("selected","selected");
             alert("삭제되었습니다.");
           }
         }
       }
     });	
   }
	}




	function Category2Update(){
   var Category2Value = $('#Category2 option:selected').val();
 	 $.ajax({
		 type: "POST",
		 url: "<?=$Board['Link']?>?at=dataprocess",
     dataType : "json",
		 data: "am=Category2Update&depth1="+$('#Category1 option:selected').val()+"&depth2="+$('#Category2 option:selected').val()+"&Name="+$('#Name2').val(),
		 success: function(response){
       //통신 성공시 처리
       var options = '';
       if(response){
         if(response.result == "YES"){
           j = response.item;
           var options = '';
           for (var i = 0; i < j.length; i++) {
            options += '<option value="' + j[i].value + '">' + j[i].title + '</option>';
           }
           $("#Category2").html(options);            
           $("#Category2").val(Category2Value).attr("selected","selected");
           alert("수정되었습니다.");
         }
          if(response.result == "EXISTS"){
            alert("같은이름의 카테고리가 존재합니다.");
          }
       }
		 }
	 });	
	}
	function Category2Delete(){
   if(confirm("정말로 삭제하시겠습니까?")){
     var Category2Value = $('#Category2 option:selected').val();
     $.ajax({
       type: "POST",
       url: "<?=$Board['Link']?>?at=dataprocess",
       dataType : "json",
       data: "am=Category2Delete&depth1="+$('#Category1 option:selected').val()+"&depth2="+$('#Category2 option:selected').val()+"&Name="+$('#Name2').val(),
       success: function(response){
         //통신 성공시 처리
         if(response){
           if(response.error == "N"){
              var options = '';
             if(response.result == "YES"){
               j = response.item;
               for (var i = 0; i < j.length; i++) {
                options += '<option value="' + j[i].value + '">' + j[i].title + '</option>';
               }
             }
             $("#Category2").html(options);            
             $("#Category2Info").html('');
             alert("삭제되었습니다.");
          }
         }
       }
     });	
   }
	}


	function Category3Update(){
   var Category3Value = $('#Category3 option:selected').val();
 	 $.ajax({
		 type: "POST",
		 url: "<?=$Board['Link']?>?at=dataprocess",
     dataType : "json",
		 data: "am=Category3Update&depth1="+$('#Category1 option:selected').val()+"&depth2="+$('#Category2 option:selected').val()+"&depth3="+$('#Category3 option:selected').val()+"&Name="+$('#Name3').val(),
		 success: function(response){
       //통신 성공시 처리
       if(response){
         if(response.result == "YES"){
           j = response.item;
           var options = '';
           for (var i = 0; i < j.length; i++) {
            options += '<option value="' + j[i].value + '">' + j[i].title + '</option>';
           }
           $("#Category3").html(options);            
           $("#Category3").val(Category3Value).attr("selected","selected");
           alert("수정되었습니다.");
         }
          if(response.result == "EXISTS"){
            alert("같은이름의 카테고리가 존재합니다.");
          }
       }
		 }
	 });	
	}
	function Category3Delete(){
   var Category3Value = $('#Category3 option:selected').val();
   if(confirm("정말로 삭제하시겠습니까?")){
     $.ajax({
       type: "POST",
       url: "<?=$Board['Link']?>?at=dataprocess",
       dataType : "json",
       data: "am=Category3Delete&depth1="+$('#Category1 option:selected').val()+"&depth2="+$('#Category2 option:selected').val()+"&depth3="+$('#Category3 option:selected').val()+"&Name="+$('#Name3').val(),
       success: function(response){
         //통신 성공시 처리
         if(response){
           if(response.error == "N"){
              var options = '';
             if(response.result == "YES"){
               j = response.item;
               for (var i = 0; i < j.length; i++) {
                options += '<option value="' + j[i].value + '">' + j[i].title + '</option>';
               }
             }
             $("#Category3").html(options);            
             $("#Category3Info").html('');
             alert("삭제되었습니다.");
           }
         }
       }
     });	
   }
	}

  function frmcheck(){
    return false;
  
  }
</script>
<style>


</style>
</head>
<?	require_once "../include/_body_top.inc.php"; ?>



	
			<!-- list -->
			<form name="boardform" id="boardform"  method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="<?=$Board['Link']?>?at=dataprocess">
			<input type="hidden" name="token" value="<?=$token?>">
			<input type="hidden" name="Html"  value="Y">

			<input type="hidden" name="idx" value="<?=$req['idx']?>">
			<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
			<input type="hidden" name="am">
			<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">



      <table width="780" cellspacing="0" cellpadding="0" class="viewtable" style="width:780px">
				<col width="260"></col>
				<col width="260"></col>
				<col width="260"></col>
        <tr>
          <th class="tableth center">1차 <a href='<?=$Board['Link']?>?at=add&category=depth1&gubun=<?=$req['Gubun']?>' rel="#overlay"><img src="../images/btn_make.gif" id="btn_make_cate1"></a></th>
          <th class="tableth center">2차 <a href='<?=$Board['Link']?>?at=add&category=depth2&gubun=<?=$req['Gubun']?>' rel="#overlay"><img src="../images/btn_make.gif" id="btn_make_cate2"></a></th>
          <th class="tableth center last">3차 <a href='<?=$Board['Link']?>?at=add&category=depth3&gubun=<?=$req['Gubun']?>' rel="#overlay"><img src="../images/btn_make.gif" id="btn_make_cate3"></a></th>
        </tr>
        <tr>
          <td class="tabletd" style="vertical-align:top; padding:5px">
					<select name='Depth1'		id="Category1" size="20" style='width:250px' onchange="Category1Select(this.value);">
					<?
						$Depth1 = $db -> SelectList("Select * from  ".$Board['table_board']." Where Depth2 = '00' and Depth3 = '000' and Gubun='".$req['Gubun']."' order by SortNum");

						if($Depth1){
							foreach($Depth1 as $key => $value){
								echo "<option value='".$value['Depth1']."'>".$value['Name']." </option>";
                if($value['Depth1'] == $req['Depth1']){
                  $Depth1Value = $value['Depth1'];
                  $Depth1Name  = $value['Name'];
                }
							}
						}else{
							echo "<option value=''>-- 등록된 항목이 없습니다. --</option>";
						}
					?>
					</select>
          <div id="Category1Info"></div>
          </td>
          <td class="tabletd" style="vertical-align:top; padding:5px">
					<select name='Depth2'		id='Category2' size="20" style='width:250px' onchange="Category2Select(this.value);">
					<?
            if(!$req['Depth1']) {
              echo "<option value=''>-- 1차를 선택하세요. --</option>";
            }else{
            
              $Depth2 = $db -> SelectList("Select * from  ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 <> '00' and Depth3 = '000' and Gubun='".$req['Gubun']."' order by SortNum");
              if($Depth2){
                foreach($Depth2 as $key => $value){
                  if($req['Depth2'] == $value['Depth2']) echo "<option value='".$value['Depth2']."' selected>".$value['Name']."</option>";
                  else echo "<option value='".$value['Depth2']."'>".$value['Name']." </option>";
                }
              }else{
                echo "<option value=''>-- 등록된 항목이 없습니다. --</option>";
              }
            }
					?>
					</select>
          <div id="Category2Info"></div>
          </td>
          <td class="tabletd" style="vertical-align:top; padding:5px">
					<select name='Depth3'		id='Category3' size="20" style='width:250px'>
					<?
            if(!$req['Depth2']){
              echo "<option value=''>-- 2차를 선택하세요. --</option>";
            }else{
              $Depth3 = $db -> SelectList("Select * from  ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 = '".$req['Depth2']."' and Depth3 <> '000' and Gubun='".$req['Gubun']."' order by SortNum ");
              if($Depth3){
                foreach($Depth3 as $key => $value){
                  echo "<option value='".$value['Depth3']."'>".$value['Name']."</option>";
                }
              }else{
                echo "<option value=''>-- 등록된 항목이 없습니다. --</option>";
              }
            }
					?>
					</select>
          <div id="Category3Info"></div>
          </td>
        </tr>
      </table>







			</form>
			<!--// list -->



		<!-- overlayed element -->
		<div class="overlay" id="overlay">
			<!-- the external content is loaded inside this tag -->
			<div class="contentWrap"></div>
		</div>


<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>

