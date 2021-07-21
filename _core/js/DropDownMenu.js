/*
 * DO NOT REMOVE THIS NOTICE
 *
 * PROJECT:   mygosuMenu
 * VERSION:   1.0.8
 * COPYRIGHT: (c) 2003,2004 Cezary Tomczak
 * LINK:      http://gosu.pl/dhtml/mygosumenu.html
 * LICENSE:   BSD (revised)
 */

function DropDownMenu(id) {

    /* Type of the menu: "horizontal" or "vertical" */
    this.type = "horizontal";

    /* Delay (in miliseconds >= 0): show-hide menu */
    this.delay = {
        "show": 0,
        "hide": 300
    }
    /* Change the default position of sub-menu by Y pixels from top and X pixels from left
     * Negative values are allowed */
    this.position = {
        "top": 0,
        "left": 0
    }
    /* Z-index property for .ss_menu */
    this.zIndex = {
        "visible": 1,
        "hidden": -1
    };

    // Browser detection
    this.browser = {
        "ie": Boolean(document.body.currentStyle),
        "ie5": (navigator.appVersion.indexOf("MSIE 5.5") != -1 || navigator.appVersion.indexOf("MSIE 5.0") != -1)
    };
    if (!this.browser.ie) { this.browser.ie5 = false; }

    /* Initialize the menu */
    this.init = function() {
        if (!document.getElementById(this.id)) { return alert("DropDownMenu.init() failed. Element '"+ this.id +"' does not exist."); }
        if (this.type != "horizontal" && this.type != "vertical") { return alert("DropDownMenu.init() failed. Unknown menu type: '"+this.type+"'"); }
        if (this.browser.ie && this.browser.ie5) { fixWrap(); }
        fixss_menus();
        parse(document.getElementById(this.id).childNodes, this.tree, this.id);
    }

    /* Search for .ss_menu elements and set width for them */
    function fixss_menus() {
        var arr = document.getElementById(self.id).getElementsByTagName("div");
        var ss_menus = new Array();
        var widths = new Array();
        
        for (var i = 0; i < arr.length; i++) {
            if (arr[i].className == "ss_menu") {
                ss_menus.push(arr[i]);
            }
        }
        for (var i = 0; i < ss_menus.length; i++) {
            widths.push(getMaxWidth(ss_menus[i].childNodes));
        }
        for (var i = 0; i < ss_menus.length; i++) {
            ss_menus[i].style.width = (widths[i]) + "px";
        }
        if (self.browser.ie) {
            for (var i = 0; i < ss_menus.length; i++) {
                setMaxWidth(ss_menus[i].childNodes, widths[i]);
            }
        }
    }

    function fixWrap() {
        var elements = document.getElementById(self.id).getElementsByTagName("a");
        for (var i = 0; i < elements.length; i++) {
            if (/item2/.test(elements[i].className)) {
                elements[i].innerHTML = '<div nowrap="nowrap">'+elements[i].innerHTML+'</div>';
            }
        }
    }

    /* Search for an element with highest width among given nodes, return that width */
    function getMaxWidth(nodes) {
        var maxWidth = 0;
        for (var i = 0; i < nodes.length; i++) {
            if (nodes[i].nodeType != 1) { continue; }
            if (nodes[i].offsetWidth > maxWidth) { maxWidth = nodes[i].offsetWidth; }
        }
        return maxWidth;
    }

    /* Set width for item2 elements */
    function setMaxWidth(nodes, maxWidth) {
        for (var i = 0; i < nodes.length; i++) {
            if (nodes[i].nodeType == 1 && /item2/.test(nodes[i].className) && nodes[i].currentStyle) {
                if (self.browser.ie5) {
                    nodes[i].style.width = (maxWidth) + "px";
                } else {
                    nodes[i].style.width = (maxWidth - parseInt(nodes[i].currentStyle.paddingLeft) - parseInt(nodes[i].currentStyle.paddingRight)) + "px";
                }
            }
        }
    }

    /* Parse nodes, create events, position elements */
    function parse(nodes, tree, id) {
        for (var i = 0; i < nodes.length; i++) {
            if (1 != nodes[i].nodeType) {
                continue;
            }
            switch (true) {
                // .menu
                case /\bmenu\b/.test(nodes[i].className):
                    nodes[i].id = id + "-" + tree.length;
                    tree.push(new Array());
                    nodes[i].onmouseover = menuover;
                    nodes[i].onmouseout = menuout;
                    break;
                // .item2
                case /\bitem2\b/.test(nodes[i].className):
                    nodes[i].id = id + "-" + tree.length;
                    tree.push(new Array());
                    break;
                // .ss_menu
                case /\bss_menu\b/.test(nodes[i].className):
                    // id, events
                    nodes[i].id = id + "-" + (tree.length - 1) + "-ss_menu";
                    nodes[i].onmouseover = ss_menuOver;
                    nodes[i].onmouseout = ss_menuOut;
                    // position
                    var box1 = document.getElementById(id + "-" + (tree.length - 1));
                    var box2 = document.getElementById(nodes[i].id);
                    if ("horizontal" == self.type) {
                        box2.style.top = box1.offsetTop + box1.offsetHeight + self.position.top + "px";
                        if (self.browser.ie5) {
                            box2.style.left = self.position.left + "px";
                        } else {
                            box2.style.left = box1.offsetLeft + self.position.left + "px";
                        }
                    } else if ("vertical" == self.type) {
                        box2.style.top = box1.offsetTop + self.position.top + "px";
                        if (self.browser.ie5) {
                            box2.style.left = box1.offsetWidth + self.position.left + "px";
                        } else {
                            box2.style.left = box1.offsetLeft + box1.offsetWidth + self.position.left + "px";
                        }
                    }
                    // ss_menus, ss_menusShowCnt, ss_menusHideCnt
                    self.ss_menus.push(nodes[i].id);
                    self.ss_menusShowCnt.push(0);
                    self.ss_menusHideCnt.push(0);
                    break;
            }
            if (nodes[i].childNodes) {
                if (/\bss_menu\b/.test(nodes[i].className)) {
                    parse(nodes[i].childNodes, tree[tree.length - 1], id + "-" + (tree.length - 1));
                } else {
                    parse(nodes[i].childNodes, tree, id);
                }
            }
        }
    }

    /* event, menu:onmouseover */
    function menuover() {
        var id_ss_menu = this.id + "-ss_menu";
        if (self.visible) {
            var el = new Element(self.visible);
            el = document.getElementById(el.getParent().id);
            if (/menu-active/.test(el.className)) {
                el.className = el.className.replace(/menu-active/, "menu");
            }
        }
        if (self.ss_menus.contains(id_ss_menu)) {
            self.ss_menusHideCnt[self.ss_menus.indexOf(id_ss_menu)]++;
            var cnt = self.ss_menusShowCnt[self.ss_menus.indexOf(id_ss_menu)];
            setTimeout(function(a, b) { return function() { self.showss_menu(a, b); } } (id_ss_menu, cnt), self.delay.show);
        } else {
            if (self.visible) {
                var cnt = self.ss_menusHideCnt[self.ss_menus.indexOf(self.visible)];
                setTimeout(function(a, b) { return function() { self.hidess_menu(a, b); } } (self.visible, cnt), self.delay.show);
            }
        }
    }

    /* event, menu:onmouseout */
    function menuout() {
        var id_ss_menu = this.id + "-ss_menu";
        if (self.ss_menus.contains(id_ss_menu)) {
            self.ss_menusShowCnt[self.ss_menus.indexOf(id_ss_menu)]++;
            if (id_ss_menu == self.visible) {
                var cnt = self.ss_menusHideCnt[self.ss_menus.indexOf(id_ss_menu)];
                setTimeout(function(a, b) { return function() { self.hidess_menu(a, b); } }(id_ss_menu, cnt), self.delay.hide);
            }
        }
    }

    /* event, ss_menu:onmouseover */
    function ss_menuOver() {
        self.ss_menusHideCnt[self.ss_menus.indexOf(this.id)]++;
        var el = new Element(this.id);
        el = document.getElementById(el.getParent().id);
        if (!/menu-active/.test(el.className)) {
            el.className = el.className.replace(/menu/, "menu-active");
        }
    }

    /* event, ss_menu:onmouseout */
    function ss_menuOut() {
        self.ss_menusShowCnt[self.ss_menus.indexOf(this.id)]++;
        var cnt = self.ss_menusHideCnt[self.ss_menus.indexOf(this.id)];
        setTimeout(function(a, b) { return function() { self.hidess_menu(a, b); } }(this.id, cnt), self.delay.hide);
    }

    /* Show ss_menu (1 argument passed)
     * Try to show ss_menu (2 arguments passed) - check cnt with ss_menuShowCnt */
    this.showss_menu = function(id, cnt) {
        if (typeof cnt != "undefined") {
            if (cnt != this.ss_menusShowCnt[this.ss_menus.indexOf(id)]) { return; }
        }
        this.ss_menusShowCnt[this.ss_menus.indexOf(id)]++;
        var el = new Element(id);
        var parent = document.getElementById(el.getParent().id);
        if (!/menu-active/.test(parent.className)) {
            parent.className = parent.className.replace(/menu/, "menu-active");
        }
        if (this.visible) {
            if (id == this.visible) { return; }
            this.hidess_menu(this.visible);
        }
        //document.getElementById(id).style.display = "block";
        document.getElementById(id).style.visibility = "visible";
        document.getElementById(id).style.zIndex = this.zIndex.visible;
        this.visible = id;
    }

    /* Hide ss_menu (1 argument passed)
     * Try to hide ss_menu (2 arguments passed) - check cnt with ss_menuHideCnt */
    this.hidess_menu = function(id, cnt) {
        if (typeof cnt != "undefined") {
            if (cnt != this.ss_menusHideCnt[this.ss_menus.indexOf(id)]) { return; }
        }
        var el = new Element(id);
        var parent = document.getElementById(el.getParent().id);
        parent.className = parent.className.replace(/menu-active/, "menu");
        document.getElementById(id).style.zIndex = this.zIndex.hidden;
        document.getElementById(id).style.visibility = "hidden";
        //document.getElementById(id).style.display = "none";
        if (id == this.visible) { this.visible = ""; }
        else {
            //throw "DropDownMenu.hidess_menu('"+id+"', "+cnt+") failed, cannot hide element that is not visible";
            return;
        }
        this.ss_menusHideCnt[this.ss_menus.indexOf(id)]++;
    }

    /* Necessary when showing ss_menu that doesn't exist - hide currently visible ss_menu. See: menuover() */
    this.hideSelf = function(cnt) {
        if (this.visible && cnt == this.ss_menusHideCnt[this.ss_menus.indexOf(this.visible)]) {
            this.hidess_menu(this.visible);
        }
    }

    /* Element (.ss_menu, .item2 etc) */
    function Element(id) {
        /* Get parent element */
        this.getParent = function() {
            var s = this.id.substr(this.menu.id.length);
            var a = s.split("-");
            a.pop();
            return new Element(this.menu.id + a.join("-"));
        }
        this.menu = self;
        this.id = id;
    }

    var self = this;
    this.id = id; /* menu id */
    this.tree = []; /* tree structure of menu */
    this.ss_menus = []; /* all ss_menus, required for timeout */
    this.ss_menusShowCnt = [];
    this.ss_menusHideCnt = [];
    this.visible = ""; /* visible ss_menu, ex. menu-0-ss_menu */
}

/* Finds the index of the first occurence of item in the array, or -1 if not found */
if (typeof Array.prototype.indexOf == "undefined") {
    Array.prototype.indexOf = function(item) {
        for (var i = 0; i < this.length; i++) {
            if ((typeof this[i] == typeof item) && (this[i] == item)) {
                return i;
            }
        }
        return -1;
    }
}

/* Check whether array contains given string */
if (typeof Array.prototype.contains == "undefined") {
    Array.prototype.contains = function(s) {
        for (var i = 0; i < this.length; i++) {
            if (this[i] === s) {
                return true;
            }
        }
        return false;
    }
}