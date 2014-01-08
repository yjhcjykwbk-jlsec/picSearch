div.item.fore1.hover=
handler: function (){if(typeof D!="undefined"&&!D.event.triggered)return D.event.handle.apply(arguments.callee.elem,arguments)}
isAttribute: false
lineNumber: 1
listenerBody: "function (){if(typeof D!="undefined"&&!D.event.triggered)return D.event.handle.apply(arguments.callee.elem,arguments)}"
type: "mouseover"
useCapture: false


 list[i].addEventListener ? list[i].addEventListener("mouseover",
		function(){
			list[i].className = "menuHover"
		}, 
		false) 
	: 
	list[i].attachEvent("onmouseover", function(){list[i].className = "menuHover"});
