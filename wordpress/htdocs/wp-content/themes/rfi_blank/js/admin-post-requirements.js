var requirementsFunctions = {};
var errors = {};



jQuery(document).ready(function($) {
	
	requirementsFunctions.featureImageRequired = function() {
	    var checked_radio = $('#categorychecklist').find('input[type=radio]:checked');
	    var img = $('#postimagediv').find('img');
	    
	    if(checked_radio.val() === '6') {
	    	delete errors['featureImageRequired'];
	    	delete errors['featureImageSizeRequired'];
	    	return;
	    }

	    if(img.length === 0) {
	    	errors['featureImageRequired'] = 'Featured Image is Required.';
	    	return;
	    }
	    
	    delete errors['featureImageRequired'];
	    
	    var src = img.attr('src');
	    var srcArray = src.split('/');
	    srcArray[srcArray.length - 1] = srcArray[srcArray.length - 1].replace(/-([0-9]+)x([0-9]+)/i,'');
	    var newSrc = srcArray.join('/');
	    var tempImg = new Image();
	    tempImg.onload = function() {
	    	if(this.width < 800 || this.height < 450) {
	    		errors['featureImageSizeRequired'] = 'Featured Image dimensions need to be at least 800x450.';
	    		displayErrorMessages();
	    		return;
	    	}
	    	
	    	delete errors['featureImageSizeRequired'];
	    }
	    tempImg.src = newSrc;

	}

	requirementsFunctions.categoryRequired = function() {
	    var checked_radio = $('#categorychecklist').find('input[type=radio]:checked');
	    if(checked_radio.length === 0 || checked_radio.val() === '1') {
	    	errors['categoryRequired'] = 'Categroy is Required. Category cannot be Uncategorized.';
	    	return;
	    }
	    
	    delete errors['categoryRequired'];
	}


	function checkRequirements() {
		
		for(var key in requirementsFunctions) {
			requirementsFunctions[key]();
		}
		displayErrorMessages();
	}

	function displayErrorMessages() {
		if($.isEmptyObject(errors)) {
			$('#requirements-message').removeClass('error').hide();
	        $('#publish').removeAttr('disabled');
			return;
		}

		var message = '<ul>';
		for (var key in errors) {
			if (errors.hasOwnProperty(key)) {
				message += '<li><span>'+errors[key]+'</span></li>';
			}
		}
		message += '</ul>';
		$('#requirements-message').show().addClass("error").html(message);
        $('#publish').attr('disabled','disabled');
	}


	function changeFeatureImagelabel() {
		$('#postimagediv').find('h3 span').html('Thumbnail Image');
		$('#postimagediv').find('#remove-post-thumbnail').html('Remove thumbnail image');
		if($('#postimagediv').find('#set-post-thumbnail img').length == 0) {
			$('#postimagediv').find('#set-post-thumbnail').html('Set thumbnail image');
		}
		//$('#postimagediv').find('#set-post-thumbnail').html('Set thumbnail image');
	}


	if($('body').find("#requirements-message").length === 0) {
		$('h2').after('<div id="notify-requirements" class="error" style="border-left-color: #FFFF00;"><ul><li><span><b>Requirements</b></span></li><li><span>Thumbnail Image is required.</span></li><li><span>Thumbnail Image dimensions must be at least 800x450.</span></li><li><span>Category is required. Category cannot be Uncategorized.</span></li></ul></div>');
		$('h2').after('<div id="requirements-message"></div>');
    }

    changeFeatureImagelabel();
    setInterval(checkRequirements, 2500);
    checkRequirements();


});