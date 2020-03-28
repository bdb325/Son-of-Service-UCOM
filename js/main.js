$(document).ready(function(){
	
	// Prevent some top menu items from page clicks
	$('#about').attr('href','#').css({'cursor':'default'}).click(function(){
		return false;
	});
	$('#programs').attr('href','#').css({'cursor':'default'}).click(function(){
		return false;
	});
	$('#get_involved').attr('href','#').css({'cursor':'default'}).click(function(){
		return false;
	});
	$('#news-events').attr('href','#').css({'cursor':'default'}).click(function(){
		return false;
	});
			
	$('ul.sf-menu').superfish({ 
            delay:       1000,                            // one second delay on mouseout 
            animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
            speed:       'fast',                          // faster animation speed 
            autoArrows:  true,                           // disable generation of arrow mark-up 
            dropShadows: true                            // disable drop shadows 
   }); 
	
	$("a.video").fancybox({
				'padding'					: 20,
				'autoScale'				: false,
				'autoPlay'				: 1,
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic',
				'title'						: this.title,
				'titleShow'				: true,
				'titlePosition'		: 'outside',
				'width' 					: 640,
				'height'					: 390

			});
		
	$("a.ytvideo").click(function() {
		$.fancybox({
				'padding'		: 0,
				'autoScale'		: false,
				'autoPlay'		: 1,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic',
				'title'			: this.title,
				'titleShow'		: true,
				'titlePosition'	: 'inside',
				'width'			: 680,
				'height'		: 495,
				'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
				'type'			: 'swf',
				'swf'			: {
				'wmode'		: 'transparent',
				'allowfullscreen'	: 'true'
				}
			});

		return false;
	
	});


if($('#home-slideshow')){
	$('#home-slideshow').cycle({ 
		fx:     'cover',
		pause:    1,
		delay: -2000,
		speed: 8000,
		speedIn: 1000,
		speedOut: 200,
		timeout:  4000, 
		pager:  '#slideshow-nav',
		pauseOnPagerHover: true 
		
	});
}
	
	
	/*
	// example for the form inputs based off of the label associated with the input
	
	$('form input, form textarea').example(function(){	
		return $('label[for="'+$(this).attr('id')+'"]').text();
	});

	*/

	$('form input, form textarea').each(function(){
		if($(this).attr('type')!='submit' ){
		
			$('label[for="'+$(this).attr('id')+'"]').css({'visibility':'hidden', 'fontSize':'85%','color':'#888'});
				
			 if ($(this).val() == '') {
				$(this).val($('label[for="'+$(this).attr('id')+'"]').text());	
			 }
				
			$(this).focus(function() {
				 $(this).val('');
				$('label[for="'+$(this).attr('id')+'"]').css({'visibility':'visible', 'fontSize':'85%','color':'#888'});
			
			});
				
			$(this).blur(function() {
				if ($(this).val() == '') {
					$(this).val($('label[for="'+$(this).attr('id')+'"]').text());	
					$('label[for="'+$(this).attr('id')+'"]').css({'visibility':'hidden', 'fontSize':'85%','color':'#888'});		
				}
			});
	
			$(this).change(function() {		
					$('label[for="'+$(this).attr('id')+'"]').css({'visibility':'hidden', 'fontSize':'85%','color':'#888'});	
			});
		}
	});
	
	
	
	//set class for links to external sites and other document types
	$('#content a[href^="http://"]').addClass('external').attr('target', '_blank');
	$('#content a[href^="https://"]').addClass('external').attr('target', '_blank');
	$('#content a[href^="http://ucomgr"]').removeClass('external').attr('target', '_self');
	$('#header a[href^="https://npo.networkforgood.org"]').removeClass('external').attr('target', '_self');
	$('#content a[href^="https://npo.networkforgood.org"]').removeClass('external').attr('target', '_self');
	$('#content a[href$=".pdf"]').addClass('pdf').attr('target','_blank');
	$('#content a[href$=".ppt"]').addClass('powerpoint').attr('target','_blank');
	$('#content a[href$=".doc"]').addClass('word').attr('target','_blank');
	$('#content a[href$=".xls"]').addClass('excel').attr('target','_blank');
	$('#content a[href$=".csv"]').addClass('excel').attr('target','_blank');
	$('#content a.remove_external').removeClass('external').attr('target', '_blank');
	$('#content a.gs-title').attr('target', '_self'); // google search results
	
	// GALLERY LIGHTBOX
	$('#gallery a:has(img)').attr('rel', 'gallery').fancybox({
			cyclic				:true,
			overlayColor	: '#000',
			transitionIn	:'elastic',
			transitionOut	:'elastic'
	
	});

	$("a.gallery").fancybox();
	
	$('a.gallery_album_img').click(function() {
		$.fancybox.showActivity();		
		$.getJSON($(this).attr('href'), function(data){			
			//console.log(data);
			$.fancybox(data, {
				cyclic			:true,
				overlayColor	: '#000',
				type            : 'image',
				transitionIn	:'elastic',
				transitionOut	:'elastic'
			});	
		});
		return false;
	});

	 
	 
	 // ROUNDED IMAGES
	// any image that has a class roundborder
	$('img.roundborder').each(function(){
		$div = $('<div/>').addClass('rounded_image round_10').css('background',"url('"+$(this).attr('src')+"') no-repeat");
		$(this).wrap($div);
		
	}); 


	// HIDE-SHOW 
	$('.view_details').click(	
		function(){
			var toggleHide = 'images/templates/hide.gif';
			var toggleShow = 'images/templates/view.gif';
			var eDiv = $('div.'+$(this).attr('rel'));
			var eImg = $(this).children('img');
			
		if(eDiv.is(':hidden')){
				$(this).children('img').attr('src', toggleHide);
				eDiv.show('slow');
				
			}								
			
		else if(eDiv.is(':visible')){
				$(this).children('img').attr('src', toggleShow);
				eDiv.hide('slow');
				
			}
		
		 $(this).blur();
		return false;				
	});

$('.gsc-control').css({width:'800px'}); 

$('#search-submit').hover(
	function(){
		$(this).css({'cursor':'pointer'});
	},
	function(){
		$(this).css({'cursor':'default'});
	}
);
	
$('#email-input').focus(function(){
	$(this).val('');
});


// BLOG
// toggle the comments
$('a.view_comments').each(function(){
	var count = $(this).parent('.links').next('.comments').find('.comment').length;
	$(this).text($(this).text()+' ('+count+')');
}).click(function(){
	$(this).trigger('toggle', true);
	return false;
}).bind('toggle', function(event, jumpTo){
	$link = $(this);
	// slide the comments into place with a callback
	$(this).parent('.links').next('.comments').slideToggle('fast',function(){
		// toggle view/leave with hide
		text = $link.text();
	console.log('text ' + text);	
		
		if(text.indexOf("View/Leave")>=0){
			text = text.replace("View/Leave","Hide");
			if(jumpTo)
				$link.trigger('jumpTo');
		} else {
			text = text.replace("Hide","View/Leave");
			// dont need a scroll to since we are already at the links
		}
		$link.text(text);
	});
	return false;	
}).bind('jumpTo', function(){
	$.scrollTo($(this).parent(),'fast');	
});




// if there's only one blog post show the comments automatically

if($('div.blog_post').length==1){
	$('div.blog_post .comments').css({display : 'block'});
	//$('div.blog_post').find('a.view_comments').trigger('toggle');

}


// SUBMITTING COMMENTS
$('.comment_form').submit(function(){
	if(!$(this).find('input[name="email"]').val()){
		alert('You must supply your email address');
		return false;
	} else if(!$(this).find('textarea').val()){
		alert('You must supply a comment');
		return false;
	}
	// save the parent div.comments for inserting new comment to proper place
	var $comments = $(this).parents('.comments');
	var i = $(this).find('input[name="i"]').val() * 1;
	var new_i = i;
	new_i = new_i + 1;
	
	var form_data = $(this).serialize();
	$.ajax({
		url:'blog_includes/ajax_comment.php',
		data: form_data,
		type: "POST",
		beforeSend: function(){
			$('body').css('cursor','wait');
			$('.comment_form input, .comment_form textarea').attr('disabled','disabled');
		},
		success: function(data){
			if(data!="0"){
				// insert the comment
				if($('.comment:last',$comments).length){
					$('.comment:last',$comments).after(data);
				}else if($('.none',$comments).length){
					$('.none',$comments).replaceWith(data);
				}else{
			
					window.location.reload();// if there's neither of the two options just refresh cause I don't know whats going on
					
				}	
				// update the i count
				$('input[name^="i"]',$comments).val(new_i);

				// now update the comment link
				var text = $comments.prev('.links').children('a.view_comments').text();
				if(text.indexOf("(")>=0){
					text = text.replace(/\(\d+\)/, "("+i+")")
				} else {
					text += ' ('+i+')';
				}
				$link.text(text);
			} else {
				alert('Sorry, but there was an error and you comment could not be posted at this time. Please try again later');
			}
			$('body').css('cursor','auto');
			$('.comment_form input, .comment_form textarea').removeAttr('disabled').not('input[type="submit"]').not('input[type="hidden"]').val('');
		}
	});

	return false;
	});
	
	
	
	$('#archives-blog li.year').click(function(){
		$(this).children('ul').toggle();
	}).find('li.month').click(function(){
		$(this).children('ul').toggle();
		return false;
	}).find('a').bind('click',function(e){
		e.stopPropagation();
	});

	// DIALOG LINKS
	$('a.dialog').click(function(){
		// do a dialog for the video embed
		makeDialog('<h3><img src="layout_imgs/loading_bar.gif" alt="loading" /> Loading '+$(this).attr('title')+'</h3><p>please wait</p>', $(this).attr('title'));
		var element_rel = $(this).attr('name');
		// ajax in the data
		$('#made_dialog').load($(this).attr('href')+(element_rel ? ' '+element_rel : ''), function(rsp){
			// animate the containers to show everything
			$(this).parent().css('width','705px').animate( {
				top: $(this).parent().offset().top - (screen.height/4) + 20,
				left: '50%',
				marginLeft: -($(this).width() / 2)
			}, 'fast');
		});

		return false;
	});

	
	

}); // end document ready



function makeGoogleMap(address){
	var base = "http://maps.google.com/maps?f=q&hl=en&geocode=&time=&date=&ttype=&q=";
	return base + escape(address);
}


function makeDialog(text, dialog_title, buttons, width, height, hideTitleBar){
	if(!buttons){
		buttons = {
			Ok: function() {
				$(this).dialog('close');
			}
		}
	}

	$('<div id="made_dialog">'+text+'</div>').dialog({
		title: dialog_title,
		dialogClass: hideTitleBar ? 'hide_title' : 'alert',
		bgiframe: true,
		modal: true,
		stack:true,
		autoOpen:true,
		width: width ? width : 460,
		minHeight: height ? height : 220,
		draggable: true,
		resizable: true,
		buttons: buttons,
		close: function(event, ui){
			$(this).remove();
		}
	});
}

window.alert = function(txt){
	makeDialog(txt, 'The page said:');
}

//CATCH CONSOLE.LOG FOR NO-FIREBUG
if (typeof console == 'undefined' || typeof console.log == 'undefined') { console = { log : function (text) { return false; } } }

