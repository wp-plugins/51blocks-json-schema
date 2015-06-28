jQuery(document).ready(function() {
	
        jQuery(window).on('load', function(){
            jQuery('#generator-form input, #generator-form textarea').not(':checkbox').each(function(){
                jsonGen.variableChanged(jQuery(this));
            });
            
            jQuery('#generator-form select').each(function() {
                    jsonGen.variableChanged(jQuery(this));
            });
            
            jQuery('#genWorkDays :checkbox').each(function() {
                var wDays = '';
		jQuery('#genWorkDays :checkbox:checked').each(function() {
			wDays += ','+jQuery(this).val()
		});
		jQuery('.variable[data-varno="11"] p:eq(0)').text(wDays.substring(1)+' ');
            });
            
        });
        
	jQuery('#generator-form input, #generator-form textarea').not(':checkbox').on('keyup', function() {
		jsonGen.variableChanged(jQuery(this));
	});
	
	jQuery('#generator-form select').on('change', function() {
		jsonGen.variableChanged(jQuery(this));
	});
	
	//work days
	jQuery('#genWorkDays :checkbox').on('click', function() {
		var wDays = '';
		jQuery('#genWorkDays :checkbox:checked').each(function() {
			wDays += ','+jQuery(this).val()
		});
		jQuery('.variable[data-varno="11"] p:eq(0)').text(wDays.substring(1)+' ');
	});
	
	jsonGen.resetForm();
	jsonGen.updateComas();
	//jsonGen.scrollOutput();
	
	//jQuery(window).on('scroll', jsonGen.scrollOutput);
        
        jQuery('#genAddTo').on('change', function() {
		var selected = jQuery( "#genAddTo option:selected" ).text();
                
                if (selected === 'Selected Pages') {
                    jQuery("#gen_page_ids_ctn").show();
                } else {
                    jQuery("#gen_page_ids_ctn").hide();
                }
	});
	
	
});

var jsonGen = {

	variableChanged: function(jqNode) {
		var fieldNo = jQuery('#generator-form input, #generator-form select, #generator-form textarea').not(':checkbox').index(jqNode);
		
		var newVal = jqNode.val();
		
		//replace " with \"
		newVal = newVal.replace(/(\\)?"/g, function(x,y){ return x?'\\'+x:'';});
		
		if (newVal != '') {
			jQuery('#genOutput .variable[data-varno="'+fieldNo+'"]').find('span:eq(0)').text(newVal);
			jQuery('#genOutput .variable[data-varno="'+fieldNo+'"]').removeClass('hidden');
			
			if (jQuery('#genOutput .variable[data-varno="'+fieldNo+'"]').parents('.variable').length > 0) {
				jQuery('#genOutput .variable[data-varno="'+fieldNo+'"]').parents('.variable').removeClass('hidden');
			}
			
		} else {
			jQuery('#genOutput .variable[data-varno="'+fieldNo+'"]').addClass('hidden');
			
			if (jQuery('#genOutput .variable[data-varno="'+fieldNo+'"]').parents('.variable').length > 0) {
				
				if (jQuery('#genOutput .variable[data-varno="'+fieldNo+'"]').parents('.variable').find('.variable').not('.hidden').length == 0) {
					jQuery('#genOutput .variable[data-varno="'+fieldNo+'"]').parents('.variable').addClass('hidden');
				}
			}
			
		}
		
		jsonGen.updateComas();
		
	},

	updateComas: function() {
		
		jQuery('#genOutput .variable').each(function() {
			jQuery(this).find('span:last').removeClass('hidden');
			
			
			if (jQuery(this).find('.variable:visible').length > 0) {
				
				if (jQuery(this).is(jQuery('#genOutput > .variable:visible:last'))) {
					jQuery(this).find('span:last').addClass('hidden');
				}
			}
			
		});
		jQuery('#genOutput .variable:visible:last span:last').addClass('hidden');
		
	},
	
	resetForm: function() {
		//jQuery('#generator-form')[0].reset();
	},
	
	scrollOutput: function() {
		if (jQuery(window).scrollTop() > 290) {
			jQuery('#genOutput').css({
				position: 'fixed',
				top: '50px',
				width: jQuery('#genOutput').parent().width() + 'px'
			});
		} else {
			jQuery('#genOutput').css({
				position: 'static',
				top: 'auto'
			});
		}
	}

}
