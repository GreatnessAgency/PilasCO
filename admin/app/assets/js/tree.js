/**************************************************************************
	Copyright (c) 2001-2003 Geir Landri (drop@destroydrop.com)
	JavaScript Tree - www.destroydrop.com/hjavascripts/tree/
	Version 0.96	

	This script can be used freely as long as all copyright messages are
	intact.
**************************************************************************/

// Arrays for nodes and icons
var nodes			= new Array();
var openNodes		= new Array();
var openNodes_mi2	= new Array();
var openNodes_me3	= new Array();
var icons			= new Array();

// Create the tree
function createTree(arrName, startNode, openNode) {
	nodes = arrName;
	if (nodes.length > 0) {
		if (startNode == null) startNode = 0;
		if (openNode != 0 || openNode != null) setOpenNodes( openNode );

		if (startNode !=0) {
			var nodeValues = nodes[getArrayId(startNode)].split("|");
			document.write("<a href=\"" + nodeValues[3] + "\">" + nodeValues[2] + "</a>");
		} 
		//update
		var recursedNodes = new Array();
		document.write("<ul class=\"opt_user\">");
		addNode(startNode, recursedNodes, openNode );
		document.write("</ul>");	
	}
}
// Returns the position of a node in the array
function getArrayId(node) {
	for (i=0; i<nodes.length; i++) {
		var nodeValues = nodes[i].split("|");
		if (nodeValues[0]==node) return i;
	}
}
// Puts in array nodes that will be open
function setOpenNodes( openNode ) {
	for (i=0; i<nodes.length; i++) {
		var nodeValues = nodes[i].split("|");
		if (nodeValues[0] == openNode) {
			openNodes.push(nodeValues[0]);
			setOpenNodes( nodeValues[1] );
		}
	} 
}
// Checks if a node is open
function isNodeOpen(node) {
	for (i=0; i<openNodes.length; i++)
		if (openNodes[i]==node) return true;
	return false;
}
// Checks if a node has any children
function hasChildNode(parentNode) {
	for (i=0; i< nodes.length; i++) {
		var nodeValues = nodes[i].split("|");
		if (nodeValues[1] == parentNode) return true;
	}
	return false;
}
// Checks if a node is the last sibling
function lastSibling (node, parentNode) {
	var lastChild = 0;
	for (i=0; i< nodes.length; i++) {
		var nodeValues = nodes[i].split("|");
		if (nodeValues[1] == parentNode)
			lastChild = nodeValues[0];
	}
	if (lastChild==node) return true;
	return false;
}
// Adds a new node to the tree


function addNode(parentNode, recursedNodes, openNode) {
	for (var i = 0; i < nodes.length; i++) {
		var nodeValues = nodes[i].split("|");
		if (nodeValues[1] == parentNode) {
			
			var ls	= lastSibling(nodeValues[0], nodeValues[1]);
			var hcn	= hasChildNode(nodeValues[0]);
			var ino = isNodeOpen(nodeValues[0]);

			// Write out line & empty icons
			for (g=0; g<recursedNodes.length; g++) {
				if (recursedNodes[g] == 1) document.write("");
				else  document.write("");
			}

			// put in array line & empty icons
			if (ls) recursedNodes.push(0);
			else recursedNodes.push(1);

			// Start link
			if(nodeValues[3] != '#'){
			var	clase = (nodeValues[1] == 0)? 'ui-state-default' : "";	
			document.write('<li class="'+clase+'" ><a href="javascript:void(0)" onclick="' + nodeValues[3] + '" id="selMe'+ nodeValues[0] +'">');
			}else{
			document.write('<li class="ui-state-default"><a href="javascript:oc('+ nodeValues[0] +', 0);">');		
			}
			
			if(nodeValues[4] != '#'){
				document.write('<span class="ui-icon '+nodeValues[4]+'" style="float:left;">&nbsp;</span>');
			}else{
				document.write('<span class="ui-icon ui-icon-triangle-1-e" style="float:left;">&nbsp;</span>');
			}
			
			// Write out node name
			document.write('<span style="">'+ nodeValues[2]);
			
			
			// Write out folder & page icons
			
			if (hcn) {
				document.write(' [<span id="masMenos'+ nodeValues[0] +'">');
					if (ino){ document.write("-")}else{document.write("+")}
				document.write("</span>]</span>");
			}
			
			
			// End link
			document.write("</a></li>");
			
			// If node has children write out divs and go deeper
			if (hcn) {
				document.write("<li id=\"div" + nodeValues[0] + "\" class=\"li_interior\"");
					if (!ino) document.write(" style=\"display: none;\"");
				document.write("><ul>");
				addNode(nodeValues[0], recursedNodes, openNode);
				document.write("</ul></li>");
			}
			
			// remove last line or empty icon 
			recursedNodes.pop();
		}
	}
}
// Opens or closes a node
function oc(node, bottom) {
	var theDiv = document.getElementById("div" + node);
	var theJoin	= document.getElementById("join" + node);
	var theMore = document.getElementById("masMenos" + node);
	
	if (theDiv.style.display == 'none') {
		if (bottom==1) theJoin.src = icons[3].src;
		else 
		//theJoin.src = icons[2].src;  ---- comentado por alejandro quitar iconos [+] al cerrar
		$(theMore).text("-");
		theDiv.style.display = '';
	} else {
		if (bottom==1) theJoin.src = icons[1].src;
		else 
		//theJoin.src = icons[0].src; ---- comentado por alejandro quitar iconos [-] al cerrar
		$(theMore).text("+");
		theDiv.style.display = 'none';
	}
}
// Push and pop not implemented in IE
if(!Array.prototype.push) {
	function array_push() {
		for(var i=0;i<arguments.length;i++)
			this[this.length]=arguments[i];
		return this.length;
	}
	Array.prototype.push = array_push;
}
if(!Array.prototype.pop) {
	function array_pop(){
		lastElement = this[this.length-1];
		this.length = Math.max(this.length-1,0);
		return lastElement;
	}
	Array.prototype.pop = array_pop;
}
