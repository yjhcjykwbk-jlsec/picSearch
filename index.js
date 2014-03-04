function MyWaterfall(){
	// 测试用技术器
	// 调用瀑布流
	var n = 0;
	var m = 0;
	this.wf = new Waterfall({
		container: $('#container'),
		colWidth: 230,
		maxCol: 4,
		preDistance: 0,
		load: function(){
			// 触发滚动加载时的具体操作
			// 当前作用域下，this指向正创建的对象
			var self = this;
			//console.log('..load');

			//m is the start of image num
			$.get('more.php?m='+m, function(data) {
				n++;
				var res = [];
				m+= data.items.length;
				if(data.items.length==0){
					self.end();		 // 终止滚动load
					$('#end').show();
				}
				else
				$.each(data.items, function(i, item){
          console.log("waterfall:");
          console.log(item);
					res.push(
						'<div class="item masonry_brick masonry-brick" style="position: absolute; top: 0px; left: 0px;">'+
						'<div class="item_t">'+ 
            '<div class="img"> '+
            '<a target="__blank'+i+'" href="'+item.src+'" id="'+item.id+'">'+
            '<img width="'+210+'"  alt="'+item.id+' '+item.src+'" src="'+item.src+'" data-pinit="registered" ready="alert(\" i am loaded\");">'+
            '</a> '+
            '<span class="class">weibo</span> '+
            '<div class="btns"> '+
            '<a href="http://www.jsfoot.com/js/images/more/2012-05-15/608.html" class="img_album_btn">加入专辑</a> '+
            '</div> '+
            '</div> '+
            '<div class="desp"><span>this is a description.................</span></div> '+
            '</div> '+
            '<div class="item_b clearfix"> '+
            '<div class="items_likes fl"> <a href="http://www.jsfoot.com" class="like_btn"></a> '+
            '<em class="bold">916</em> '+
            '</div> '+
            '<div class="items_comment fr">'+
            '<a href="http://www.jsfoot.com">评论</a>'+
            '<em class="bold">(0)</em>'+
            '</div> '+
            '</div> '+
            '</div>');
				});
			self.success(res);
			$('div.item img').each(function(){
				$(this).contextMenu('menu',menuAdapter);
			});
			}, 'json');
		}
	});
};
function ocr(id,img){
	para="&img="+img+"&id="+id;
	$.ajax({
		url:"OCR/ocr_js.php", 
		data:"action=ocr"+para, type:'post', dataType:'text', 
		success:function(result){
			console.log("ocr result():"+result);
			alert(result);
		}
	});
}
var menuAdapter={
	//菜单样式
	menuStyle: {
		border: '2px solid #000'
	},
	//菜单项样式
	itemStyle: {
		fontFamily : 'verdana',
		font: '12px',
		backgroundColor : 'white',
		color: 'black',
		border: 'none',
		padding: '1px'
	},
	//菜单项鼠标放在上面样式
	itemHoverStyle: {
		color: 'blue',
		backgroundColor: 'red',
		border: 'none'
	},
	bindings: 
	{ 
		'ocr': 
			function(t, target) { 
        console.log("function ocr:");
        console.log(t);
        console.log(target);
        var ss=t.alt.split(" "); 
        id=ss[0];
        img="../"+ss[1];
        console.log(id+"#"+img);
				//<!-- alert('Trigger：' + t.id + ' 识别' + " taget by:" + $("td:eq(0)", target).text());  -->
				ocr(id,img);
			}
	}, 
	onShowMenu: function(e, menu) { 
		return menu; 
	} 
};

