/* IE8 Console Log Fallback Below */
if(typeof console === "undefined") {
    console = {
        log : function () {}
    }
}
/* IE8 Console Log Fallback Above */

/* MOBILE DETECT */


	



/* YOUTUBE API BELOW */
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
/* YOUTUBE API ABOVE */

/* MAIN FEATURED ARTICLE VIDEO CLASS */
function youtubePlayer() {

	/* Default content sliding animation in millisecs */
	var _contentSlideAnimationSpeed = 500;

	/* Default width of video */
	var _videoWidth = '100%';

	/* Default height of video */
	var _videoHeight = '100%';

	/* Default playback quailty */
	var _playbackQuality = 'large';

	var _videoId;

	var _videoElement;
	var _contentContainer;

	var _youtubeEvents = {
		'-1': 'unstarted',
		'0': 'ended',
		'1': 'playing',
		'2': 'paused',
		'3': 'buffering',
		'5': 'video cued'
	};

	function initYoutubeVideo() {
		if(!_videoId) {
			return;
		}
			
		var videoElementId = 'YTPlayer-'+_videoId;

		
		var	player = new YT.Player(videoElementId, {
			height: _videoHeight,
			width: _videoWidth,
			videoId: _videoId,
			playerVars: {
	            wmode: "transparent",
	            rel: 0,
	            autohide: 1,
	            showinfo: 0,
	            modestbranding: 1,
	            theme: 'dark',
	            controls: 0,
	            iv_load_policy: 3
	        },
			events: {
				'onReady': onPlayerReady,
				'onStateChange': onPlayerStateChange
			}
		});
		
		_videoElement = $('#'+videoElementId);
		_contentContainer = _videoElement.closest('article').find('.content');

	}

	function onPlayerReady(event) {
		event.target.setPlaybackQuality(_playbackQuality);
		//console.log('player ready');
	}

	function onPlayerStateChange(event) {
		switch(_youtubeEvents[event.data]) {
			case 'playing':
				hideContent();
				break;
			case 'paused':
			case 'ended':
				showContent();
				break;
		}
	}

	function hideContent() {
		var height = _contentContainer.height();

		_contentContainer.animate({'bottom': -height+'px'},500, function() {
			$(this).hide();
		});
	}

	function showContent() {
		var height = _contentContainer.height();
		_contentContainer.css('bottom', -height+'px');
		_contentContainer.show();
		_contentContainer.animate({'bottom': 0},500);
	}


	function setYoutubeVideoId(videoId) {
		_videoId = videoId;
	}

	function setPlaybackQuality(playbackQuality) {
		_playbackQuality = playbackQuality;
	}

	return {

		setYoutubeVideoId: function(videoId) {
			setYoutubeVideoId(videoId);
		},

		setPlaybackQuality: function(playbackQuality) {
			setPlaybackQuality(playbackQuality);
		},

		showContent: function() {
			showContent();
		},

		hideContent: function() {
			hideContent();
		},

		init: function() {
			initYoutubeVideo();
		}

	}

}

/* SITE CLASS */
function Site() {
	var youtubePlayerObjects = [];

	var breakpoints = [1200, 1024, 768, 320];
	var currentBreakpoint;

	var compiledTemplate;
	var offset = 6;
	var ajaxReady = true;
	var ajaxParams = {
		'action': 'load-filter'
	};

	function toggleMainMenu(state) {
		var toggleMenu = $('#mainmenu .toggle-menu');
		var ul = $('#mainmenu ul');

		if(state == 'open') {
			toggleMenu.removeClass('toggle-closed');
			ul.removeClass('mainmenu-closed');
		}
		else {
			toggleMenu.addClass('toggle-closed');
			ul.addClass('mainmenu-closed');
		}
	}

	function toggleSubMenu(state) {
		var toggleMenu = $('.submenu .toggle-submenu');
		var ul = $('.submenu ul');

		if(state == 'open') {
			toggleMenu.removeClass('toggle-closed');
			ul.removeClass('submenu-closed');
		}
		else {
			toggleMenu.addClass('toggle-closed');
			ul.addClass('submenu-closed');
		}
	}

	function initToggleMenu() {
		var toggleMenu = $('#mainmenu .toggle-menu');
		var ul = $('#mainmenu ul');

		/* Initial show hide menu */
		if($(window).width() < 1200) {
			toggleMenu.addClass('toggle-closed');
			ul.addClass('mainmenu-closed');
		}
		else {
			ul.removeClass('mainmenu-closed');
		}

		/* Toggle-menu click action */
		toggleMenu.click(function() {
			if(toggleMenu.hasClass('toggle-closed')) {
				//toggleMenu.removeClass('toggle-closed');
				//ul.removeClass('mainmenu-closed');
				toggleSubMenu('close');
				toggleMainMenu('open');
			}
			else {
				//toggleMenu.addClass('toggle-closed');
				//ul.addClass('mainmenu-closed');
				toggleMainMenu('close');
			}
		});

		/* Window resize show hide menu */
		$(window).resize(function() {
			if($(window).width() < 1200 && toggleMenu.hasClass('toggle-closed')) {
				ul.addClass('mainmenu-closed');
			}
			else {
				ul.removeClass('mainmenu-closed');
			}
		});	
	}

	function initToggleSubMenu() {
		var toggleMenu = $('.submenu .toggle-submenu');
		var ul = $('.submenu ul');

		/* Initial show hide menu */
		if($(window).width() < 1200) {
			toggleMenu.addClass('toggle-closed');
			ul.addClass('submenu-closed');
		}
		else {
			ul.removeClass('submenu-closed');
		}

		/* Toggle-menu click action */
		toggleMenu.click(function() {
			if(toggleMenu.hasClass('toggle-closed')) {
				//toggleMenu.removeClass('toggle-closed');
				//ul.removeClass('submenu-closed');
				toggleMainMenu('close');
				toggleSubMenu('open');
			}
			else {
				//toggleMenu.addClass('toggle-closed');
				//ul.addClass('submenu-closed');
				toggleSubMenu('close');
			}
		});

		/* Window resize show hide menu */
		$(window).resize(function() {
			if($(window).width() < 1200 && toggleMenu.hasClass('toggle-closed')) {
				ul.addClass('submenu-closed');
			}
			else {
				ul.removeClass('submenu-closed');
			}
		});	
	}

	/*
	function loadImages() {
		$('img[data-desktop-src], img[data-mobile-src]').each(function() {
			var attributeSrc = (displayType == 'mobile') ? 'data-mobile-src' : 'data-desktop-src';
			var newSrc = $(this).attr(attributeSrc);
			if($(this).attr('src') != newSrc) {
				$(this).attr('src', newSrc);
			}
		});
	}
	*/

	/*
	function initialLoadImage() {
		if($(window).width() <= 640) {
			displayType = 'mobile';
			loadImages();
		}
		else {
			displayType = 'desktop';
			loadImages();
		}
	}

	function initWindowResizeDetection() {

		function detectImageSwitch() {
			if($(window).width() <= 640 && displayType != 'mobile') {
				displayType = 'mobile';
				loadImages();
			}
			else if($(window).width() > 640 && displayType != 'desktop') {
				displayType = 'desktop';
				loadImages();
			}
		}
		

		$(window).resize(function() {
			detectImageSwitch();
		});
	}
	*/


	function loadImage(breakpoint) {
		//make the selector string
		var selectors = [];
		for(var i = 0; i < breakpoints.length; i ++) {
			selectors.push('img[data-'+breakpoints[i]+'-src]');
		}
		var selector_str = selectors.join(', ');

		$(selector_str).each(function() {
			//var index = breakpoints.indexOf(breakpoint);
			var index = $.inArray(breakpoint, breakpoints);

			/* if has breakpoint src, set the src
			   else find nearest larger breakpoint src, set the src */
			for(var i = index; i >= 0; i--) {
				var attr = $(this).attr('data-'+breakpoints[i]+'-src');
				if(typeof attr !== typeof undefined && attr !== false) {
					if(attr === $(this).attr('src')) {
						break;
					}
					
					$(this).attr('src', attr);
					break;
				}
			}

			//if still no src, find nearest smaller breakpoint src
			if(!$(this).attr('src').length) {
				for(var i = index; i < breakpoints.length; i++) {
					var attr = $(this).attr('data-'+breakpoints[i]+'-src');
					if(typeof attr !== typeof undefined && attr !== false) {
						$(this).attr('src', attr);
						break;
					}
				}
			}

		});
	}

	function setLayoutImages() {
		var window_width = $(window).width();

		for(var i = 0; i < breakpoints.length; i ++) {
			
			//find nearest smaller breakpoint to window width
			if(i == (breakpoints.length - 1) || window_width >= breakpoints[i]) {
				//do nothing if same breakpoint
				if(currentBreakpoint === breakpoints[i]) {
					break;
				}

				currentBreakpoint = breakpoints[i];
				loadImage(breakpoints[i]);
				break;
			}
		}
	}

	function initLoadImage() {
		setLayoutImages();

		$(window).resize(function() {
			setLayoutImages();
		});
	}
	

	function toggleSubCategories(){

		//var active = $('.').hasClass('');
		$('.sub-category-switcher').on('click', function(){
			//console.log('im clicked');
			var newSubCat = $(this).attr('id');
			$('.sub-category-container').hide();
			var currentSubCat = $('.selected').find('a').attr('id');
			//console.log(newSubCat , currentSubCat);
			$('section#'+currentSubCat+'-container').hide();
			$('section#'+newSubCat+'-container').show();
			$('.selected').removeClass('selected');
			$(this).parent().addClass('selected');
			return false;

		});
	}

	/* 
	jQuery.ajax({
	    type: 'POST',
	    url: '/wp-admin/admin-ajax.php',
	    data: ajaxParams,
	    dataType: "json",
	    success: function(response) {
	        console.log(response);
	    }
	});
	*/

	function initShowMore() {
		$('#btn-show-more').click(function(event) {
			event.preventDefault();
			//console.log('clicked');

			if(ajaxReady === false) {
				return;
			}

			ajaxReady = false;
			var params = jQuery.extend(true, {}, ajaxParams);
			params['offset'] = offset;

			$.ajax({
	            type: "POST",
	            url: "/wp-admin/admin-ajax.php",
	            data: params,
	            dataType: "json",
	            success: function(data) {
	            	console.log(data);
	            	if(data.length === 0) {
	            		$('#btn-show-more').hide();
	            		return;
	            	}

	                var wrapper = {posts: data};
	                $('#view-all-container').append(compiledTemplate(wrapper));
	                $('#view-all-container').append($('#btn-show-more'));
	                offset += data.length
	                ajaxReady = true;
	            },
	            error: function(request, status, errorThrown) {
	                //console.log(wrapper);
	            }
	        });

		});
	}

	function shareButtonClick() {
		$('.social li a').each(function() {
			$(this).click(function(event) {
				event.preventDefault();
				window.open($(this).attr('href'), "share", "height=400,width=600");
			});
		});
	}

	/*
	function detectMobile() {
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			$('body').addClass('mobile');
		}
	}
	*/

	return {
		init: function() {

			$(document).ready(function() {
				//compile handlebar template
				compiledTemplate = Handlebars.compile($('#small-article-template').html());

				//initialize breakpoint based image loading
				initLoadImage();

				//initialize toggle main menu
				initToggleMenu();

				//initialize toggle sub menu
				initToggleSubMenu();

				//initialize small article switcher
				toggleSubCategories();

				//view all show more ajax
				initShowMore();

				//share onclick init
				shareButtonClick();

				//detectMobile();
			});
		},
		youtubePlayerObjects: youtubePlayerObjects,
		appendToAjaxParam: function(obj) {
			if(obj === null || typeof obj !== 'object') {
				return;
			}

			for (var key in obj) {
				if (obj.hasOwnProperty(key)) {
					ajaxParams[key] = obj[key];
				}
			}
		}
	}

}

var site = new Site();
site.init();


/* YOUTUBE INIT FUNCTION BELOW */
function onYouTubeIframeAPIReady() {
	if(!site.youtubePlayerObjects.length) {
		//console.log('youtubePlayerObjects is empty.');
		return;				
	}else {
		//console.log('youtube init');
	}
	
	for (var i = 0; i < site.youtubePlayerObjects.length; i++) {
		site.youtubePlayerObjects[i].init();
	}
}
/* YOUTUBE INIT FUNCTION ABOVE */




