//{
/**
 * @fileOverview This file contains Husky plugin that takes care of the basic editor commands
 * @name hp_SE_ExecCommand.js
 */
nhn.husky.SE2M_ExecCommand = jindo.$Class({
	name : "SE2M_ExecCommand",
	oEditingArea : null,
	oUndoOption : null,

	$init : function(oEditingArea){
		this.oEditingArea = oEditingArea;
		this.nIndentSpacing = 40;
		
		this.rxClickCr = new RegExp('^bold|underline|italic|strikethrough|justifyleft|justifycenter|justifyright|justifyfull|insertorderedlist|insertunorderedlist|outdent|indent$', 'i');
	},

	$BEFORE_MSG_APP_READY : function(){
		// the right document will be available only when the src is completely loaded
		if(this.oEditingArea && this.oEditingArea.tagName == "IFRAME"){
			this.oEditingArea = this.oEditingArea.contentWindow.document;
		}
	},

	$ON_MSG_APP_READY : function(){
		this.oApp.exec("REGISTER_HOTKEY", ["ctrl+b", "EXECCOMMAND", ["bold", false, false]]);
		this.oApp.exec("REGISTER_HOTKEY", ["ctrl+u", "EXECCOMMAND", ["underline", false, false]]);
		this.oApp.exec("REGISTER_HOTKEY", ["ctrl+i", "EXECCOMMAND", ["italic", false, false]]);
		this.oApp.exec("REGISTER_HOTKEY", ["ctrl+d", "EXECCOMMAND", ["strikethrough", false, false]]);
		this.oApp.exec("REGISTER_HOTKEY", ["tab", "INDENT"]);
		this.oApp.exec("REGISTER_HOTKEY", ["shift+tab", "OUTDENT"]);
		//this.oApp.exec("REGISTER_HOTKEY", ["tab", "EXECCOMMAND", ["indent", false, false]]);
		//this.oApp.exec("REGISTER_HOTKEY", ["shift+tab", "EXECCOMMAND", ["outdent", false, false]]);

		this.oApp.exec("REGISTER_UI_EVENT", ["bold", "click", "EXECCOMMAND", ["bold", false, false]]);
		this.oApp.exec("REGISTER_UI_EVENT", ["underline", "click", "EXECCOMMAND", ["underline", false, false]]);
		this.oApp.exec("REGISTER_UI_EVENT", ["italic", "click", "EXECCOMMAND", ["italic", false, false]]);
		this.oApp.exec("REGISTER_UI_EVENT", ["lineThrough", "click", "EXECCOMMAND", ["strikethrough", false, false]]);
		this.oApp.exec("REGISTER_UI_EVENT", ["superscript", "click", "EXECCOMMAND", ["superscript", false, false]]);
		this.oApp.exec("REGISTER_UI_EVENT", ["subscript", "click", "EXECCOMMAND", ["subscript", false, false]]);
		this.oApp.exec("REGISTER_UI_EVENT", ["justifyleft", "click", "EXECCOMMAND", ["justifyleft", false, false]]);
		this.oApp.exec("REGISTER_UI_EVENT", ["justifycenter", "click", "EXECCOMMAND", ["justifycenter", false, false]]);
		this.oApp.exec("REGISTER_UI_EVENT", ["justifyright", "click", "EXECCOMMAND", ["justifyright", false, false]]);
		this.oApp.exec("REGISTER_UI_EVENT", ["justifyfull", "click", "EXECCOMMAND", ["justifyfull", false, false]]);
		this.oApp.exec("REGISTER_UI_EVENT", ["orderedlist", "click", "EXECCOMMAND", ["insertorderedlist", false, false]]);
		this.oApp.exec("REGISTER_UI_EVENT", ["unorderedlist", "click", "EXECCOMMAND", ["insertunorderedlist", false, false]]);
		this.oApp.exec("REGISTER_UI_EVENT", ["outdent", "click", "EXECCOMMAND", ["outdent", false, false]]);
		this.oApp.exec("REGISTER_UI_EVENT", ["indent", "click", "EXECCOMMAND", ["indent", false, false]]);

//		this.oApp.exec("REGISTER_UI_EVENT", ["styleRemover", "click", "EXECCOMMAND", ["RemoveFormat", false, false]]);
	},

	$ON_INDENT : function(){
		this.oApp.delayedExec("EXECCOMMAND", ["indent", false, false], 0);
	},
	
	$ON_OUTDENT : function(){
		this.oApp.delayedExec("EXECCOMMAND", ["outdent", false, false], 0);
	},
	
	$BEFORE_EXECCOMMAND : function(sCommand, bUserInterface, vValue, htOptions){
		var elTmp, oSelection, i, iLen, oNavigator;
		
		//????????? ?????? ????????? ????????? ??? ????????? ???????????? ????????? IE?????? EXECCOMMAND??? ??????????????? ??? ????????? ??????. 
		this.oApp.exec("FOCUS");		
		this._bOnlyCursorChanged = false;		
		oSelection = this.oApp.getSelection();
		oNavigator = jindo.$Agent().navigator();
				
		if(oNavigator.safari || oNavigator.chrome){
			// http://bts.nhncorp.com/nhnbts/browse/COM-715
			// [SE2.0] <Safari> ????????? ?????? > ????????? ???????????? ???????????????, ??????????????? ?????????????????? ????????? ????????? ????????? ?????????
			if(sCommand.match(/^insertorderedlist|insertunorderedlist$/i)){
				this.aBRs = this.oApp.getWYSIWYGDocument().getElementsByTagName("BR");
				this.aBeforeBRs = [];
				for(i=0, iLen=this.aBRs.length; i<iLen; i++){
					this.aBeforeBRs[i] = this.aBRs[i];
				}
			}
		}
		
		if(sCommand.match(/^bold|underline|italic|strikethrough|superscript|subscript$/i)){
			this.oUndoOption = {bMustBlockElement:true};
			
			if( nhn.CurrentSelection.isCollapsed()){
				this._bOnlyCursorChanged = true;

				//[SMARTEDITORSUS-228] ?????? ????????? ?????? ?????? ??? ?????? ????????? ?????? ???, ?????? ????????? ???????????? ?????? ????????? ?????? ????????? ?????? ????????? ????????????
				if( oNavigator.ie ){
					if(oSelection.startContainer.tagName == "BODY" && oSelection.startOffset === 0){
						elTmp = this.oApp.getWYSIWYGDocument().createElement("SPAN");					
						elTmp.innerHTML = unescape("%uFEFF");
						oSelection.insertNode(elTmp);
						oSelection.select();	
					}
				}
			}			
		}

		if(sCommand == "indent" || sCommand == "outdent"){
			if(!htOptions){htOptions = {};}
			htOptions["bDontAddUndoHistory"] = true;
		}
		if((!htOptions || !htOptions["bDontAddUndoHistory"]) && !this._bOnlyCursorChanged){
			if(sCommand.match(/justifyleft|justifycenter|justifyright|justifyfull/)){
				this.oUndoOption = {sSaveTarget:"BODY"};
			}else if(sCommand === "insertorderedlist" || sCommand === "insertunorderedlist"){
				this.oUndoOption = {bMustBlockContainer:true};
			}
			
			this.oApp.exec("RECORD_UNDO_BEFORE_ACTION", [sCommand, this.oUndoOption]);
		}
		if(oNavigator.ie){
			if(this.oApp.getWYSIWYGDocument().selection.type === "Control"){
				oSelection = this.oApp.getSelection();
				oSelection.select();
			} 
			
			if(sCommand == "insertorderedlist" || sCommand == "insertunorderedlist"){
				this._insertBlankLine();
			}
		}
	},

	$ON_EXECCOMMAND : function(sCommand, bUserInterface, vValue){
		var bSelectedBlock = false;
		var htSelectedTDs = {};
		var oSelection = this.oApp.getSelection();
				
		bUserInterface = (bUserInterface == "" || bUserInterface)?bUserInterface:false;
		vValue = (vValue == "" || vValue)?vValue:false;
		
		this.oApp.exec("IS_SELECTED_TD_BLOCK",['bIsSelectedTd',htSelectedTDs]);
		bSelectedBlock = htSelectedTDs.bIsSelectedTd;

		if( bSelectedBlock){
			if(sCommand == "indent"){
				this.oApp.exec("SET_LINE_BLOCK_STYLE", [null, jindo.$Fn(this._indentMargin, this).bind()]);
			}else if(sCommand == "outdent"){
				this.oApp.exec("SET_LINE_BLOCK_STYLE", [null, jindo.$Fn(this._outdentMargin, this).bind()]);
			}else{ 
				this._setBlockExecCommand(sCommand, bUserInterface, vValue);
			}
		} else {
			switch(sCommand){
			case "indent":
			case "outdent":
            	this.oApp.exec("RECORD_UNDO_BEFORE_ACTION", [sCommand]);
            	
				var sBookmark = oSelection.placeStringBookmark();

				if(sCommand === "indent"){
					this.oApp.exec("SET_LINE_STYLE", [null, jindo.$Fn(this._indentMargin, this).bind(), {bDoNotSelect : true, bDontAddUndoHistory : true}]);
				}else{
					this.oApp.exec("SET_LINE_STYLE", [null, jindo.$Fn(this._outdentMargin, this).bind(), {bDoNotSelect : true, bDontAddUndoHistory : true}]);
				}

				oSelection.moveToStringBookmark(sBookmark);
				oSelection.select();
				oSelection.removeStringBookmark(sBookmark);
				
                setTimeout(jindo.$Fn(function(sCommand){
                	this.oApp.exec("RECORD_UNDO_AFTER_ACTION", [sCommand]);	
                }, this).bind(sCommand), 25);

				break;
			
			case "justifyleft":
			case "justifycenter":
			case "justifyright":
			case "justifyfull":
				var oSelectionClone = null;
				
				if(jindo.$Agent().navigator().firefox){
					oSelectionClone = this._extendBlock();
				}
				
				this.oEditingArea.execCommand(sCommand, bUserInterface, vValue);
				
				if(!!oSelectionClone){
					oSelectionClone.select();
				}
				
				break;
				
			default:
				//if(jindo.$Agent().navigator().firefox){
					//this.oEditingArea.execCommand("styleWithCSS", bUserInterface, false);
				//}
				this.oEditingArea.execCommand(sCommand, bUserInterface, vValue);
			}
		}
		
		this._countClickCr(sCommand);
	},

	$AFTER_EXECCOMMAND : function(sCommand, bUserInterface, vValue, htOptions){
		if(jindo.$Agent().navigator().safari || jindo.$Agent().navigator().chrome){
			if(sCommand.match(/^insertorderedlist|insertunorderedlist$/i)){
				// this.aBRs gets updated automatically when the document is updated
				if(this.aBeforeBRs.length != this.aBRs.length){
					var waBeforeBRs = jindo.$A(this.aBeforeBRs);
					
					for(var i=0, iLen = this.aBRs.length; i<iLen; i++){
						if(waBeforeBRs.indexOf(this.aBRs[i])<0){
							this.aBRs[i].parentNode.removeChild(this.aBRs[i]);
						}
					}
				}
			}
		}
		
		if(jindo.$Agent().navigator().ie){
			if(this.elP1 && this.elP1.parentNode){
				this.elP1.parentNode.removeChild(this.elP1);
			}

			if(this.elP2 && this.elP2.parentNode){
				this.elP2.parentNode.removeChild(this.elP2);
			}

			if(sCommand === "insertorderedlist"){
				this._fixCorruptedBlockQuote("OL");
			}else{
				if(sCommand === "insertunorderedlist"){
					this._fixCorruptedBlockQuote("UL");
				}
			}

			//
			if(sCommand.match(/justifyleft|justifycenter|justifyright|justifyfull/)){
				var oSelection = this.oApp.getSelection();
				var aNodes = oSelection.getNodes();
				for(var i=0, nLen=aNodes.length; i<nLen; i++){
					var elNode = aNodes[i];
					if(elNode.tagName && elNode.tagName === "TABLE"){
						elNode.removeAttribute("align");
					}
				}
			}
		}

		if(sCommand == "indent" || sCommand == "outdent"){
			if(!htOptions){htOptions = {};}
			htOptions["bDontAddUndoHistory"] = true;
		}
		if((!htOptions || !htOptions["bDontAddUndoHistory"]) && !this._bOnlyCursorChanged){
			this.oApp.exec("RECORD_UNDO_AFTER_ACTION", [sCommand, this.oUndoOption]);
		}

		this.oApp.exec("CHECK_STYLE_CHANGE", []);
	},
	
	_setBlockExecCommand : function(sCommand, bUserInterface, vValue){
		var aNodes, aChildrenNode, htSelectedTDs = {};
		this.oSelection = this.oApp.getSelection();
		this.oApp.exec("GET_SELECTED_TD_BLOCK",['aTdCells',htSelectedTDs]);
		aNodes = htSelectedTDs.aTdCells;

		for( var j = 0; j < aNodes.length ; j++){
			
			this.oSelection.selectNodeContents(aNodes[j]);
			this.oSelection.select();
			
			if(jindo.$Agent().navigator().firefox){
				this.oEditingArea.execCommand("styleWithCSS", bUserInterface, false); //styleWithCSS??? ff?????????.
			}
			
			aChildrenNode = this.oSelection.getNodes();
			for( var k = 0; k < aChildrenNode.length ; k++ ) {
				if(aChildrenNode[k].tagName == "UL" || aChildrenNode[k].tagName == "OL" ){
					jindo.$Element(aChildrenNode[k]).css("color",vValue);
				}
			}			
			this.oEditingArea.execCommand(sCommand, bUserInterface, vValue);
		}
	},
	
	_indentMargin : function(elDiv){
		var elTmp = elDiv;
		while(elTmp){
			if(elTmp.tagName && elTmp.tagName === "LI"){
				elDiv = elTmp;
				break;
			}
			elTmp = elTmp.parentNode;
		}
		
		if(elDiv.tagName === "LI"){
			//<OL>
			//	<OL>
			// 		<LI>22</LI>
			//	</OL>
			//	<LI>33</LI>
			//</OL>
			//??? ?????? ???????????? 33??? ???????????? ?????? ???, ????????? silbling OL??? ????????? ????????? ?????? ????????? ???.
			//<OL>
			//	<OL>
			// 		<LI>22</LI>
			//		<LI>33</LI>
			//	</OL>
			//</OL>
			if(elDiv.previousSibling && elDiv.previousSibling.tagName && elDiv.previousSibling.tagName === elDiv.parentNode.tagName){
				// ????????? ????????? OL??? ?????? ????????? ?????? ????????????,
				//<OL>
				//	<OL>
				// 		<LI>22</LI>
				//	</OL>
				//	<LI>33</LI>
				//	<OL>
				// 		<LI>44</LI>
				//	</OL>
				//</OL>
				//22,33,44??? ????????? ????????? ?????? ????????? ???.
				//<OL>
				//	<OL>
				// 		<LI>22</LI>
				//		<LI>33</LI>
				// 		<LI>44</LI>
				//	</OL>
				//</OL>
				if(elDiv.nextSibling && elDiv.nextSibling.tagName && elDiv.nextSibling.tagName === elDiv.parentNode.tagName){
					var aAppend = [elDiv];
					for(var i=0, nLen=elDiv.nextSibling.childNodes.length; i<nLen; i++){
						aAppend.push(elDiv.nextSibling.childNodes[i]);
					}
					
					var elInsertTarget = elDiv.previousSibling;
					var elDeleteTarget = elDiv.nextSibling;
					for(var i=0, nLen=aAppend.length; i<nLen; i++){
						elInsertTarget.insertBefore(aAppend[i], null);
					}
					
					elDeleteTarget.parentNode.removeChild(elDeleteTarget);
				}else{
					elDiv.previousSibling.insertBefore(elDiv, null);
				}

				return;
			}
			
			//<OL>
			//	<LI>22</LI>
			//	<OL>
			// 		<LI>33</LI>
			//	</OL>
			//</OL>
			//??? ?????? ???????????? 22??? ???????????? ?????? ???, ????????? silbling OL??? ?????????.
			if(elDiv.nextSibling && elDiv.nextSibling.tagName && elDiv.nextSibling.tagName === elDiv.parentNode.tagName){
				elDiv.nextSibling.insertBefore(elDiv, elDiv.nextSibling.firstChild);
				return;
			}
			
			var elTmp = elDiv.parentNode.cloneNode(false);
			elDiv.parentNode.insertBefore(elTmp, elDiv);
			elTmp.appendChild(elDiv);
			return;
		}
		var nCurMarginLeft = parseInt(elDiv.style.marginLeft);
		if(!nCurMarginLeft){
			nCurMarginLeft = 0;
		}

		nCurMarginLeft += this.nIndentSpacing;
		elDiv.style.marginLeft = nCurMarginLeft+"px";
	},
	
	_outdentMargin : function(elDiv){
		var elTmp = elDiv;
		while(elTmp){
			if(elTmp.tagName && elTmp.tagName === "LI"){
				elDiv = elTmp;
				break;
			}
			elTmp = elTmp.parentNode;
		}
		
		if(elDiv.tagName === "LI"){
			var elParentNode = elDiv.parentNode;
			
			var elInsertBefore = elDiv.parentNode;
			
			// LI??? ?????? ????????? ??????.
			// ?????? ?????? li/ol/ul??? ??????????
			if(elDiv.previousSibling && elDiv.previousSibling.tagName && elDiv.previousSibling.tagName.match(/LI|UL|OL/)){
				// ???????????? sibling li/ol/ul??? ????????? ol/ul??? 2?????? ???????????????
				if(elDiv.nextSibling && elDiv.nextSibling.tagName && elDiv.nextSibling.tagName.match(/LI|UL|OL/)){
					var elNewParent = elParentNode.cloneNode(false);
					while(elDiv.nextSibling){
						elNewParent.insertBefore(elDiv.nextSibling, null);
					}
					elParentNode.parentNode.insertBefore(elNewParent, elParentNode.nextSibling);
					elInsertBefore = elNewParent;
				// ?????? LI??? ????????? LI?????? ?????? OL/UL ????????? ??????
				}else{
					elInsertBefore = elParentNode.nextSibling;
				}
			}
			elParentNode.parentNode.insertBefore(elDiv, elInsertBefore);
			
			// ???????????? ??? LI ?????? ?????? LI??? ?????? ?????? ?????? ?????? ?????? ?????? ?????????
			if(!elParentNode.innerHTML.match(/LI/i)){
				elParentNode.parentNode.removeChild(elParentNode);
			}

			// OL?????? UL ???????????? ??????????????? ??? ???????????? LI??? ?????????
			if(!elDiv.parentNode.tagName.match(/OL|UL/)){
				var elInsertParent = elDiv.parentNode;
				elInsertBefore = elDiv;

				// ???????????? P??? ?????????
				var oDoc = this.oApp.getWYSIWYGDocument();
				elInsertParent = oDoc.createElement("P");
				elInsertBefore = null;
				
				elDiv.parentNode.insertBefore(elInsertParent, elDiv);

				while(elDiv.firstChild){
					elInsertParent.insertBefore(elDiv.firstChild, elInsertBefore);
				}
				elDiv.parentNode.removeChild(elDiv);
			}
			return;
		}
		var nCurMarginLeft = parseInt(elDiv.style.marginLeft);
		if(!nCurMarginLeft) nCurMarginLeft = 0;

		nCurMarginLeft -= this.nIndentSpacing;
		if(nCurMarginLeft < 0) nCurMarginLeft = 0;
		elDiv.style.marginLeft = nCurMarginLeft+"px";
	},
	
	// Fix IE's execcommand bug
	// When insertorderedlist/insertunorderedlist is executed on a blockquote, the blockquote will "suck in" directly neighboring OL, UL's if there's any.
	// To prevent this, insert empty P tags right before and after the blockquote and remove them after the execution.
	_insertBlankLine : function(){
		var oSelection = this.oApp.getSelection();
		var elNode = oSelection.commonAncestorContainer;
		this.elP1 = null;
		this.elP2 = null;

		while(elNode){
			if(elNode.tagName == "BLOCKQUOTE"){
				this.elP1 = this.oApp.getWYSIWYGDocument().createElement("P");
				elNode.parentNode.insertBefore(this.elP1, elNode);

				this.elP2 = this.oApp.getWYSIWYGDocument().createElement("P");
				elNode.parentNode.insertBefore(this.elP2, elNode.nextSibling);
				
				break;
			}
			elNode = elNode.parentNode;
		}
	},

	// Fix IE's execcommand bug
	// When insertorderedlist/insertunorderedlist is executed on a blockquote with all the child nodes selected, 
	// eg:<blockquote>[selection starts here]blah...[selection ends here]</blockquote>
	// , IE will change the blockquote with the list tag and create <OL><OL><LI>blah...</LI></OL></OL>.
	// (two OL's or two UL's depending on which command was executed)
	//
	// It can also happen when the cursor is located at bogus positions like 
	// * below blockquote when the blockquote is the last element in the document
	_fixCorruptedBlockQuote : function(sTagName){
		var aNodes = this.oApp.getWYSIWYGDocument().getElementsByTagName(sTagName);
		var elCorruptedBlockQuote;
		
		for(var i=0, nLen=aNodes.length; i<nLen; i++){
			if(aNodes[i].firstChild && aNodes[i].firstChild.tagName == sTagName){
				elCorruptedBlockQuote = aNodes[i];
				break;
			}
		}
		
		if(!elCorruptedBlockQuote){return;}

		var elTmpParent = elCorruptedBlockQuote.parentNode;

		// (1) changing outerHTML will cause loss of the reference to the node, so remember the idx position here
		var nPos = this._getPosIdx(elCorruptedBlockQuote);
		var el = this.oApp.getWYSIWYGDocument().createElement("DIV");
		el.innerHTML = elCorruptedBlockQuote.outerHTML.replace("<"+sTagName, "<BLOCKQUOTE");
		elCorruptedBlockQuote.parentNode.insertBefore(el.firstChild, elCorruptedBlockQuote);
		elCorruptedBlockQuote.parentNode.removeChild(elCorruptedBlockQuote);

		// (2) and retrieve the new node here
		var elNewNode = elTmpParent.childNodes[nPos];

		// garbage <OL></OL> or <UL></UL> will be left over after setting the outerHTML, so remove it here.
		var aLists = elNewNode.getElementsByTagName(sTagName);
		for(var i=0, nLen=aLists.length; i<nLen; i++){
			if(aLists[i].childNodes.length<1){
				aLists[i].parentNode.removeChild(aLists[i]);
			}
		}

		oSelection = this.oApp.getEmptySelection();
		oSelection.selectNodeContents(elNewNode);
		oSelection.collapseToEnd();
		oSelection.select();
	},
	
	_getPosIdx : function(refNode){
		var idx = 0;
		for(var node = refNode.previousSibling; node; node = node.previousSibling){idx++;}

		return idx;
	},
	
	_countClickCr : function(sCommand) {
		if (!sCommand.match(this.rxClickCr)) {
			return;
		}	

		this.oApp.exec('MSG_NOTIFY_CLICKCR', [sCommand.replace(/^insert/i, '')]);
	}, 
	
	_extendBlock : function(){
		// [SMARTEDITORSUS-663] [FF] lock????????? ???????????? Range??? ?????? ????????????????????? ?????? ???????????????
		// ????????? ???????????? ?????? ????????? ????????? Block?????? extend?????? execCommand API??? ????????? ??? ????????? ???

		var oSelection = this.oApp.getSelection(),
			oStartContainer = oSelection.startContainer,
			oEndContainer = oSelection.endContainer,
			aChildImg = [],
			aSelectedImg = [],
			oSelectionClone = oSelection.cloneRange();
		
		// <p><img><br/><img><br/><img></p> ??? ??? ???????????? ????????? ???????????? ??????
		// - container ????????? P ?????? container ????????? ???????????? ??? ???????????? ??????????????? ????????? ???????????? ??? ??? ????????? ??????
		
		if(!(oStartContainer === oEndContainer && oStartContainer.nodeType === 1 && oStartContainer.tagName === "P")){
			return;
		}

		aChildImg = jindo.$A(oStartContainer.childNodes).filter(function(value, index, array){
			return (value.nodeType === 1 && value.tagName === "IMG");
		}).$value();
		
		aSelectedImg = jindo.$A(oSelection.getNodes()).filter(function(value, index, array){
			return (value.nodeType === 1 && value.tagName === "IMG");
		}).$value();
		
		if(aChildImg.length <= aSelectedImg.length){
			return;
		}
		
		oSelection.selectNode(oStartContainer);
		oSelection.select();
		
		return oSelectionClone;
	}
});
//}
