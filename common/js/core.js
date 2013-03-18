<?php header('Content-type: application/javascript; charset=utf-8;'); ?>
(function($){

//var baseUrl = '<?php echo '/wp-content/plugins/' . $this->baseName;?>';
var baseUrl = '<?php echo str_replace( array($_SERVER['HTTP_HOST'], "http://"), "", $this->parentFileUrl);?>';
var baseUrlGallery ='<?php echo $this->options['pluginjs'];?>';
var sessionID = null;
$(document).ready(function(){

	var jQloaderAnimation = $('#loaderAnimation');
	var jQselectList = $('#selectList');
	var jQimageList = $('#imageList');

	if($('#imageList img').size() != 0){
		try{
			jQimageList.sortable({ placeholder: "hover"});
			$('#imageList li')
			.dblclick(function(){
				var $this = $(this);
				if($this.parent('#selectList').size() != 0){
					$this.appendTo(jQimageList);
					jQimageList.sortable({ placeholder: "hover"});
				}
				else{
					$this.appendTo(jQselectList);
				};
			});
		}catch(e){}
	};
	
	$('#px_albumSelect').change(function(){
		var album_id = $(':selected', this).val();
		var album_name = $(':selected', this).text();
		 $('#px_addUpdateInput').val('');
		if( album_id==0 ){
			$('#px_deleteAlbumBtn').hide();
			$('#px_addUpdateAlbumBtn').val('Add >>');
		}
		else{
			$('#px_addUpdateInput').val(album_name);
			$('#px_deleteAlbumBtn').show();
			$('#px_addUpdateAlbumBtn').val('Update >>');
			$('#px_albumNameHolder').val(album_name);
		};		
	});

	$('#px_addUpdateAlbumBtn').click(function(){
		var album_name = $('#px_addUpdateInput').val();
		var album_id = $('#px_albumSelect :selected').val();
		
		if( album_id == 0 && album_name == ''){
			return false;
		};
		
		
		$.ajax({
			url : baseUrl,
			data : {
				"option" : "doAlbum",
				"album_name":album_name,
				"album_id":album_id
			},
			dataType: 'json',
			complete : function(){jQloaderAnimation.hide();},
			error : function(XMLHttpRequest, textStatus, errorThrown){
				var errMsg = "There was an ajax error with a status of " + textStatus + " and thrown error of " + errorThrown;
				showNoticeMessage('error',errMsg);
			},
			beforeSend : function(){jQloaderAnimation.show();},
			success : function(data){
				if( album_id == 0 ){
					showNoticeMessage('confirm',"Data Save!");
					$('#px_albumSelect').append('<option id="pxOption'+data.id+'" value="'+data.id+'">'+data.album_name+'</option>');
					$tr = $('<tr id="pxTrId'+data.id+'">').prependTo('#px_albumTable tbody')
					$tr
					.append('<td>'+data.id+'</td>')
					.append('<td><a href="admin.php?page=px_manageAlbum&amp;aid='+data.id+'">'+data.album_name+'</a></td>')
					.append('<td><a href="admin.php?page=px_manageAlbum&amp;action=edit_images&amp;aid='+data.id+'">Edit Images</a></td>')
					.append('<td><a href="admin.php?page=px_manageAlbum&amp;action=delete_album&amp;aid='+data.id+'" class="px_optDelete">Delete</a></td>')
					.css({ backgroundColor: "yellow" })
					.animate({ backgroundColor: "transparent" }, 1000);
				}
				else{
					$tr = $('#pxTrId'+data.id);
					$('#pxOption'+data.id).text(data.album_name);
					
					color = $tr.css('background-color');
					
					$tr
					.css({ backgroundColor: "yellow" })
					.animate({ backgroundColor: color }, 1000)
					.children(':nth-child(2)')
					.empty()
					.append('<a href="admin.php?page=px_manageAlbum&amp;aid='+data.id+'">'+data.album_name+'</a>');
				}
			}
		});
	});

		/**
		 *	
		 */
	$('#px_selectPlugin').change(function(){
		var $this = $(':selected',this);
		var url = $this.attr('title');
		var params = $.parseJSON(decodeURIComponent($this.attr('metadata')));
		$('#selectGalleryUrl').html('View an example at <a href="'+url+'" target="_blank">'+url+'</a>');
			
		$('#params').empty();
		if(params === undefined) return;
		$.each(params.parameters,function(i){
			var $tr = $('<tr>');
			$td = $('<td>').appendTo($tr).text(params.parameters[i].param);
			$td = $('<td>').appendTo($tr).html('<input type="text" size="30" name="'+params.parameters[i].param+'"/>');
			$td = $('<td>').appendTo($tr).text(params.parameters[i].desc);
			$('#params').append($tr);
		});			
	}); // end : $selectGallery.change(function(){

	$('#px_add_all').click(function(){
		jQselectList.children('li')
		.each(function(){
			$(this).appendTo(jQimageList);
		});//trigger('dblclick');
		jQimageList.sortable({ placeholder: "hover"});
		return false;
	});

	$('#px_remove_all').click(function(){
		jQimageList.children('li')
		.each(function(){
			$(this).appendTo(jQselectList);
		});//trigger('dblclick');
		return false;
	});
	
	/**
	 *	Set the delete link for the manage galleries page
	 */
	$('.px_optDelete').click(function(){
		if(confirm("Are you sure you want to delete this album?")){
			return true;
		}
		return false;
	});
	
	if(typeof $.fn.tabs == 'function'){
		$('#px_structureOptions > ul').tabs();//{ fxFade: true, fxSpeed: 'fast' }
	};
	//$("#px_structureFAQ").accordion();
	
	
	/**
	 *	Start Options Page Processing and functions
	 */
	 
	 jQloaderAnimation.ajaxStart(function(){jQloaderAnimation.show();});
	 jQloaderAnimation.ajaxStop(function(){jQloaderAnimation.hide();});
	
	/**
	 *	Set click event for the options page submit button
	 */
	$('#px_optionsPageSubmit').click(function(){
		var flickr_api_key_val = $('#flickr_api_key').val();
		var flickr_user_id_val = $('#flickr_user_id').val();
		var flickr_photoset_id_val = $('#flickr_photoset_id').val();
		var picasa_user_id_val = $('#picasa_user_id').val();
		var smugmug_api_key_val = $('#smugmug_api_key').val();
		var smugmug_user_id_val = $('#smugmug_user_id').val();

		var use_picasa = $('input[name=use_picasa]:checked').val();
		var use_flickr = $('input[name=use_flickr]:checked').val();
		var use_smugmug = $('input[name=use_smugmug]:checked').val();
		var use_album = $('input[name=use_album]:checked').val();
		var use_local = $('input[name=use_local]:checked').val();
		var use_browse = $('input[name=use_browse]:checked').val();
		
		var use_effectSlide = $('input[name=use_effectSlide]:checked').val();

		var options_tnimageQuality = $('#options_tnimageQuality').val();
		var options_path = $('#options_path').val();
		var options_delete =  ($('#options_delete').is(':checked')) ? 1 : 0;
		var options_original =  ($('#options_original').is(':checked')) ? 1 : 0;
		var options_MaxWidth = $('#options_MaxWidth').val();
		var options_MaxHeight = $('#options_MaxHeight').val();
		var options_imageQuality = $('#options_imageQuality').val();
		
		var options_thumbailSet = $('input[name=options_thumbailSet]:checked').val();
		var options_dropall = ($('input[name=options_dropall]').is(':checked')) ? 1 : 0;
		
		var options_thumbailW = $('#options_thumbailW').val();
		var options_thumbailH = $('#options_thumbailH').val();
		
		var options_thumbailW2 = $('#options_thumbailW2').val();
		var options_thumbailH2 = $('#options_thumbailH2').val();
		
		
		var use_manager = $('input[name=use_manager]:checked').val();
		var flash_version_multi_upload = $('input[name=flash_version_multi_upload]:checked').val();
		var none_ajax_styles = $('input[name=none_ajax_styles]:checked').val();

		

		var errors = Array();

		if(isEmpty(flickr_api_key_val) && (!isEmpty(flickr_user_id_val) || !isEmpty(flickr_photoset_id_val))){
			//showNoticeMessage('error','You are going to need a Flickr API if you are going to supply a Photoset ID or a User ID');
		};
		
		if(!isInteger(options_MaxWidth)){
			errors.push('Please Enter numbers only in the max width field');
		};
		
		if(isEmpty(options_MaxWidth)){
			errors.push('Please Enter a numbers in the max width field');
		};
		
		if(!isInteger(options_MaxHeight)){
			errors.push('Please Enter numbers only in the max height field');
		};
		
		if(isEmpty(options_MaxHeight)){
			errors.push('Please Enter a numbers in the max height field');
		};
		
		if(isEmpty(options_path)){
			errors.push('Please Enter an upload path');
		};
		
		if(isEmpty(options_imageQuality)){
			errors.push('Please Enter an upload path');
		};
		
		if(!isInteger(options_imageQuality) || parseInt(options_imageQuality) > 100){
			errors.push('Image quality needs to be a number and less then 100**');
		};


		if(isEmpty(options_thumbailW)){
			errors.push('Please Enter a thumbnail width size');
		};
		if(!isInteger(options_thumbailW)){
			errors.push('Thumbnail width size must be a number');
		};
		if(isEmpty(options_thumbailH)){
			errors.push('Please Enter a thumbnail height size');
		};
		if(!isInteger(options_thumbailH)){
			errors.push('Thumbnail height size must be a number');
		};

		if( typeof options_thumbailSet != "undefined"){
			if(isEmpty(options_thumbailW2)){
				errors.push('Please Enter a thumbnail width size for the second thumbnail');
			};
			if(!isInteger(options_thumbailW2)){
				errors.push('Thumbnail width size must be a number for the second thumbnail');
			};
			if(isEmpty(options_thumbailH2)){
				errors.push('Please Enter a thumbnail height size for the second thumbnail');
			};
			if(!isInteger(options_thumbailH2)){
				errors.push('Thumbnail height size must be a number for the second thumbnail');
			};
		};
		
		if(isEmpty(options_tnimageQuality)){
			errors.push('Please Enter an image quality for the thumbnail');
		};
		
		if(!isInteger(options_tnimageQuality) || parseInt(options_imageQuality) > 100){
			errors.push('Thumbnail image quality needs to be a number and less then 100');
		};

		
		if(errors.length > 0){
			var i = 0;
			var msg = '';
			for(i = 0; i < errors.length; i++){
				msg += errors[i] +"<br/>";
			};
			showNoticeMessage('error',msg);
			return false;
		};

		$.ajax({
			url : baseUrl,
			data : {
				"option" : "optionsSet",
				"flickr_api_key":flickr_api_key_val,
				"flickr_user_id":flickr_user_id_val,
				"flickr_photoset_id":flickr_photoset_id_val,
				"picasa_user_id":picasa_user_id_val,
				"smugmug_api_key":smugmug_api_key_val,
				"smugmug_user_id":smugmug_user_id_val,
				"use_picasa":use_picasa,
				"use_flickr":use_flickr,
				"use_smugmug":use_smugmug,
				"use_album":use_album,
				"use_local":use_local,
				"use_browse":use_browse,
				"options_path":options_path,
				"options_delete":options_delete,
				"options_original":options_original,
				"options_MaxWidth":options_MaxWidth,
				"options_MaxHeight":options_MaxHeight,
				"options_imageQuality":options_imageQuality,
				"options_thumbailSet":options_thumbailSet,

				"options_thumbailW":options_thumbailW,
				"options_thumbailH":options_thumbailH,
				
				"options_dropall":options_dropall,

				"options_thumbailW2":options_thumbailW2,
				"options_thumbailH2":options_thumbailH2,
				
				"options_tnimageQuality":options_tnimageQuality,
				
				"use_effectSlide":use_effectSlide,
				
				"use_manager":use_manager,
				"flash_version_multi_upload":flash_version_multi_upload,
				"none_ajax_styles":none_ajax_styles
			},
			complete : function(){jQloaderAnimation.hide();},
			error : function(XMLHttpRequest, textStatus, errorThrown){
				var errMsg = "There was an ajax error with a status of " + textStatus + " and thrown error of " + errorThrown;
				showNoticeMessage('error',errMsg);
			},
			beforeSend : function(){jQloaderAnimation.show();},
			success : function(){showNoticeMessage('confirm',"Data Save!");}
		});
		
		
		return false;
	});
	
	
	/**
	 *	Start Build Page Processing and functions
	 */
	
	/**
	 *	Set the width and height of all the form parts
	 */
	var px_childCnt = $('.px_child').css({width:650,float:'left'}).size();
	
	/**
	 *	Set the width of the form parts holder
	 */
	$('#px_gut').width(px_childCnt*650);
	
	/**
	 *	Set the click event to the service radio buttons
	 */
	 /*
	$('input[name=service]').click(function(){
		var $this = $(this);
		$('input[name=px_serviceHidden]').val($this.val());
		var goToWhere = $this.attr('alt');
		var goToSpot = $('#'+goToWhere).position();

		animateMe('#px_gut',-goToSpot.left,goToWhere);
	});
	*/
	/**
	 *	Set the click event to the go back links
	 */
	$('a.goBack').click(function(){
		var $this = $(this);
		var goToWhere = $(this).attr('name');

		var goToSpot = $('#'+goToWhere).position();
		goToSpot = (goToSpot.left*-1) + parseInt($('#px_gut').css('marginLeft'));

		animateMe('#px_gut',goToSpot,goToWhere);
		return false;
	});
	
	$('input[name=px_goNext]').click(function(){
		var goToWhere = $(this).attr('title');
		var commingFrom = $('input[name=px_currentScreen]').val();
		var errors = Array();
		if(goToWhere == 'px_picasaThumbnails'){
			if(commingFrom == 'px_picasaBasic'){
				var url = $('input[name=px_picasaAlbumUrl]').val();
				if(isEmpty(url)){
					showNoticeMessage('error','You need to provide a URL for your Picasa URL');
					return false;
				}
				else if(!/picasa/.test(url)){
					showNoticeMessage('error','The URL provided is not to Picasa');
					return false;
				}
				else if(!/rss/.test(url)){
					showNoticeMessage('error','The URL provided is not a RSS feed to Picasa');
					return false;
				};
				$('.px_picasaTn').attr('name', 'px_picasaBasic');
			}
			else if(commingFrom == 'px_picasaAdvance'){
				if(isEmpty($('input[name=picasa_user_id]').val())){
					errors.push('Please Enter a Picasa User ID');	
				}
				if(isEmpty($('input[name=picasa_album_id]').val())){
					errors.push('Please Enter a Picasa Album ID');	
				}				
			};
		}
		else if(goToWhere == 'px_buildFlickrThumbnails'){
			if(commingFrom == 'px_buildFlickrBasic'){
				var url = $('input[name=px_flickr_basic_url]').val();
				
				if(isEmpty(url)){
					showNoticeMessage('error','You need to provide a URL for your Flickr URL');
					return false;
				}
				else if(!/flickr/.test(url)){
					showNoticeMessage('error','The URL provided is not to Flickr');
					return false;
				}
				else if(!/rss/.test(url) && !/feeds/.test(url)){
					showNoticeMessage('error','The URL provided is not a RSS feed to Flickr');
					return false;
				};
			}
			else if(commingFrom == 'px_buildFlickrAPI'){
				if(isEmpty($('input[name=flickr_api_key]').val())){
					errors.push('Please Enter a Flickr API Key');	
				};
			};			
		}
		else if(goToWhere == 'px_buildSmugMugThumbnails'){
			if(commingFrom == 'px_buildSmugMugBasic'){
				var url = $('input[name=px_smugmug_basic_url]').val();
				if(isEmpty(url)){
					showNoticeMessage('error','You need to provide a URL for your SmugMug URL');
					return false;
				}
				else if(!/smugmug/.test(url) && !/feed/.test(url)){
					showNoticeMessage('error','The URL provided is not to SmugMug');
					return false;
				}
				else if(!/rss/.test(url) && !/feed/.test(url)){
					showNoticeMessage('error','The URL provided is not a RSS feed to SmugMug');
					return false;
				};
			}
			else if(commingFrom == 'px_buildSmugMugAdvance'){
				/*
				if(isEmpty($('input[name=picasa_user_id]').val())){
					errors.push('Please Enter a Picasa User ID');	
				}
				if(isEmpty($('input[name=picasa_album_id]').val())){
					errors.push('Please Enter a Picasa Album ID');	
				}
				*/
			};
		}
		else if(goToWhere == 'px_buildFlickrAPI'){
			if(commingFrom == 'px_buildFlickrPhotoset'){
				if(isEmpty($('input[name=flickr_photoset_id]').val())){
					errors.push('Please Enter a Flickr Photoset ID');	
				};				
			}
			else if(commingFrom == 'px_buildFlickrSearch'){
				if(isEmpty($('input[name=flickr_user_id]').val()) && isEmpty($('input[name=flickr_group_id]').val()) && isEmpty($('input[name=flickr_tags]').val())){
					errors.push('Please enter something in either "Flickr User ID", "Flickr Group ID", or "Flickr Tags" otherwise use the basic option');	
				};				
			}
		}
		else if(goToWhere == 'px_buildAlbumThumbnails'){
			if( $('#px_album_list_sm :selected').val() == 0 ){
				errors.push('Please Select an Album');	
			};
		};
		//
		switch(goToWhere){
			case 'px_buildSmugMugAdvance':
				switch(commingFrom){
					case 'px_buildSmugMugAPI':
						if(isEmpty($('input[name=smugmug_api_key]').val())){
							errors.push('Please enter a SmugMug API Key');	
						};
						break;
				};
				break;
			case 'px_buildSmugMugThumbnails':
				switch(commingFrom){
					case 'px_buildSmugMugAdvance':
						if(isEmpty($('input[name=smugmug_user_id]').val())){
							errors.push('Please enter a SmugMug User ID');	
						};
						if(isEmpty($('input[name=smugmug_album_id]').val())){
							errors.push('Please enter a SmugMug Album ID');	
						};
						break;
				};
				break;
		};
		
		if(errors.length > 0){
			var i = 0;
			var msg = '';
			for(i = 0; i < errors.length; i++){
				msg += errors[i] +"<br/>";
			};
			showNoticeMessage('error',msg);
			return false;
		};
		
		if($(this).hasClass('px_pxOptAdv')){
			$('.px_picasaTn').attr('name','px_picasaAdvance');
		}		
		else if($(this).hasClass('px_pxOptBasic')){
			$('.px_picasaTn').attr('name','px_picasaBasic');
		}		
		else if($(this).hasClass('px_pxFlickrOptBasic')){
			$('.px_flickrTn').attr('name','px_buildFlickrBasic');
		}
		else if($(this).hasClass('px_flickrPSApi')){
			$('.px_flickrTn').attr('name','px_buildFlickrPhotoset');
		}
		else if($(this).hasClass('px_flickrSApi')){
			$('.px_flickrTn').attr('name','px_buildFlickrSearch');
		}
		else if($(this).hasClass('px_flickrApiToTn')){
			$('.px_flickrTn').attr('name','px_buildFlickrAPI');
		}
		else if($(this).hasClass('px_pxSmugMugOptBasic')){
			$('.px_smugMugTn').attr('name','px_buildSmugMugBasic');
		}
		else if($(this).hasClass('px_buildSmugMugAdvance')){
			$('.px_smugMugTn').attr('name','px_buildSmugMugAdvance');
		};
		
		switch(goToWhere){
			case 'px_go':
				var jqcheckedservice = $('input[name=service]:checked');
				if(jqcheckedservice.size()==0){
					showNoticeMessage('error',"Please select a service");
					return false;
				};
				$('input[name=px_serviceHidden]').val(jqcheckedservice.val());
				goToWhere = jqcheckedservice.attr('alt');
				break;
			case 'px_picasaOpt':
				var jqselectVal = $('#px_picasaOptionsDD :selected').val();
				if(isEmpty(jqselectVal)){
					showNoticeMessage('error',"Please select a option");
					return false;
				};
				goToWhere = jqselectVal;
				break;
			case 'px_flickrOpt':
				var jqselectVal = $('#px_flickrOptionsDD :selected').val();
				if(isEmpty(jqselectVal)){
					showNoticeMessage('error',"Please select a option");
					return false;
				};
				goToWhere = jqselectVal;
				break;
			case 'px_smugMugOpt':
				var jqselectVal = $('#px_smugMugOptionsDD :selected').val();
				if(isEmpty(jqselectVal)){
					showNoticeMessage('error',"Please select a option");
					return false;
				};
				goToWhere = jqselectVal;
				break;
		};
		
		var goToSpot = $('#'+goToWhere).position();
		goToSpot.left += (parseInt($('#px_gut').css('marginLeft'))*-1);
		animateMe('#px_gut',-goToSpot.left,goToWhere);
		
		
		return false;
	});
	
	$('.px_getPhotos').click(function(){
		var url = null, error = Array(), service = $('input[name=px_serviceHidden]').val(), option = '';
		
		switch(service){
			case 'picasa':
				option = $('#px_picasaOptionsDD :selected').val();
				switch(option){
					case 'px_picasaBasic':
						url = $('input[name=px_picasaAlbumUrl]').val();
						if(isEmpty(url)){
							error.push('Some how you got this far without providing a Picasa URL, provide a URL for your Picasa URL');
						};
						
						url = url.replace(/alt=rss/g,"alt=json");
						
						break;
					case 'px_picasaAdvance':
						var uid = $('#picasa_user_id').val();
						if(uid == ''){
							error.push('Some how you got this far without providing a picasa user id, please provide one');
						};
						var aid = $('#picasa_album_id').val();
						if(aid == ''){
							error.push('Some how you got this far without providing a picasa album id, please provide one');
						};
						url  = "http://picasaweb.google.com/data/feed/api/user/"+uid+"/album/"+aid+"?kind=photo&alt=json";
						break;
					default:
						error.push('For some reason the Picasa options select menu was just used, go back and select basic or advanced');
				};
				break;
			case 'flickr':
				option = $('#px_flickrOptionsDD :selected').val();
				switch(option){
					case 'px_buildFlickrBasic':
						url = $('input[name=px_flickr_basic_url]').val();
						if(isEmpty(url)){
							error.push('Some how you got this far without providing a Flickr URL, provide a URL for your Flickr URL');
						};
						url +="&format=json&jsoncallback=?"
						break;
					case 'px_buildFlickrPhotoset':
				
						var key = '<?php echo $this->flickrapi;?>';//$('#flickr_api_key').val();
						var pid = $('#flickr_photoset_id').val();
						url = 'http://api.flickr.com/services/rest/';
						url +='?format=json&api_key='+key;
						url +='&method=flickr.photosets.getPhotos&photoset_id='+pid;
						url +='&jsoncallback=?';
						if(key == ''){
							error.push('An Flickr API Key is needed');
						};
						if(pid == ''){
							error.push('You do need a photoset id if you a going to pull in a Photoset');
						};
					
						break;
					case 'px_buildFlickrSearch':
						var key = '<?php echo $this->flickrapi;?>';//$('#flickr_api_key').val();
						url = 'http://api.flickr.com/services/rest/';
						url +='?format=json&api_key='+key;

						var flickr_user_id = $('#flickr_user_id').val();
						var flickr_group_id = $('#flickr_group_id').val();
						var flickr_tags = $('#flickr_tags').val();
						var flickr_tag_mode = $('#flickr_tag_mode option:selected').val();
						var flickr_sort = $('#flickr_sort').val();

						if	(
								flickr_user_id == '' &&
								flickr_group_id == '' &&
								flickr_tags == ''
							){
							url += '&method=flickr.photos.getRecent';
						}
						else{
							url += '&method=flickr.photos.search';
						};

						 if (flickr_user_id !='') url += '&user_id=' + flickr_user_id;
						 if (flickr_group_id !='') url += '&group_id=' + flickr_group_id;
						 if (flickr_tags !='') url += '&tags=' + flickr_tags;
						 if (flickr_tag_mode !='') url += '&tag_mode=' + flickr_tag_mode;
						 if (flickr_sort !='') url += '&sort=' + flickr_sort;

						url +='&jsoncallback=?';
						if(key == ''){
							error.push('An Flickr API Key is needed');
						};
						break;
					default:
						error.push('For some reason the Flickr options select menu was just used, go back and select something');
				};
				break;
			case 'smugmug':
				/*
				option = $('#px_smugMugOptionsDD :selected').val();
				switch(option){
					case 'px_buildSmugMugBasic':
						url = $('input[name=px_smugmug_basic_url]').val();

						if(isEmpty(url)){
							error.push('Some how you got this far without providing a SmugMug URL, provide a URL for your SmugMug URL');
						};
						
						break;
					case 'px_buildSmugMugAdvance':
						smugMugUrl = 'http://api.smugmug.com/hack/json/1.2.0/?APIKey=<?php echo $this->smugmugapi;?>&method=smugmug.images.get&AlbumID='+$('input[name=smugmug_album_id]').val()+'&Heavy=1&NickName='+$('input[name=smugmug_user_id]').val();
						service += 'A';
	

						url = "http://api.smugmug.com/hack/json/1.2.0/?APIKey=<?php echo $this->smugmugapi;?>&method=smugmug.login.anonymously&JSONCallback=?";
						
						break;
					default:
						error.push('For some reason the SmugMug options select menu was just used, go back and select something');
				};
				*/
				smugMugUrl = 'http://api.smugmug.com/hack/json/1.2.0/?APIKey=<?php echo $this->smugmugapi;?>&method=smugmug.images.get&AlbumID='+$('input[name=smugmug_album_id]').val()+'&Heavy=1&NickName='+$('input[name=smugmug_user_id]').val();
				service += 'A';
	
				url = "http://api.smugmug.com/hack/json/1.2.0/?APIKey=<?php echo $this->smugmugapi;?>&method=smugmug.login.anonymously&JSONCallback=?";

				break;
			case 'album':
				url = baseUrl + '?option=getPhotos&service=album&url='+$('#px_album_list_sm :selected').val();
				break;
			case 'locally':
				url = baseUrl + '?option=getPhotos&service=locally&url='+'n/a';
				break;
			case 'browse':
				url = baseUrl + '?option=getPhotos&service=browse&url='+$('#browseBasic_url').val();
				break;
			default:
				return false;			
		};
		
		if(url == '' || url === undefined || url == null || isEmpty(url)){
			error.push('Need that url.  Go ahead, add it.  I need it.');
		};
		
		if(error.length > 0){
			var i = 0;
			var msg = '';
			for(i = 0; i < error.length; i++){
				msg += error[i] +"<br/>";
			};
			showNoticeMessage('error',msg);
			return false;
		};

		showNoticeMessage('updated','Loading your images, please wait...');

		if(service == 'browsable'){
			//getImagesFromDir(url);
		}
		else{

			$.ajax({
				url: url,
				dataType: (service == 'service') ? 'json' : 'jsonp',
				cache:true,
				success : function(data, textStatus){
					with(data){
						//smugmug error controls
						if(typeof code != 'undefined'){
							if(code == 15 || code == 4 || code == 5){
								showNoticeMessage('error','SmugMug sent back a stat of "'+stat+'" with a message of "'+message+'"');
								return false;
							}
							else if(code == 2){
								showNoticeMessage('error','Flickr sent back a stat of "'+stat+'" with a message of "'+message+'"');
								return false;
							};
						}
						else if(typeof result != 'undefined'){
							if(result == 'error'){
								showNoticeMessage('error','There was an error processing that url.');
								return false;
							}
							else if(result == 'noimage'){
								showNoticeMessage('error','There was no images in the album you selected.');
								return false;
							};
						};
						
						if(service == 'smugmugA'){
							$.ajax({
								url: smugMugUrl + "&SessionID="+Login.Session.id+"&JSONCallback=?",
								dataType: 'jsonp',
								cache:true,
								success : function(data, textStatus){
									processData(data, service);
								},
								error : function(x, txt, e){
								}
							});
						}
						else{
							processData(data, service);
						};	
					};
				},
				error : function(x, txt, e){
					showNoticeMessage('error','There seemed to be an error in the execution of the URL provided; please select another one and try again.  If problem presists, please submit a bug.');
				}
			});
		};

		return false;
	});	//	end : $('.px_getPhotos').click
	
	
	
	processData = function(data, service){
		//console.log(data);
		$('#px_notice').show().text('Ok, got the data, going to process it now.');
		imageGroup = Array();
		var tmpArray = Object();
		//picasa flickr smugmug  album locally browse
		switch(service){
			case 'picasa':
				var obj = data['feed']['entry'];
				$.each(obj,function(i){
					if($('select[name=px_picasaThumbnailSelect] :selected').val() > 2){
						var tn = obj[i]['media$group']['media$content'][0]['url']+'?imgmax='+$('select[name=px_picasaThumbnailSelect] :selected').val()
					}
					else{
						var tn = obj[i]['media$group']['media$thumbnail'][$('select[name=px_picasaThumbnailSelect] :selected').val()]['url']
					};

					tmpArray = {
						"t"	: tn,
						"f"	: obj[i]['media$group']['media$content'][0]['url']+'?imgmax='+$('select[name=px_picasaFullSizeSelect] :selected').val(),
						"a"	: obj[i]['media$group']['media$description']['$t'],
						"i"	: 0
					};
					imageGroup.push(tmpArray);
				});
				break;
			case 'flickr':
				var tn = Array('_s','_t','_m','','_b','_o');
				var tnSize = $('#bsg_flickr_thumbnailSelect option:selected').val();
				var full = Array('_s','_t','_m','','_b','_o');
				var fullSize = $('#px_flickr_largeSelect option:selected').val();
				var obj;
				
				//console.log(data);
// http://farm3.static.flickr.com/2129/2139449877_49ac04459e_o.jpg
// http://farm3.static.flickr.com/2129/2139449877_279bbe13a7_o.jpg
				switch($('#px_flickrOptionsDD :selected').val()){
					case 'px_buildFlickrBasic':
						obj = data['items'];
				
						$.each(obj, function(i){
							tmpArray = {
								"t"	: obj[i]['media']['m'].replace(/_m.jpg/, tn[tnSize]+'.jpg'),
								"f"	: obj[i]['media']['m'].replace(/_m.jpg/, tn[fullSize]+'.jpg'),
								"a"	: obj[i]['title'],
								"i"	: 0
							};
							
							imageGroup.push(tmpArray);
						});
						break;
					case 'px_buildFlickrPhotoset':
						obj = data['photoset']['photo'];
				
						$.each(obj, function(i){
							tmpArray = {
								"t"	: 'http://farm'+obj[i]['farm']+'.static.flickr.com/'+obj[i]['server']+'/'+obj[i]['id']+'_'+obj[i]['secret']+tn[tnSize]+'.jpg',
								"f"	: 'http://farm'+obj[i]['farm']+'.static.flickr.com/'+obj[i]['server']+'/'+obj[i]['id']+'_'+obj[i]['secret']+tn[fullSize]+'.jpg',
								"a"	: obj[i]['title'],
								"i"	: 0
							};
							imageGroup.push(tmpArray);
						});
						break;
					case 'px_buildFlickrSearch':
						obj = data['photos']['photo'];
				
						$.each(obj, function(i){
							tmpArray = {
								"t"	: 'http://farm'+obj[i]['farm']+'.static.flickr.com/'+obj[i]['server']+'/'+obj[i]['id']+'_'+obj[i]['secret']+tn[tnSize]+'.jpg',
								"f"	: 'http://farm'+obj[i]['farm']+'.static.flickr.com/'+obj[i]['server']+'/'+obj[i]['id']+'_'+obj[i]['secret']+tn[fullSize]+'.jpg',
								"a"	: obj[i]['title'],
								"i"	: 0
							};
							imageGroup.push(tmpArray);
						});
						break;
				};
				break;
			case 'smugmug':
				var tnSize = $('#px_smugMugThumbnailSelect :selected').val();
				var fullSize = $('select[name=px_smugMugFullSizeSelect] :selected').val();

				$.each(data,function(i){
					tmpArray = {
						"t"	: data[i]['MEDIA:GROUP'][0]['MEDIA:CONTENT'][tnSize]['ATTRIBUTES']['URL'],
						"f"	: data[i]['MEDIA:GROUP'][0]['MEDIA:CONTENT'][fullSize]['ATTRIBUTES']['URL'],
						"a"	: data[i]['TITLE'][0]['VALUE'],
						"i"	: 0
					};
					imageGroup.push(tmpArray);
				});
				break;
			case 'smugmugA':
				//console.log(data);
				var tnSize = $('#px_smugMugThumbnailSelect :selected').val();
				var fullSize = $('select[name=px_smugMugFullSizeSelect] :selected').val();
				
				var tn = Array('TinyURL','ThumbURL','SmallURL', 'MediumURL');
				var l = Array('','','','MediumURL','LargeURL','XLargeURL');
	
				$.each(data.Images,function(i){
					tmpArray = {
						"t"	: data.Images[i][tn[tnSize]],
						"f"	: data.Images[i][l[fullSize]],
						"a"	: data.Images[i]['Caption'],
						"i"	: 0
					};
					imageGroup.push(tmpArray);
				});
				break;
			case 'locally':
				console.log(data);
				$.each(data,function(i){
					var str = data[i]['guid'];
					var liof = str.lastIndexOf('.');
					var imgUrl = Array();
					imgUrl.push(str.slice(0,liof));
					imgUrl.push('.thumbnail');
					imgUrl.push(str.slice(liof));
					
					imgUrl = imgUrl.join('');

					tmpArray = {
						"t"	: imgUrl,
						"f"	: data[i]['guid'],
						"a"	: (data[i]['post_content']) ? data[i]['post_content'] : data[i]['post_title'],
						"i"	: 0
					};
					imageGroup.push(tmpArray);
				});
				break;
			case 'browse':
				var tnSize = $('#px_smugMugThumbnailSelect :selected').val();
				var fullSize = $('select[name=px_smugMugFullSizeSelect] :selected').val();
				$.each(data,function(i){
					tmpArray = {
						"t"	: data[i]['img'][1],
						"f"	: data[i]['img'][0],
						"a"	: '',
						"i"	: 0
					};
					imageGroup.push(tmpArray);
				});
				break;
			case 'album':
				var tnarray = Array('_tn','_ltn','');
				var tn = $('select[name=px_albumThumbnailSelect] :selected').val();
				var path = $('#px_album_list_sm :selected').attr('meta');
				$.each(data,function(i){
					data[i]['albumPhotos_alt'] = (data[i]['albumPhotos_alt'] == 'null') ? '' : data[i]['albumPhotos_alt'];
					tmpArray = {
						"t"	: path + '/' + data[i]['albumPhotos_file'] + tnarray[tn] + '.' + data[i]['albumPhotos_ext'],
						"f"	: path + '/' + data[i]['albumPhotos_file'] + '.' + data[i]['albumPhotos_ext'],
						"a"	: data[i]['albumPhotos_alt'],
						"i"	: data[i]['albumPhotos_id']
					};
					imageGroup.push(tmpArray);
				});
				break;
			default:
		};
		//console.log(imageGroup);
		processImageArray();
	};
	
	processImageArray = function(){
		$('#px_notice').text('Done processing, now going to push out the images.');
		jQselectList.empty();
		for( var i = 0; i < imageGroup.length; i++ ){
			
			var meta = "{";
			meta += '"t":"'+imageGroup[i]['t']+'",';
			meta += '"f":"'+imageGroup[i]['f']+'",';
			meta += '"i":"'+imageGroup[i]['i']+'",';
			meta += '"a":"'+imageGroup[i]['a']+'"';
			meta += "}";
			
			var image = $('<img src="'+imageGroup[i]['t']+'"/>').attr('metadata',encodeURIComponent(meta));
			var $img = $('<li>').append(image)
			.dblclick(function(){
				var $this = $(this);
				if($this.parent('#selectList').size() != 0){
					$this.appendTo(jQimageList);
					jQimageList.sortable({ placeholder: "hover"});
				}
				else{
					$this.appendTo(jQselectList);
				};
			})
			.appendTo(jQselectList);			
		};
		$('#px_notice').text('Done pushing out the images.');
		setTimeout(function(){$('#px_notice').fadeOut();}, 4000);
		location.hash = 'px_add_all';
	};

	/**
	 *	Here we are setting the change event to the picasa stored user ids
	 *	select menu and append that value to the picasa userid input field
	 */
	$('#picasa_user_id_dd').change(function(){
		var $this = $(':selected',this);
		$('#picasa_user_id').empty().val($this.val());
		$('#bsg_picasa_grab').trigger('click');
	});  //  end : $picasa_user_id_dd.change

	/**
	 *	Here we are setting the change event to the smugmug stored user ids
	 *	select menu and append that value to the smugmug userid input field
	 */
	$('#smugmug_user_id_dd').change(function(){
		var $this = $(':selected',this);
		$('#smugmug_user_id').empty().val($this.val());
		$('#px_smugmugAlbum_grab').trigger('click');
	});  //  end : $smugmug_user_id_dd.change

	/**
	 *	Here we are setting the change event to the smugmug stored API
	 *	select menu and append that value to the smugmug userid input field
	 */
	$('#smugmug_api_key_dd').change(function(){
		var $this = $(':selected',this);
		$('#smugmug_api_key').empty().val($this.val());
	});  //  end : $smugmug_api_key_dd.change

	/**
	 *	
	 */
	$('#smugmug_album_id_dd').change(function(){
		var $this = $(':selected',this);
		$('#smugmug_album_id').empty().val($this.val());
	});  //  end : $smugmug_album_id_dd.change
		
	
	/**
	 *	Here we are setting the change event to the flickr stored photoset
	 *	select menu and append that value to the photoset input field
	 */
	$('#flickr_user_id_dd').change(function(){
		var $this = $(':selected',this);
		$('#flickr_user_id').empty().val($this.val());
	});  //  end : $flickr_user_id_dd.change
	

	/**
	 *	Here we are setting the change event to the flickr stored photoset
	 *	select menu and append that value to the photoset input field
	 */
	$('#flickr_photoset_id_dd').change(function(){
		var $this = $(':selected',this);
		$('#flickr_photoset_id').empty().val($this.val());
	});  //  end : $flickr_photoset_id_dd.change
		
	
	/**
	 *	Here we are setting the change event to the flickr stored api keys
	 *	select menu and append that value to the api key input field
	 */
	$('#flickr_api_key_dd').change(function(){
		var $this = $(':selected',this);
		$('#flickr_api_key').empty().val($this.val());
	});  //  end : $flickr_api_key_dd.change
		
	
	/**
	 *	
	 *	
	 */
	$('#picasa_album_id_dd').change(function(){
		var $this = $(':selected',this);
		$('#picasa_album_id').empty().val($this.val());
	});  //  end : $picasa_album_id_dd.change
		
	
	/**
	 *	
	 *	
	 */
	$('#bsg_picasa_grab').click(function(){
		var uid = $('#picasa_user_id').val();
		if(uid == ''){
			showNoticeMessage('error','Need a picasa user id');
			return false;
		};
		var url  = "http://picasaweb.google.com/data/feed/api/user/"+uid+"?kind=album&alt=json";
		$('#bsg_picasa_grab_notice').text('Grabbing your album list from Picasa, please wait');
		$.ajax({
			url:url,
			/*data:'option=getAlbum&url='+encodeURIComponent(url),*/
			dataType: 'jsonp',
			cache:true,
			success : function(data){
				$('#bsg_picasa_grab_notice').text('Ok, got them, now building the dropdown.');
				with(data.feed){
					$('#picasa_album_id_dd').empty().append('<option selected="selected">Select one</option>');
					for(var i = 0; i < entry.length; i++){
						$('#picasa_album_id_dd').append('<option value="'+entry[i]['gphoto$name']['$t']+'">'+entry[i]['title']['$t']+'</option>');
					};
					$('#picasa_album_id_dd').append('<option selected="selected">Select one</option>');
				};
				$('#bsg_picasa_grab_notice').text('Ok, Done!  Just to note, depending on the browser, the last one added may be the one that gets selected.  So be sure to select the one you want.');
			}
		});
		return false;
	});  //  end : $('#bsg_picasa_grab').click
		
	
	/**
	 *	
	 *	
	 */
	$('#px_smugmugAlbum_grab').click(function(){
		var uid = $('#smugmug_user_id').val();
		var api = "<?php echo $this->smugmugapi;?>";
		var un = $('#smugmug_user_id').val();
		if(uid == ''){
			showNoticeMessage('error','Need a smugmug user id');
			return false;
		};
		$('#px_smugmugAlbum_grab_notice').text('Grabbing your album list from SmugMug, please wait');
		$.ajax({
			url:"http://api.smugmug.com/hack/json/1.2.0/?APIKey=<?php echo $this->smugmugapi;?>&method=smugmug.login.anonymously&JSONCallback=?",
			/*data:'option=getAlbumListSmugMug&api='+api+'&un='+un,*/
			dataType: 'jsonp',
			cache:true,
			success : function(data){
				//console.log(data);
				if( typeof data.result != 'undefined' && data.result == 'error'){
					handle_error(data);
					return false;	
				};
				sessionID = data.Login.Session.id;
				$.ajax({
					url:"http://api.smugmug.com/hack/json/1.2.0/?APIKey=<?php echo $this->smugmugapi;?>&method=smugmug.albums.get&Heavy=1&NickName="+un+"&SessionID="+data.Login.Session.id+"&JSONCallback=?",

					dataType: 'jsonp',
					cache:true,
					success : function(data){
						$('#px_smugmugAlbum_grab_notice').text('Ok, got them, now building the dropdown.');
						with(data){
							$('#smugmug_album_id_dd').empty().append('<option selected="selected">Select one</option>');
							for(var i = 0; i < Albums.length; i++){
								$('#smugmug_album_id_dd').append('<option value="'+Albums[i]['id']+'">'+Albums[i]['Title']+' [Image Count: ' + Albums[i]['ImageCount'] + ']</option>');
							};
							$('#smugmug_album_id_dd').append('<option selected="selected">Select one</option>');
						};
						$('#px_smugmugAlbum_grab_notice').text('Ok, Done!  Just to note, depending on the browser, the last one added may be the one that gets selected.  So be sure to select the one you want.');
					}
				});
			}
		});
		return false;
	});  //  end : $('#px_smugmugAlbum_grab').click
	
	
	$('#px_buildSubmit').click(function(){
		//get all images in image list
		var jQimg = $('#imageList img');
		
		var gid = $('#px_gidHidden').val();
		var curplugin_id = $('#px_pluginid').val();
		
		var pluginId = $('#px_selectPlugin :selected').val();
		var galleryName = $('input[name=px_galleryName]').val();
		var sendData = "option=processGallery&gallery_id="+gid;
		var error = Array();
		var imageArray = Array();
		var dataStructure = $('input[name=px_structure]:checked').val();

		// start : check for make sure the important stuff is done
		if(jQimg.size() < 2){
			error.push('Really?  You want an image/photo gallery with less then two image?  How about you add one or two more?');
		};
		if(pluginId==0){
			error.push('Ok, you are trying to build a gallery for your blog, so selecting a gallery plugin from the "Select the gallery style" select menu will help you get to that point.');
		};
		if(galleryName==''){
			error.push('Naming the gallery will make things easier for you later on, so do yourself a favor and put some text in the "Name your gallery" field');
		};
		if(dataStructure==''){
			error.push('Please select a structure you want.');
		};
		
		if(error.length > 0){
			var i = 0;
			var msg = '';
			for(i = 0; i < error.length; i++){
				msg += error[i] +"<br/>";
			};
			showNoticeMessage('error',msg);
			return false;
		};
		// lets disable the set gallery button just to make sure it is not clicked again.
		$(this).attr('disabled',true);

		//  Lets run thru all the images with have and put them in an array
		jQimg.each(function(i){
			imageArray.push($(this).attr('metadata'));
		});

		// build our sendData string for sending to the server
		sendData += '&images=['+imageArray.join(",")+']';
		//console.log(sendData);
		
		sendData += '&gallery_title='+encodeURIComponent(galleryName);
		sendData += '&plugin_id='+pluginId;
		sendData += '&curplugin_id='+curplugin_id;
		sendData += '&gallery_structure='+dataStructure;
		
		if($('input[name=px_album_uselarge]').is(':checked')){
			sendData += '&gallery_uselarge=1';
		}
		else{
			sendData += '&gallery_uselarge=0';
		};
		
		if($('input[name=px_structure_tableVar'+dataStructure+']').size() != 0){
			sendData += '&gallery_extra='+$('input[name=px_structure_tableVar'+dataStructure+']').val();
		}
		else{
			sendData += '&gallery_extra=null';
		}
		
		var paramArray = Array();
		var tmpArray = Array();
		$('#params input').each(function(){
			var $this = $(this);
			var val = $this.val();
			if(val !=''){
				if(val.match(/\{(.*)\}/)){//check to see if it is an object format
					tmpArray.push(''+$this.attr('name')+''+':'+val+'');
				}
				else if(isInteger(val)){
					tmpArray.push(''+$this.attr('name')+''+':'+val+'');
				}
				else{
					tmpArray.push(''+$this.attr('name')+''+':"'+val+'"');
					val = '"'+val+'"';
				};
				paramArray.push('"'+$this.attr('name')+'"'+':'+val+'');
			};
		});

		// finish building out our sendData variable
		sendData += '&gallery_params='+'{'+paramArray.join(",")+'}';

		// lets block the UI for till processing is done.
		$.blockUI();

		// out ajax call to the server
		$.ajax({
			url: baseUrl,
			data : sendData,
			dataType : 'json',
			type : 'POST',
			//type : 'GET',
			success : function(data, textStatus){
				if(data.result == 'done'){
					buildPreview(data);
				}
				else if(data.result == 'error'){
					$.unblockUI();
					showNoticeMessage('error','There was an error in the processing; please try again.  If this presists, please submit a bug so we can get this fixed');
					$('#px_buildSubmit').attr("disabled",false);
				}
					$('#px_buildSubmit').attr("disabled",false);
			},
			error : function(x, txt, e){
				try{
					console.log(x);
					console.log(txt);
					console.log(e);
				}catch(e){}
			}
		});
		
		return false;
	});  //  end : $('#px_buildSubmit').click
	
	var jqpx_gallery = $('#px_gallery');
	
	buildPreview = function(data){
		jqpx_gallery.show();
		location.hash = 'px_gallery';
		
		$('#px_css').remove();
		var c = document.createElement('link');
		c.id = 'px_css';
		c.type = 'text/css';
		c.media = 'screen';
		c.rel = 'stylesheet';
		c.href = baseUrl+'?option=css&gid='+data.id+'&' + new Date().getTime();
		$('head')[0].appendChild(c);
	
		$('a.editLinks').each(function(){
			if( $('#px_pluginid').val() == '' ){
				var href = $(this).attr('href');
				$(this).attr('href', href+data.id);
			};
		});

		$('#px_gidHidden').val(data.id);
		$('div:eq(1)',jqpx_gallery).empty();
		
		var newP = $('<p><?php _e('Below you will find a preview of your gallery, if you need to edit the images alt text or edit the styles click on the following links.  If you need to add more images just repeat the process');?></p>').prependTo(jqpx_gallery);
		setTimeout(function(){newP.fadeOut(function(){newP.remove();});}, 4000);

		switch(data.structure){
			case '0': // list
				buildOutList(data.images, $('div:eq(1)',jqpx_gallery), data.id, data.title, data.gallery);
				break;
			case '1': // table with text on bottom
				buildOutTable(data.images, $('div:eq(1)',jqpx_gallery), data.id, data.title, data.gallery, 0, data.cols);
				break;
			case '2': // table no text
				buildOutTable(data.images, $('div:eq(1)',jqpx_gallery), data.id, data.title, data.gallery, 1, data.cols);
				break;
			case '3': // div with text on bottom
				buildOutDiv(data.images, $('div:eq(1)',jqpx_gallery), data.id, data.title, data.gallery, 0, data.cols);
				break;
			case '4': // div not text
				buildOutDiv(data.images, $('div:eq(1)',jqpx_gallery), data.id, data.title, data.gallery, 1, data.cols);
				break;
		};

		$.getScript(baseUrlGallery+data.gallery+"/"+data.gallery+'.js?'+new Date().getTime(), function(){
			if( data.gallery == 'lightBox' || data.gallery == 'thickbox' ||  data.gallery == 'lightboxbe'){
				eval('$("#px'+data.id+' a").'+data.gallery+'('+$.toJSON(data.params)+')');
			}
			else{
				eval('$("#px'+data.id+'").'+data.gallery+'('+$.toJSON(data.params)+')');
			};
		});
		
		// ok, everything is done, so let unblock the UI
		$.unblockUI();
	};

	var t = $('#ex4 div.jqmdMSG');
	$('.editTextLink').click(editTextLinkFunc);
	$('.deleteImageLink').click(deleteImageLinkFunc);
	
});
	
editTextLinkFunc = function(){
	var url = $(this).attr('href')+'&'+new Date().getTime();
	buildDialogBox(url);
	return false;
};
	
deleteImageLinkFunc = function(){
	var url = $(this).attr('href')+'&'+new Date().getTime();
	var imageid = $(this).attr('imageid');
	if(confirm("Are you sure you want to delete this image?")){
		$.get(url,{option:'delete_image'},function(){
			$('table[imageid='+imageid+']').remove();
		});
	};
	return false;
};
	
buildDialogBox = function(url){
	
	$('#px_modalBox').remove();
	
	var jqmb = $('<div id="px_modalBox" class="jqmDialog jqmdWide"><div class="jqmdTL"><div class="jqmdTR"><div class="jqmdTC">Edit Dialog</div></div></div><div class="jqmdBL"><div class="jqmdBR"><div class="jqmdBC"><div class="jqmdMSG"><p>Please wait... </p></div></div></div></div><input type="image" src="dialog/close.gif" class="jqmdX jqmClose imagereplace" /></div>');
	var jqtarget = $('div.jqmdMSG', jqmb);
	
	$('body').append(jqmb);
	var strUrl;
		jqmb.jqm({
			ajax: url,
			target: jqtarget,
			modal: true, /* FORCE FOCUS */
			onHide: function(h) { 
				jqtarget.html('Please Wait...');  // Clear Content HTML on Hide.
				h.w.fadeOut(888,function(){
					h.o.remove();
					h.w.remove();
				}); // hide window
			},
			onLoad: set_edit_images_form,
		    overlay: 30
	    }).jqmShow(); 
}

/*

<div id="ex4" class="jqmDialog jqmdWide"><div class="jqmdTL"><div class="jqmdTR"><div class="jqmdTC">Edit Dialog</div></div></div><div class="jqmdBL"><div class="jqmdBR"><div class="jqmdBC"><div class="jqmdMSG"><p>Please wait... </p></div></div></div></div><input type="image" src="dialog/close.gif" class="jqmdX jqmClose imagereplace" /></div>

*/

set_edit_images_form = function(){
	 $('input.jqmdX')
	  .hover(
	    function(){ $(this).addClass('jqmdXFocus'); }, 
	    function(){ $(this).removeClass('jqmdXFocus'); })
	$('#px_editImageSubmit').click(function(){
		var albumPhotos_id = $('#px_imageEdit_id').val();
		var albumPhotos_alt = $('#albumPhotos_alt').val();
		var albumPhotos_tags = $('#albumPhotos_tags').val();
		var albumPhotos_isactive = $('input[name=albumPhotos_isactive]:checked').val();
		var albumPhotos_desc = $('#albumPhotos_desc').val();

		$.get(baseUrl,
			 {
				 option:'edit_image_single',
				 albumPhotos_id:albumPhotos_id,
				 albumPhotos_alt:albumPhotos_alt,
				 albumPhotos_tags:albumPhotos_tags,
				 albumPhotos_isactive:albumPhotos_isactive,
				 albumPhotos_desc:albumPhotos_desc
			 },
			 function(){
				var jqtable = $('table[imageid='+albumPhotos_id+']');
				if(albumPhotos_alt.length > 0){
					$('tr:eq(1) td',jqtable).text('Image Alt/Title: ' + albumPhotos_alt);
				};
				if(albumPhotos_tags.length > 0){
					$('tr:eq(2) td',jqtable).text('Image Tags: ' + albumPhotos_tags);
				};
				txt = (albumPhotos_isactive==1) ? 'true' : 'false'
				$('tr:eq(3) td',jqtable).text('Is Active: ' + txt);
				
				if(albumPhotos_desc.length > 0){
					$('tr:eq(4) td',jqtable).text('Description: ' + albumPhotos_desc);
				};
					jqtable.css({ backgroundColor: "yellow" })
					.animate({ backgroundColor: 'transparent' }, 1000);
					$('#edit_image_msg').show().css({ backgroundColor: "yellow" })
					.animate({ backgroundColor: 'transparent' }, 1000);
			 });
		
		return false;
	});
};

buildOutList = function(images, appendto, id, title, cls){
	$ul = $('<ul id="px'+id+'" title="'+title+'">').appendTo(appendto);
	var cnt = images.length;
	for(var i = 0; i < cnt; i++){
		var _ = images[i];
		$('<li><a href="'+_.f+'" title="'+_.a+'" class="'+cls+'" rel="px'+id+'"><img src="'+_.t+'" title="'+_.a+'" alt="'+_.a+'" border="0"/></a></li>').appendTo($ul);
	};
};


buildOutDiv = function(images, appendto, id, title, cls, look){
	$div = $('<div id="px'+id+'" title="'+title+'">').appendTo(appendto);
	var cnt = images.length;
	for(var i = 0; i < cnt; i++){
		var _ = images[i];
		$c = $('<div><a href="'+_.f+'" title="'+_.a+'" class="'+cls+'" rel="px'+id+'"><img src="'+_.t+'" title="'+_.a+'" alt="'+_.a+'" border="0"/></a></div>').appendTo($div);
		if(look == 0){
			$('<p>'+_.a+'</p>').appendTo($c);
		};
	};
};

buildOutTable = function(images, appendto, id, title, cls, look, cols){
	$j = 1;
	$tr = '';
	$table = $('<table id="px'+id+'" title="'+title+'" border="0" cellspacing="0" cellpadding="0">').appendTo(appendto);
	var cnt = images.length;
	for(var i = 0; i < cnt; i++){
		var _ = images[i];
		if(($j % cols) == 1){
			$tr = $("<tr>").appendTo($table);
		};

		var $td = $('<td valign="top" align="center"><a href="'+_.f+'" title="'+_.a+'" class="'+cls+'" rel="px'+id+'"><img border="0" src="'+_.t+'" title="'+_.a+'" alt="'+_.a+'"/></a></td>').appendTo($tr);
		
		if(look == 0){
			$('<p>'+_.a+'</p>').appendTo($td);
		};
		
		if($j == images.length){
			for($k = 1; $k <= (cols-(images.length%cols)); $k++){
				$("<td>&nbsp;</td>").appendTo($tr);
			};
		};
		$j++;
	};
};

get_image_from_upload = function(data){
	data = $.parseJSON(data);
	jQimageTable = $('#imageTable tbody tr td:eq(0)');
	
	var jqlinks = $('<td colspan="2" align="right" style="height:15px;">[<a href="<?php echo $this->parentFileUrl;?>?option=delete_image&iid='+data.albumPhotos_id+'" imageid="'+data.albumPhotos_id+'" class="deleteImageLink">Delete Image</a>] | <a href="<?php echo $this->parentFileUrl;?>?option=edit_image_form&iid='+data.albumPhotos_id+'" class="editTextLink">Edit text</a> | <a href="<?php echo $this->parentFileUrl;?>?option=edit_image_form&iid='+data.albumPhotos_id+'" class="editImageLink">Edit Image</a></td>');

	$('.deleteImageLink',jqlinks).click(deleteImageLinkFunc);
	$('.editTextLink',jqlinks).click(editTextLinkFunc);
	
	jQTable = $('<table cellpadding="0" cellspacing="0" border="0" imageid="'+data.albumPhotos_id+'">').prependTo(jQimageTable);
	
	 $('<tr>').append(jqlinks).prependTo(jQTable);
	jQtr = $('<tr>')
			.append('<td>Description: None Yet</td>').prependTo(jQTable);
	
	jQtr1 = $('<tr>')
			.append('<td>Is Active: true</td>').prependTo(jQTable);
	
	jQtr2 = $('<tr>')
			.append('<td>Image Tags: None Yet</td>').prependTo(jQTable);
	
	jQtr3 = $('<tr>')
			.append('<td>Image Alt/Title: None Yet</td>').prependTo(jQTable);
			
	jQtr4 = $('<tr>')
			.append('<td rowspan="5" align="left" valign="top" width="105" style="width:105; overflow:auto;"><img src="'+data.path+'/'+data.albumPhotos_file+'.'+data.albumPhotos_ext+'"/></td>')
			.append('<td>Image Name: '+data.albumPhotos_file+'</td>').prependTo(jQTable);
	
	
	
	jQTable.css({ backgroundColor: "yellow" })
					.animate({ backgroundColor: 'transparent' }, 1000)

};


/**
 *	Helper Functions
 */
 
animateMe = function(what,where,who){
	setCurrentScreen(who);
<?php if ($this->vars['use_effectSlide']==1) :?>
	$(what).animate({
		marginLeft : where
	}, 1000, 'easeInQuad');
<?php else: ?>
	$(what).css({marginLeft:where});
<?php endif; ?>
};

goBackTo = function(to){
	$('input[name=px_goBackToHidden]').val($('input[name=px_currentScreen]').val());
};

setCurrentScreen = function(current){
	goBackTo();
	$('input[name=px_currentScreen]').val(current);
};

function isInteger (s){
	var i;

	if (isEmpty(s))
		if (isInteger.arguments.length == 1) return 0;
	else return (isInteger.arguments[1] == true);
		for (i = 0; i < s.length; i++){
			var c = s.charAt(i);
	     	if (!isDigit(c)) return false;
		};
	return true;
};

function isEmpty(s){
      return ((s == null) || (s.length == 0))
};

function isDigit (c){
	return ((c >= "0") && (c <= "9"));
};

var imageGroup = Array();

/**!
 * @preserve Color animation 20120928
 * http://www.bitstorm.org/jquery/color-animation/
 * Copyright 2011, 2012 Edwin Martin <edwin@bitstorm.org>
 * Released under the MIT and GPL licenses.
 */

(function($) {
	/**
	 * Check whether the browser supports RGBA color mode.
	 *
	 * Author Mehdi Kabab <http://pioupioum.fr>
	 * @return {boolean} True if the browser support RGBA. False otherwise.
	 */
	function isRGBACapable() {
		var $script = $('script:first'),
				color = $script.css('color'),
				result = false;
		if (/^rgba/.test(color)) {
			result = true;
		} else {
			try {
				result = ( color != $script.css('color', 'rgba(0, 0, 0, 0.5)').css('color') );
				$script.css('color', color);
			} catch (e) {
			}
		}

		return result;
	}

	$.extend(true, $, {
		support: {
			'rgba': isRGBACapable()
		}
	});

	var properties = ['color', 'backgroundColor', 'borderBottomColor', 'borderLeftColor', 'borderRightColor', 'borderTopColor', 'outlineColor'];
	$.each(properties, function(i, property) {
		$.Tween.propHooks[ property ] = {
			get: function(tween) {
				return $(tween.elem).css(property);
			},
			set: function(tween) {
				var style = tween.elem.style;
				var p_begin = parseColor($(tween.elem).css(property));
				var p_end = parseColor(tween.end);
				tween.run = function(progress) {
					style[property] = calculateColor(p_begin, p_end, progress);
				}
			}
		}
	});

	// borderColor doesn't fit in standard fx.step above.
	$.Tween.propHooks.borderColor = {
		set: function(tween) {
			var style = tween.elem.style;
			var p_begin = [];
			var borders = properties.slice(2, 6); // All four border properties
			$.each(borders, function(i, property) {
				p_begin[property] = parseColor($(tween.elem).css(property));
			});
			var p_end = parseColor(tween.end);
			tween.run = function(progress) {
				$.each(borders, function(i, property) {
					style[property] = calculateColor(p_begin[property], p_end, progress);
				});
			}
		}
	}

	// Calculate an in-between color. Returns "#aabbcc"-like string.
	function calculateColor(begin, end, pos) {
		var color = 'rgb' + ($.support['rgba'] ? 'a' : '') + '('
				+ parseInt((begin[0] + pos * (end[0] - begin[0])), 10) + ','
				+ parseInt((begin[1] + pos * (end[1] - begin[1])), 10) + ','
				+ parseInt((begin[2] + pos * (end[2] - begin[2])), 10);
		if ($.support['rgba']) {
			color += ',' + (begin && end ? parseFloat(begin[3] + pos * (end[3] - begin[3])) : 1);
		}
		color += ')';
		return color;
	}

	// Parse an CSS-syntax color. Outputs an array [r, g, b]
	function parseColor(color) {
		var match, triplet;

		// Match #aabbcc
		if (match = /#([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})/.exec(color)) {
			triplet = [parseInt(match[1], 16), parseInt(match[2], 16), parseInt(match[3], 16), 1];

			// Match #abc
		} else if (match = /#([0-9a-fA-F])([0-9a-fA-F])([0-9a-fA-F])/.exec(color)) {
			triplet = [parseInt(match[1], 16) * 17, parseInt(match[2], 16) * 17, parseInt(match[3], 16) * 17, 1];

			// Match rgb(n, n, n)
		} else if (match = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color)) {
			triplet = [parseInt(match[1]), parseInt(match[2]), parseInt(match[3]), 1];

		} else if (match = /rgba\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9\.]*)\s*\)/.exec(color)) {
			triplet = [parseInt(match[1], 10), parseInt(match[2], 10), parseInt(match[3], 10),parseFloat(match[4])];

			// No browser returns rgb(n%, n%, n%), so little reason to support this format.
		}
		return triplet;
	}
})(jQuery);



	
	/**
	 *	usable notice
	 */
showNoticeMessage = function(cls, message){
	var jQthis = $('#px_message');
	var jQthis2 = $('#px_message2');
	jQthis.show().removeClass().addClass('fade').addClass(cls).children('p').html(message);
	jQthis2.show().removeClass().addClass('fade').addClass(cls).children('p').html(message);
	jQthis.animate( { backgroundColor: '#ffffe0' }, 300).animate( { backgroundColor: '#fffbcc' }, 300).animate( { backgroundColor: '#ffffe0' }, 300).animate( { backgroundColor: '#fffbcc' }, 300);

	setTimeout(function(){
		jQthis.slideUp().fadeOut();
		jQthis2.slideUp().fadeOut();
	}, 8000);
};

handle_error = function(data){
	with(data){
		showNoticeMessage('error','There was an error in the processing; <br/>' + errorArray[errorType]);
	};
};

errorArray = {
	'no_fopen' : 'Your server does not support "allow_url_fopen" which is used to handle the data exchange between your server and the service you are trying to interact with.  Sadly this service does not have an alternate route to getting that information.',
	'NoEncode' : 'Encoding of the data recieve failed and there is not obvious reason.'
};

})(jQuery);