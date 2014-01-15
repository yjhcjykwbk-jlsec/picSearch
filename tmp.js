$(function() { 
	$('#GridView1 tr:gt(0)').contextMenu('menu', 
{ 
	bindings: 
	{ 
		'add': function(t, target) { 
			alert('Trigger：' + t.id + ' 增加' + " taget by:" + $("td:eq(0)", target).text()); 
		}, 
	'delete': function(t, target) { 
		alert('Trigger：' + t.id + ' 删除' + " taget by:" + $("td:eq(0)", target).text()); 
		$(target).remove(); 
	}, 
	'save': function(t, target) { 
		alert('Trigger：' + t.id + ' 保存' + " taget by:" + $("td:eq(0)", target).text()); 
	}, 
	'About': function(t, target) { 
		alert('Code by http://www.cnblogs.com/whitewolf/'); 
	} 
	}, 
	onShowMenu: function(e, menu) { 
		if (parseInt($("td:eq(0)", e.currentTarget).text()) > 10) { 
			$("#save", menu).remove(); 
		} 
		$(e.currentTarget).siblings().removeClass("SelectedRow").end().addClass("SelectedRow"); 
		return menu; 
	} 
		}); 
}) 
