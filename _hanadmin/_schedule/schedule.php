<?
	if(!defined("_g_board_include_")) exit; 
?>
<? include "../include/_header.inc.php"; ?>
<link rel='stylesheet' type='text/css' href='<?=_CORE_?>/plugin/fullcalendar-1.5.3/fullcalendar/fullcalendar.css' />
<link rel='stylesheet' type='text/css' href='<?=_CORE_?>/plugin/fullcalendar-1.5.3/fullcalendar/fullcalendar.print.css' media='print' />
<script type='text/javascript' src='<?=_CORE_?>/plugin/fullcalendar-1.5.3/fullcalendar/fullcalendar.min.js'></script>
<link rel='stylesheet' type='text/css' href='<?=_CORE_?>/plugin/fullcalendar-1.5.3/demos/cupertino/theme.css' />

<script type='text/javascript'>

$(document).ready(function() {
  fullcalendar();
});

function fullcalendar(){
  $('#calendar').fullCalendar({
    theme: true,
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay'
    },
		editable: true,  
    /*
    editable: false,
    droppable: false,
    allDay: false,
    */
	
    events: function(start, end, callback) {
        $.ajax({
            url: './?at=json',
            dataType: 'json',
            data: {
                // our hypothetical feed requires UNIX timestamps
                start: Math.round(start.getTime() / 1000),
                end: Math.round(end.getTime() / 1000)
            },
            success: function(doc) {
              callback(doc);
            }
        });
    },

    eventResize: function( event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view ) { 
      // 날짜 수정

      $.ajax({
          type: 'POST'
          , async: true
          , dataType : "json" //전송받을 데이터의 타입
          , data : "idx="+event.id+"&dayp="+dayDelta+"&am=dateResize"
          , url: './?at=dataprocess'
          , beforeSend: function() {
          }
  				, success : function(response, status, request) {
             if(response.error == "N"){
                  $('#calendar').fullCalendar( 'destroy' );
                  fullcalendar();
             }else{
               alert(msg);
             }
          }
          , error: function(request, status, err) {
          }
          , complete: function() {
          }

      });    
    },
    
    eventDrop: function(event, delta) {
      //alert(event.title + ' was moved ' + delta + ' days\n' +					'(should probably update your database)');
      // 날짜 수정
      $.ajax({
          type: 'POST'
          , async: true
          , dataType : "json" //전송받을 데이터의 타입
          , data : "idx="+event.id+"&datep="+delta+"&am=dateMove"
          , url: './?at=dataprocess'
          , beforeSend: function() {
          }
  				, success : function(response, status, request) {
             if(response.error == "N"){
                $('#calendar').fullCalendar( 'destroy' );
                fullcalendar();
             }else{
               alert(msg);
             }
          }
          , error: function(request, status, err) {
          }
          , complete: function() {
          }

      });
    },
    
    loading: function(bool) {
      if (bool) $('#loading').show();
      else $('#loading').hide();
    }
    ,
    
    dayClick: function(date, allDay, jsEvent, view) {
        /*
        if (allDay) {
            alert('Clicked on the entire day: ' + date);
        }else{
            alert('Clicked on the slot: ' + date);
        }

        alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

        alert('Current view: ' + view.name);
        
        $(this).css('background-color', 'red'); // change the day's background color just for fun
        */

        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        m = m+1;
        if(m < 10) m = "0" + m;
        if(d < 10) d = "0" + d;
        schedule(y+"-"+m+"-"+d);
    }
  });
}

function schedule(val){
  url = './?at=info&date='+val;
  $(".overlay").attr("href",url).click();
}

function scheduleinfo(val){
  url = './?at=info&idx='+val;
  $(".overlay").attr("href",url).click();
}


</script>
<style>

/* overlay */
/* Login overlay */
.schedule_write_overlay {	
	background-color:#fff;
	border:10px solid #466aac;
    /* initially overlay is hidden */
    display:none;

    /*
      width after the growing animation finishes
      height is automatically calculated
      */
    width:600px;
  	height:290px;
	  margin:0 auto;
    /* some padding to layout nested elements nicely  */

    /* a little styling */
    font-size:12px;
}

/* default close button positioned on upper right corner */
.schedule_write_overlay .close {
    background-image:url(/images/overlay/close.png);
    position:absolute; right:5px; top:7px;
    cursor:pointer;
    height:18px;
    width:20px;
    z-index:3;
}


.schedule_write_overlay h2 {
  padding:0 0 15px 0;
  color:#fff;
  background-color:#466aac;
  font:bold 22px Malgun Gothic;
}

</style>
</head>
<?	require_once "../include/_body_top.inc.php"; ?>

<div id='calendar'></div>

<? include "../include/_body_bottom.inc.php"; ?>
<a href="#" rel="#schedule_write_overlay" class="overlay"></a>
<div class="schedule_write_overlay" id="schedule_write_overlay">
  <div class="contentWrap"></div>
</div>
<? include "../include/_footer.inc.php" ?>
