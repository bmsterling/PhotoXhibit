(function($){
	var service = 'flickr', to, flickrUserID = null, smugMugUserID = null, smugMugSessionId = null, pageNum = 1, finUrl;
	$(document).ready(function(){
		if(typeof $.fn.tabs == 'function'){
			$('#photo-menu > ul').tabs();//{ fxFade: true, fxSpeed: 'fast' }
		};
		$('select[name=flickr_user_id]')
		.change(function(){
			$('#flickr_userid').attr('checked','checked');
			tmp = $(':selected', this).val();
			if( tmp != '' ){
				flickrUserID = tmp;
				getFrom.flickrPhotoset();
			};
		});
		$('input[name=flickr_username]')
		.focus(function(){
			$('#flickr_usernameRb').attr('checked','checked');
		});
		$('select[name=flickr_photoset_id]')
		.change(function(){
			$('[name=search_type][value=flickr.photosets.getPhotos]').attr('checked','checked');
		});
		
		$('[name=smugmug_user_id_dd]')
		.change(function(){
			smugMugUserID = $(':selected', this).val()
			$('[name=smugmug_user_id]').val(smugMugUserID);
			getFrom.smugMugGetSession('albums');
		});
		
		$('input[name=flickr_tags]')
		.focus(function(){
			$('#flickr_tagsRb').attr('checked','checked');
		});

		$('input[name=smugmug_user_id]')
		.keyup(function(){
			var jQthis = $(this);
			jQthis.removeClass('loadingbg');
			var id = jQthis.attr('id');
			clearTimeout(to);
			to = setTimeout(function(){
				smugMugUserID = jQthis.addClass('loadingbg').val();
				getFrom.smugMugGetSession('albums');
			}, 1500);
		});

		$('input[name=flickr_username]').keyup(function(){
			var jQthis = $(this);
			var id = jQthis.attr('id');
			clearTimeout(to);
			to = setTimeout(function(){
				var value = jQthis.val();	
				var url = '<?php echo $this->getFlickrUrl();?>flickr.people.findByUsername&jsoncallback=?';
				$.ajax({
					url : url,
					data : {username : value},
					dataType : 'jsonp',
					cache:true,
					success : function(data, textStatus){
						if(data.stat == 'fail'){
							if(data.code == 1){
								showNoticeMessage('error', 'Flickr message: ' + data.message);
							}
							else{
								showNoticeMessage('error', 'Flickr message: Unknown Error');
							};
						}
						else{
							showNoticeMessage('updated', 'Got the UserID');
							flickrUserID = data.user.id;
							getFrom.flickrPhotoset();
						};
					},
					beforeSend : function(){
						showNoticeMessage('updated', 'Finding Flickr UserID');
					}
				});
			}, 1500);
		});
		
		$('input[name=search]')
		.click(function(){
			service = $(this).attr('from');
			pageNum = 1;
			getFrom[service]();
			return false;
		});
		
		$('#flickrPageNext')
		.click(function(){
			pageNum++;
			getFrom.flickr(true);
			return false;
		});
		
		$('#flickrPagePrev')
		.click(function(){
			pageNum--;
			getFrom.flickr(true);
			return false;
		});
		
		$('input[name=insertImage]')
		.click(function(){
			var lookIn = $(this).attr('from');
			var items = $('#'+lookIn+'HolderTable td.ui-selected img');
			var alignment = $('select[from='+lookIn+'][name=alignment] :selected').val();
			var size = $('select[from='+lookIn+'][name=size] :selected').val();
			var hspace = $('[from='+lookIn+'][name=hspace]').val();
			var vspace = $('[from='+lookIn+'][name=vspace]').val();
			var border = $('[from='+lookIn+'][name=border]').val();
			var cls = $('[from='+lookIn+'][name=class]').val();
			var linkit = ($('[from='+lookIn+'][name=linkit]').is(':checked')) ? 1 : 0;
			//
			items.each(function(){
				px_addPhoto(this.px_extras.url, this.px_extras[size], hspace, vspace, this.px_extras.title, border, cls, alignment, linkit)
			});

			return false;
		});
	});

	getFrom = {
		smugmugphotos : function(){
			var aid = $('#smugmug_album_id_dd :selected').val();
			if( aid == '' ){
				showNoticeMessage('error','You need to select an album for smugmug.');
			};
			this.smugmug.photos(aid);
		},
		smugmug :{
			'albums' : function(){
				$.ajax({
					url: "http://api.smugmug.com/hack/json/1.2.0/?APIKey=<?php echo $this->smugmugapi;?>&method=smugmug.albums.get&Heavy=1&NickName="+smugMugUserID+"&SessionID="+smugMugSessionId+"&JSONCallback=?",
					dataType: 'jsonp',
					cache:true,
					success : function(data, textStatus){
						with(data){
							//smugmug error controls
							if(typeof code != 'undefined'){
								if(code == 4 || code == 15 || code == 18){
									showNoticeMessage('error','SmugMug sent back a stat of "'+stat+'" with a message of "'+message+'"');
									return false;
								};
							};
							showNoticeMessage('updated', 'Ok, got them, now building the dropdown.');
							$('input[name=smugmug_user_id]').removeClass('loadingbg');
							$('#smugmug_album_id_dd').empty().append('<option selected="selected">Select one</option>');
							for(var i = 0; i < Albums.length; i++){
								$('#smugmug_album_id_dd').append('<option value="'+Albums[i]['id']+'">'+Albums[i]['Title']+' [Image Count: ' + Albums[i]['ImageCount'] + ']</option>');
							};
							$('#smugmug_album_id_dd').append('<option selected="selected">Select one</option>');

							showNoticeMessage('updated', 'Ok, Done!  Just to note, depending on the browser, the last one added may be the one that gets selected.  So be sure to select the one you want.');
							

						};
					},
					error : function(x, txt, e){
						showNoticeMessage('error','There seemed to be an error in the execution of the URL provided; please select another one and try again.  If problem presists, please submit a bug.');
					}
				});
			},
			'photos' : function(aid){
				$.ajax({

					url: 'http://api.smugmug.com/hack/json/1.2.0/?APIKey=<?php echo $this->smugmugapi;?>&method=smugmug.images.get&AlbumID='+aid+'&Heavy=1&NickName='+smugMugUserID+"&SessionID="+smugMugSessionId+"&JSONCallback=?",
					dataType: 'jsonp',
					cache:true,
					success : function(data, textStatus){
						with(data){
							//smugmug error controls
							if(typeof code != 'undefined'){
								if(code == 4 || code == 5 || code == 15 || code == 18){
									showNoticeMessage('error','SmugMug sent back a stat of "'+stat+'" with a message of "'+message+'"');
									return false;
								};
							};
							showNoticeMessage('updated', 'Ok, got them, now building the thumbnails.');

							getFrom.smugmugTable(Images)	

						};
					},
					error : function(x, txt, e){
						showNoticeMessage('error','There seemed to be an error in the execution of the URL provided; please select another one and try again.  If problem presists, please submit a bug.');
					}
				});
			}
		},
		smugMugGetSession : function(doNext){
			showNoticeMessage('updated', 'Finding SmugMug Albums for ' + smugMugUserID);
			if( !smugMugSessionId ){
				$.ajax({
					url: 'http://api.smugmug.com/hack/json/1.2.0/?APIKey=<?php echo $this->smugmugapi;?>&method=smugmug.login.anonymously&JSONCallback=?',
					dataType: 'jsonp',
					cache:true,
					success : function(data, textStatus){
						with(data){
							//smugmug error controls
							if(typeof code != 'undefined'){
								if(code == 1 || code == 5 || code == 11 || code == 18){
									showNoticeMessage('error','SmugMug sent back a stat of "'+stat+'" with a message of "'+message+'"');
									return false;
								};
							};
							showNoticeMessage('updated', 'Got the SmugMug Albums for ' + smugMugUserID);
							smugMugSessionId = Login.Session.id;
							getFrom.smugmug[doNext]();
						};
					},
					error : function(x, txt, e){
						showNoticeMessage('error','There seemed to be an error in the execution of the URL provided; please select another one and try again.  If problem presists, please submit a bug.');
					}
				});
			}
			else{
				getFrom.smugmug[doNext]();
			}
		},
		flickr : function(nextPrev){
			if(!nextPrev){
				var url = '<?php echo $this->getFlickrUrl();?>';
				var method = $('input[name=search_type]:checked').val();
	
				var by = $('[name=flickr_uploaded_by]:checked').val();
	
				switch(by){
					case 'anyone':
						break;
					case 'userid':
					case 'username':
						method = "flickr.photos.search";
						break;
				};
	
				switch(method){
					case 'flickr.photosets.getPhotos':
						var photoset_id = $('[name=flickr_photoset_id] :selected').val();
						if( photoset_id == '' ){
							alert('Need to select a Photoset');
							return false;
						};
						url += method + "&photoset_id=" + photoset_id
						break;
					case 'flickr.photos.search':
						url += method;
						var user_id = null;
						var tag = null;
						if( flickrUserID && $('[name=flickr_uploaded_by]:checked').val() != 'anyone'){
							url += user_id = "&user_id=" + flickrUserID;
						};
						var tags = $('[name=flickr_tags]').val();
						
						if( tags != '' ){
							url += tag = '&tags=' + tags;
						};
						
						if( tag == null && user_id == null ){
							alert('Need a UserID or Tags');
							return false;
						};
						break;
					default:
						url += method;
						break;
				};
				finUrl = url;
			};
			params = {};
			url = finUrl+'&per_page=50&page=' + pageNum + '&jsoncallback=?';

			//flickr.photos.search
			$.ajax({
				url : url,
				data : params,
				dataType : 'jsonp',
				cache:true,
				success : function(data, textStatus){
					if(data.stat == 'fail'){
						if(data.code == 1 || data.code == 105 ){
							showNoticeMessage('error', 'Flickr message: ' + data.message);
						}
						else{
							showNoticeMessage('error', 'Flickr message: Unknown Error');
						};
					}
					else{
						showNoticeMessage('updated', 'Got the Photos');
						
						//  all photos
						if( typeof data.photos != 'undefined' ){
							with(data.photos){
								if( page < pages ){
									$('#flickrPageNext').removeAttr('disabled');
								}
								else{
									$('#flickrPageNext').attr('disabled','disabled');
								};
								if( page > 1 ){
									$('#flickrPagePrev').removeAttr('disabled');
								}
								else{
									$('#flickrPagePrev').attr('disabled','disabled');
								};
								
								getFrom.flickrTable(photo);
							};
						};
					};
				},
				beforeSend : function(){
					showNoticeMessage('updated', 'Finding Flickr Photos');
				}
			});

		},
		flickrPhotoset : function(){
			var url = '<?php echo $this->getFlickrUrl();?>flickr.photosets.getList&jsoncallback=?';
			$.ajax({
				url : url,
				data : {user_id : flickrUserID},
				dataType : 'jsonp',
				cache:true,
				success : function(data, textStatus){
					if(data.stat == 'fail'){
						if( data.code == 1 || data.code == 105 ){
							showNoticeMessage('error', 'Flickr message: ' + data.message);
						}
						else{
							showNoticeMessage('error', 'Flickr message: Unknown Error');
						};
					}
					else{
						showNoticeMessage('updated', 'Got the PhotoSets');
						var jqselectList = $('[name=flickr_photoset_id]')
						.children()
						.filter(':not([leave=true])')
						.remove()
						.end().end();
						with(data.photosets){
							if( photoset.length == 0 ){
								$('<option disabled="disabled">No PhotoSets for '+flickrUserID+'</option>').appendTo(jqselectList);
							}
							else{
								$.each(photoset, function(i){
									$('<option value="'+photoset[i].id+'">'+photoset[i].title._content+'</option>').appendTo(jqselectList);
								});
							};
						};
					};
				},
				beforeSend : function(){
					showNoticeMessage('updated', 'Finding Flickr PhotoSets for ' + flickrUserID);
				}
			});
		},
		flickrTable : function(photos){
			$('#flickrHolder').empty();
			var $table = $('<table id="flickrHolderTable" cellpadding="0" cellspacing="0" border="0">').appendTo('#flickrHolder');
			$table = $('<tbody>').appendTo($table);
			var cols = 4
			$j = 1;
			$tr = '';
			var cnt = photos.length;
			for(var i = 0; i < cnt; i++){
				var _ = photos[i];
				if(($j % cols) == 1){
					$tr = $("<tr>").appendTo($table);
				};

				var $td = $('<td valign="middle" align="center">').appendTo($tr);
				
				var $img = $('<img border="0" src="http://farm'+photos[i]['farm']+'.static.flickr.com/'+photos[i]['server']+'/'+photos[i]['id']+'_'+photos[i]['secret']+'_s.jpg"/>')
				.appendTo($td);
				
				$img
				.toggle(function(){
					$(this).parent().addClass('ui-selected');
				},function(){
					$(this).parent().removeClass('ui-selected');
				})
				.get(0).px_extras = {
					"from" : "flickr",
					"square" : 'http://farm'+photos[i]['farm']+'.static.flickr.com/'+photos[i]['server']+'/'+photos[i]['id']+'_'+photos[i]['secret']+'_s.jpg',
					"thumbnail" : 'http://farm'+photos[i]['farm']+'.static.flickr.com/'+photos[i]['server']+'/'+photos[i]['id']+'_'+photos[i]['secret']+'_t.jpg',
					"small" : 'http://farm'+photos[i]['farm']+'.static.flickr.com/'+photos[i]['server']+'/'+photos[i]['id']+'_'+photos[i]['secret']+'_m.jpg',
					"medium" : 'http://farm'+photos[i]['farm']+'.static.flickr.com/'+photos[i]['server']+'/'+photos[i]['id']+'_'+photos[i]['secret']+'.jpg',
					"large" : 'http://farm'+photos[i]['farm']+'.static.flickr.com/'+photos[i]['server']+'/'+photos[i]['id']+'_'+photos[i]['secret']+'_b.jpg',
					"original" : 'http://farm'+photos[i]['farm']+'.static.flickr.com/'+photos[i]['server']+'/'+photos[i]['id']+'_'+photos[i]['secret']+'_o.jpg',
					"title" : photos[0]['title'],
					"url" : 'http://flickr.com/photos/'+photos[i]['owner']+'/'+photos[i]['id']+'/'
				};

				
				$('<p>'+photos[i]['title']+'</p>').appendTo($td);
								
				if($j == photos.length){
					for($k = 1; $k <= (cols-(photos.length%cols)); $k++){
						$("<td>&nbsp;</td>").appendTo($tr);
					};
				};
				$j++;
			};
			
			$("#flickrHolderTable").selectable({filter:'td'});
		},
		smugmugTable : function(photos){
			$('#smugmugHolder').empty();
			var $table = $('<table id="smugmugHolderTable" cellpadding="0" cellspacing="0" border="0">').appendTo('#smugmugHolder');
			$table = $('<tbody>').appendTo($table);
			var cols = 4
			$j = 1;
			$tr = '';
			var cnt = photos.length;
			for(var i = 0; i < cnt; i++){
				var _ = photos[i];
				if(($j % cols) == 1){
					$tr = $("<tr>").appendTo($table);
				};

				var $td = $('<td valign="middle" align="center">').appendTo($tr);
				
				var $img = $('<img border="0" src="'+photos[i]['TinyURL']+'"/>')
				.appendTo($td);
				
				$img
				.toggle(function(){
					$(this).parent().addClass('ui-selected');
				},function(){
					$(this).parent().removeClass('ui-selected');
				})
				.get(0).px_extras = {
					"from" : "smugmug",
					"square" : photos[i]['TinyURL'],
					"thumbnail" : photos[i]['ThumbURL'],
					"small" : photos[i]['SmallURL'],
					"medium" : photos[i]['MediumURL'],
					"large" : photos[i]['LargeURL'],
					"original" : photos[i]['XLargeURL'],
					"title" : photos[i]['Caption'],
					"url" : photos[i]['AlbumURL']
				};

				$('<p>'+photos[i]['Caption']+'</p>').appendTo($td);
								
				if($j == photos.length){
					for($k = 1; $k <= (cols-(photos.length%cols)); $k++){
						$("<td>&nbsp;</td>").appendTo($tr);
					};
				};
				$j++;
			};
			
			$("#smugmugHolderTable").selectable({filter:'td'});
		}
	};
	
	showNoticeMessage = function(cls, message){
		var jQthis = $('#px_message');
		jQthis.show().removeClass().addClass('fade').addClass(cls).children('p').html(message);
		Fat.fade_all();
	
		setTimeout(function(){
			jQthis.slideUp().fadeOut();
		}, 8000);
	};
	
	px_addPhoto = function(photoUrl, sourceUrl, hspace, vspace, title, border, cls, alignment, linkit) {
		if( border == '' ){
			border = 0;
		};
		if(linkit == 1){
	    		var h = 
		   		'<a href="'+photoUrl+'" title="'+title+'" class="'+cls+'">' +
		   		'<img src="'+sourceUrl+'" align="'+alignment+'" alt="'+title+'"  hspace="'+hspace+'" vspace="'+vspace+'" border="'+border+'" />' +
		   		'</a> ';
		}
		else{
	    		var h = '<img src="'+sourceUrl+'" align="'+alignment+'" alt="'+title+'"  hspace="'+hspace+'" vspace="'+vspace+'" border="'+border+'" />';
		}
		
	    var win = window.opener ? window.opener : window.dialogArguments;
		if ( !win ) win = top;
		tinyMCE = win.tinyMCE;
		if ( typeof tinyMCE != 'undefined' && tinyMCE.getInstanceById('content') ) {
			tinyMCE.selectedInstance.getWin().focus();
			tinyMCE.execCommand('mceInsertContent', false, h);
		} else if (win.edInsertContent) win.edInsertContent(win.edCanvas, h);
	
		return false;
	}
	
})(jQuery);