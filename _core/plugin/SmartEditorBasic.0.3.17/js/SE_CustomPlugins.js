//   파일업로드 클레스 추가
nhn.husky.SE_ImageUpload = $Class({
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
    }
});


nhn.husky.SE_SyntaxHighlight = $Class({
    name : "SE_SyntaxHighlight",

    $init : function(oAppContainer){
       this._assignHTMLObjects(oAppContainer);
    },

    _assignHTMLObjects : function(oAppContainer){
       this.oSyntaxHighlightLayer = cssquery.getSingle("DIV.husky_seditor_code_layer", oAppContainer);
    },
    $ON_MSG_APP_READY : function(){
       this.oApp.exec("REGISTER_UI_EVENT", ["code", "click", "SE_TOGGLE_SYNTAXHIGHLIGHT_LAYER"]);
    },
    $ON_SE_TOGGLE_SYNTAXHIGHLIGHT_LAYER : function(){
       this.oApp.exec("TOGGLE_TOOLBAR_ACTIVE_LAYER", [this.oSyntaxHighlightLayer]);
       codeFrame.location = "popup/code.php?bid="+ this.oApp.BoardID +"&edid=" + this.oApp.sAppId;
    }
});

function SE_RegisterCustomPlugins(oEditor, elAppContainer){
    oEditor.registerPlugin(new nhn.husky.SE_ImageUpload(elAppContainer));
    oEditor.registerPlugin(new nhn.husky.SE_SyntaxHighlight(elAppContainer));
}

