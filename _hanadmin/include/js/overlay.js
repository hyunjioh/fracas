
$(function() {
  // if the function argument is given to overlay,
  // it is assumed to be the onBeforeLoad event listener
  $(".overlay").overlay({
      // common configuration for each overlay            
      oneInstance: false,            
      closeOnClick: false,
	  closeOnEsc : false,
      mask: '#666666',
				
	// load it immediately after the construction  
	// load: true,


	//top  :  posY,
	//left :  posX,
	onBeforeLoad: function() {
			// grab wrapper element inside content
			var wrap = this.getOverlay().find(".contentWrap");
			// load the page specified in the trigger
			wrap.load(this.getTrigger().attr("href"));
	},
	onLoad: function(){

	},
    onClose: function() {

    }
  });


  $(".oncloseact_overlay").overlay({
      // common configuration for each overlay            
      oneInstance: false,            
      closeOnClick: false,
	  closeOnEsc : false,
      mask: '#666666',
				
	// load it immediately after the construction  
	// load: true,


	//top  :  posY,
	//left :  posX,
	onBeforeLoad: function() {
			// grab wrapper element inside content
			var wrap = this.getOverlay().find(".contentWrap");
			// load the page specified in the trigger
			wrap.load(this.getTrigger().attr("href"));
	},
	onLoad: function(){

	},
    onClose: function() {
		location.reload();
    }
  });

});

// close all overlays
function closeAll() {  
	$(".overlay").each(function() {    
		$(this).overlay().close();  
	});
}
