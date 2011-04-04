/**
 * jQuery jqGalViewII Plugin
 * Examples and documentation at: http://benjaminsterling.com/2007/10/02/jquery-jqgalviewii-photo-gallery/
 *
 * @author: Benjamin Sterling
 * @version: 0.5
 * @copyright (c) 2007 Benjamin Sterling, KenzoMedia
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *   
 * @requires jQuery v1.2.1 or later
 * 
 * 
 * @name jqGalViewII
 * @example $('ul').jqGalViewII();
 * 
 * @Semantic requirements:
 * 				The structure fairly simple and should be unobtrusive, you
 * 				basically only need a parent container with a list of imgs
 * 
 * 	<ul>
 *		<li><img src="common/img/dsc_0003.thumbnail.JPG"/></li>
 *		<li><img src="common/img/dsc_0012.thumbnail.JPG"/></li>
 *	</ul>
 *
 *  -: or :-
 * 
 * <div>
 * 		<img src="common/img/dsc_0003.thumbnail.JPG"/>
 * 		<img src="common/img/dsc_0012.thumbnail.JPG"/>
 * </div>
 * 
 * @param Integer getUrlBy
 * 					By default, it is set to 0 (zero) and the plugin will
 * 					get the url of the full size img from the images 
 * 					parent A tag, or you can set it to 1 will and provide
 * 					the fullSizePath param with the path to the full size
 * 					images.  Finally, you can set it to 2 and provide text
 * 					to prefix param and have that prefix removed from the
 * 					src tag of the thumbnail to create the path to the
 * 					full sized image
 * 
 * @example $('#gallery').jqGalViewII({getUrlBy:1,fullSizePath:'fullPath/to/fullsize/folder'});
 * 
 * @example $('#gallery').jqGalViewII({getUrlBy:2, prefix:'.tn'});
 * 					".tn" gets removed from the src attribute of your image
 * 
 * @param String fullSizePath
 * 					Set to null by default, but if you are going to set
 * 					getUrlBy param to 1, you need to provide the full path
 * 					to the full size image.
 * 
 * @example $('#gallery').jqGalViewII({getUrlBy:1,fullSizePath:'fullPath/to/fullsize/folder'});
 * 
 * @param String prefix
 * 					Set to null by default, but if you are going to set
 * 					getUrlBy param to 2, you need to provide text you
 * 					want to remove from the src attribute of the thumbnail
 * 					to get create the full size image name
 * 
 * @example $('ul').jqGalViewII({getUrlBy:2, prefix:'.tn'});
 * 					".tn" gets removed from the src attribute of your image
 * 
 * @styleClasses
 * 		gvIIContainer:  overall holder of thumbnails and gvIIHolder div, the
 * 						gvIILoader div and the gvIIImgContainer div
 * 		gvIIHolder: contains the thumbnails divs
 *		gvIIItem: contains the thumbnail img, the gvLoaderMini div and the gvOpen div
 *		gvIILoaderMini :empty but styled with a loader images as background image.
 * 		gvIIImgContainer: the full size image container and the gvDescText div
 * 		gvIILoader: empty but styled with a loader images as background image.
 * 
 * 
 * changes:
 *
 */
(function($){
	$.fn.jqGalViewII = function(options){
		return this.each(function(index){
			var el = this, $_ = $(this); $img = $('img', $_);
			el.opts = $.extend({}, $.fn.jqGalViewII.defaults, options);
			//  swap out current image gallery for jqGalView structure
			var $this = $.fn.jqGalViewII.swapOut($_);
			
			var $container = $('<div class="gvIIContainer">').appendTo($this);

			el.mainImgContainer = $('<div class="gvIIImgContainer">').appendTo($container);
			el.image = $('<img/>').appendTo(el.mainImgContainer);
			el.loader = $('<div class="gvIILoader"/>').appendTo(el.mainImgContainer);
			//  Build our holder for the thumbnail images
			var $holder = $('<div class="gvIIHolder"/>').appendTo($container);
			
			var $arrow = $('<div class="gvIIArrow"/>');
			
			$img.each(function(i){
				var $image = $(this);
				
				var $div = $('<div id="gvIIID'+i+'" class="gvIIItem">')
				.appendTo($holder)
				.append('<div class="gvIILoaderMini">');// end : $div
				
				if(el.opts.getUrlBy == 0)
					this.altImg = $image.parent().attr('href');
				else if(el.opts.getUrlBy == 1)
					this.altImg = el.opts.fullSizePath + this.src.split('/').pop();
				else if(el.opts.getUrlBy == 2)
					this.altImg = $this.src.replace(el.opts.prefix,'');
				
				this.altTxt = $image.attr('alt');
				
				var image = new Image();
				image.onload = function(){
					image.onload = null;
					$div.empty().append($image);
					$('<div class="gvIIFlash">').appendTo($div).css({opacity:".01"})
					.mouseover(
						function(){
							var $f = $(this);
							$f.css({opacity:".75"}).stop().animate({opacity:".01"},500);
							/**
							// This was a bit heavy for real use, I'll leave it here for future dev
							var offSet = $f.offset();
							var osLeft = offSet.left + ($f.width()/2);
							var osTop = offSet.top;
							$arrow.stop().animate({left:osLeft,top:osTop}, 100, el.opts.arrowEase);
							*/
						}
					)
					.click(
						function(){
							$image.trigger('click');
						}
					);
					$image.click(function(){
						$.fn.jqGalViewII.view(this,el);		   
					});
					if(i==0){
						$image.trigger('click');
						$image.siblings().trigger('mouseover');
					}
				};// end : image.onload 
				image.src = this.src;
			});
			
			$arrow.appendTo($holder);

			//  remove current images and replace with jqGalview
			$(this).after($this).remove();
		});
	};
	
	$.fn.jqGalViewII.view = function(img,el){
		if(typeof img.altImg == 'undefined') return false;
		var url = /\?imgmax/.test(img.altImg) ? img.altImg : img.altImg+'?imgmax=800';
		var $i_wh = {}; // 
		var $i_whFinal = {}; // 
		var wContainer, hContainer;
		var $w, $h, $wOrg, $hOrg, isOver = false; 

		el.loader.show();
		wContainer = el.mainImgContainer.width();
		hContainer = el.mainImgContainer.height();
		el.mainImgContainer.show();
		
		el.image.attr({src:url}).css({top:0,left:0,position:'absolute'}).hide();
		$img = new Image();
		$img.onload = function(){
			$img.onload = null;
			$w = $wOrg = $img.width;
			$h = $hOrg = $img.height;

			if ($w > wContainer) {
				$h = $h * (wContainer / $w); 
				$w = wContainer; 
				if ($h > wContainer) { 
					$w = $w * (hContainer / $h); 
					$h = hContainer; 
				}
			} else if ($h > hContainer) { 
				$w = $w * (hContainer / $h); 
				$h = hContainer; 
				if ($w > wContainer) { 
					$h = $h * (wContainer / $w); 
					$w = wContainer;
				}
			}
			el.image.css({width:$w,height:$h, marginLeft:(wContainer-$w)*.5,marginTop:(hContainer-$h)*.5})
			el.loader.fadeOut('fast',function(){el.image.fadeIn();});
		};
		$img.src = url;
		
	};
	$.fn.jqGalViewII.swapOut = function($el){
		var id = $el.attr('id') ? (' id="'+$el.attr('id')+'"') : '';
		
		var $this = $('<div' + id + '>');
		return $this;
	};
	
	$.fn.jqGalViewII.defaults = {
		getUrlBy : 0, // 0 == from parent A tag | 1 == the full size resides in another folder
		fullSizePath : null,
		prefix: 'thumbnail.',
		arrowEase:'easeout'
	};
})(jQuery);
