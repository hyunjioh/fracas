nhn.husky.SE_ImageUpload = jindo.$Class({
    name : "SE_ImageUpload",

    $init : function(oAppContainer){
       this._assignHTMLObjects(oAppContainer);
    },

    _assignHTMLObjects : function(oAppContainer){
       this.oImageUploadLayer = cssquery.getSingle("DIV.husky_seditor_imgupload_layer", oAppContainer);
    },

    $ON_MSG_APP_READY : function(){
       this.oApp.exec("REGISTER_UI_EVENT", ["imgupload", "click", "SE_TOGGLE_IMAGEUPLOAD_LAYER"]);
    },

    $ON_SE_TOGGLE_IMAGEUPLOAD_LAYER : function(){
       this.oApp.exec("TOGGLE_TOOLBAR_ACTIVE_LAYER", [this.oImageUploadLayer]);
       imgUploadFrame.location = "popup/image.php?bid="+ this.oApp.BoardID +"&edid=" + this.oApp.sAppId;
    },

	$ON_PASTE_NOW_DATE : function(){
		this.oApp.exec("PASTE_HTML", [new Date()]);
	}
});