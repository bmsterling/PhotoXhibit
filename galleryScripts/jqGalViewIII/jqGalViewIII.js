//http://www.ohmyflash.com/gallery/83/83.html


(function($){
	$.fn.jqGalViewIII = function(options){
		return this.each(function(index){
			var el = this, $_ = $(this); $img = $('img', $_);
			el.index = index;
			el.opts = $.extend({}, $.fn.jqGalViewIII.defaults, options);
			//  swap out current image gallery for jqGalView structure
			var $this = $.fn.jqGalViewIII.swapOut($_);
			
			$.jqGalViewIII.$this = $this;

			
			el.container = $('<div class="gvIIIContainer">').appendTo($this);
			//  Build our holder for the thumbnail images
			var $holder = $('<div class="gvIIIHolder"/>').appendTo(el.container);
			el.imgContainer = $('<div class="gvIIIImgContainer">').appendTo(el.container);
			el.loader = $('<div class="gvIIILoader"/>').appendTo(el.imgContainer);

			//  remove current images and replace with jqGalviewIII
			$(this).after($this).remove();

			$img.each(function(i){
				var $image = $(this);
				var thisImg = this;
				thisImg.index = i;

				var $div = $('<div id="gvIIIID'+i+'" class="gvIIIItem">')
				.appendTo($holder)
				.append('<div class="gvIIILoaderMini">');// end : $div
				
				if(el.opts.getUrlBy == 0)
					thisImg.altImg = $image.parent().attr('href');
				else if(el.opts.getUrlBy == 1)
					thisImg.altImg = el.opts.fullSizePath + thisImg.src.split('/').pop();
				else if(el.opts.getUrlBy == 2)
					thisImg.altImg = $this.src.replace(el.opts.prefix,'');
				
				thisImg.altTxt = $image.attr('alt');
				
				var image = new Image();
				image.onload = function(){
					image.onload = null;
					$div.empty().append($image);

					$image.click(function(){
						$.fn.jqGalViewIII.view(this,el);		   
					});

					if(i==0){
						$image.trigger('click');
					};
				};// end : image.onload 
				image.src = this.src;
			});
		});
	};

	$.fn.jqGalViewIII.view = function(img,el){
		if(typeof img.altImg == 'undefined') return false;
		var url = /\?imgmax/.test(img.altImg) ? img.altImg : img.altImg+'?imgmax=800';
		var t,b,wContainer,hContainer,heightTop=0, imgH, imgW;
		wContainer = el.imgContainer.width();
		hContainer = el.imgContainer.height();
		el.loader.show();
		
		$img = new Image();
		$img.onload = function(){
			$img.onload = null;
			el.loader.hide();
			imgW = $img.width;
			imgH = $img.height;
			

			if (imgW > wContainer) {
				imgH = imgH * (wContainer / imgW); 
				imgW = wContainer; 
				if (imgH > wContainer) { 
					imgW = imgW * (hContainer / imgH); 
					imgH = hContainer; 
				}
			} else if (imgH > hContainer) { 
				imgW = imgW * (hContainer / imgH); 
				imgH = hContainer; 
				if (imgW > wContainer) { 
					imgH = imgH * (wContainer / imgW); 
					imgW = wContainer;
				}
			}
			
			if($.jqGalViewIII.curT == null){
				$.jqGalViewIII.curT = t = $.jqGalViewIII.imgTop.clone().appendTo(el.imgContainer);
				$.jqGalViewIII.curB = b = $.jqGalViewIII.imgBot.clone().appendTo(el.imgContainer);
				t.append('<img src="'+this.src+'" style="width:'+imgW+'px;height:'+imgH+'px;"/>').css('z-index','15');
				b.append('<img src="'+this.src+'" style="width:'+imgW+'px;height:'+imgH+'px;margin-top:-'+b.height()+'px;"/>').css('z-index','15');
			}
			else{
				t = $.jqGalViewIII.imgTop.clone().appendTo(el.imgContainer);
				b = $.jqGalViewIII.imgBot.clone().appendTo(el.imgContainer);
				t.append('<img src="'+this.src+'" style="width:'+imgW+'px;height:'+imgH+'px;"/>');
				b.append('<img src="'+this.src+'" style="width:'+imgW+'px;height:'+imgH+'px;margin-top:-'+b.height()+'px;"/>');
				heightTop = $.jqGalViewIII.curT.height();

				$.jqGalViewIII.curT
				.animate({top:-heightTop},'slow',function(){
					$(this).remove();
					$.jqGalViewIII.curT = t.css('z-index','15');;
				});
				$.jqGalViewIII.curB
				.animate({top:"+="+heightTop},'slow',function(){
					$(this).remove();
					$.jqGalViewIII.curB = b.css('z-index','15');;
				});
			};
		};
		$img.src = url;
	};

	$.fn.jqGalViewIII.swapOut = function($el){
		var id = $el.attr('id') ? (' id="'+$el.attr('id')+'"') : '';
		var $this = $('<div' + id + '>');
		return $this;
	};

	$.fn.jqGalViewIII.defaults = {
		getUrlBy : 0, // 0 == from parent A tag | 1 == the full size resides in another folder
		fullSizePath : null,
		prefix: 'thumbnail.',
		items: 20,
		arrowEase:'easeout',
		toolTip: false,
		ttDelay:250
	};

	$.jqGalViewIII = {
		$this:null,
		imgTop:$('<div class="gvIIIImgTop" style="z-index:14;">'),
		imgBot:$('<div class="gvIIIImgBot" style="z-index:14;">'),
		loader:$('<div class="gvIIILoader" style="z-index:16;"/>'),
		img:$('<img/>'),
		curT:null,
		curB:null
	};
})(jQuery);
/*

			$.jqGalViewIII[index]['container'] = $('<div class="gvIIIContainer">');
			$.jqGalViewIII[index]['imgTop'] = $('<div class="gvIIIImgTop">');
			$.jqGalViewIII[index]['imgBot'] = $('<div class="gvIIIImgBot">');
			
/*
			$.jqGalViewIII.c = $('<div class="gvIIIBLah">');
			
			$.jqGalViewIII.c.clone().appendTo('body');
			$.jqGalViewIII.c.clone().appendTo('body');
			$.jqGalViewIII.c.clone().appendTo('body');
			$.jqGalViewIII.c.clone().appendTo('body');

	$.jqGalViewIII = {
		container : null,
		imgTop:null,
		imgBot:null,
		cur:null
	};
*/