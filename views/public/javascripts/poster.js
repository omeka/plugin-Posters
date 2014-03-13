if (!Omeka) {
    var Omeka = {}
}

Omeka.Poster = {
    itemCount: 0,
    
    //Everything that takes place when the form loads
    init: function () {
		var modalDiv = jQuery('#additem-modal');
    
        // WYSIWYG Editor
        tinyMCE.init({
            mode: "textareas",
            theme: "advanced",
            theme_advanced_toolbar_location : "top",
            theme_advanced_buttons1 : "bold,italic,underline,justifyleft,justifycenter,justifyright,bullist,numlist,link,formatselect",
            theme_advanced_buttons2 : "",
            theme_advanced_buttons3 : "",
            theme_advanced_toolbar_align : "left"
        });

        // Code to run when the save poster form is submitted
        // Walks the items and indexes them
        jQuery('#poster-form').submit(function () {
            var index = 1;
            jQuery('.item-annotation').each(function () {
                jQuery(this).find('textarea')
                    .attr('name', 'annotation-' + index)
                    .end()
                    .siblings('.hidden-item-id')
                    .attr('name', 'itemID-' + index);
                index++;
            });
            jQuery('#itemCount').val(index - 1);
        });
        
        // var modalDiv = jQuery('#myomeka-additem-modal');
        // Click handler.
        jQuery('#poster-additem button').click(function () {
            modalDiv.dialog({modal: true, width: "572", height: "500", title: "Add an Item"}); 
            // make item listing selectable
            $('#additem-modal').on('click','.additem-item', function(event) {
               $('additem-modal div.item-selected').removeClass('item-selected');
               $(this).addClass('item-selected');
            });
        });
        
        jQuery('.additem-form').submit(function (event) {
        	var form = jQuery(this), submitButtons = jQuery('.myomeka-additem-submit');
            event.preventDefault();
            submitButtons.attr('disabled', 'disabled');
            Omeka.Poster.mceExecCommand('mceRemoveControl');
            jQuery.get(form.attr('action'), form.serialize(), function (data) {
                    
            	jQuery('#poster-canvas').append(data);
            	Omeka.Poster.hideExtraControls();
            	Omeka.Poster.mceExecCommand('mceAddControl');
                Omeka.Poster.bindControls();
	            modalDiv.dialog('close');
	            submitButtons.removeAttr('disabled');
            });
            jQuery('#poster-no-items-yet').hide();
        });
       

        if (Omeka.Poster.itemCount > 0) {
            // When the form loads, hide up and down controls that can't be used
            // Should maybe grey them out instead
            Omeka.Poster.hideExtraControls();

            // Bind some actions to poster item controls
            Omeka.Poster.bindControls();
        }
    },

    /**
     * Wraps tinyMCE.execCommand
     */
    mceExecCommand: function (command) {
        jQuery('#poster-canvas textarea').each(function () {
            tinyMCE.execCommand(command, false, this.id);
        });
    },

    /**
     * Hides the move up and down options on the top and bottom items
     */
    hideExtraControls: function() {
        jQuery('.poster-control').show();

        jQuery('.poster-move-up').first().hide();
        jQuery('.poster-move-top').first().hide();
        jQuery('.poster-move-down').last().hide();
        jQuery('.poster-move-bottom').last().hide();
    },

    /**
     * Bind functions to items controls
     */
    bindControls: function(){
        //Remove all previous bindings for controls
        jQuery('.poster-control').unbind();

        // Bind move up buttons
        jQuery('.poster-move-up').click(function (event) {
            var element = jQuery(this).parents('.poster-spot');
            event.preventDefault();
            Omeka.Poster.mceExecCommand('mceRemoveControl');
            element.insertBefore(element.prev());
            Omeka.Poster.hideExtraControls();
            Omeka.Poster.mceExecCommand('mceAddControl');
        });

        // Bind move down buttons
        jQuery('.poster-move-down').click(function (event) {
            var element = jQuery(this).parents('.poster-spot');
            event.preventDefault();
            Omeka.Poster.mceExecCommand('mceRemoveControl');
            element.insertAfter(element.next());
            Omeka.Poster.hideExtraControls();
            Omeka.Poster.mceExecCommand('mceAddControl');
        });

        // Bind move top buttons
        jQuery('.poster-move-top').click(function (event) {
            var element = jQuery(this).parents('.poster-spot');
            event.preventDefault();
            Omeka.Poster.mceExecCommand('mceRemoveControl');
            element.prependTo('#poster-canvas');
            Omeka.Poster.hideExtraControls();
            Omeka.Poster.mceExecCommand('mceAddControl');
        });

        // Bind move bottom buttons
        jQuery('.poster-move-bottom').click(function (event) {
            var element = jQuery(this).parents('.poster-spot');
            event.preventDefault();
            Omeka.Poster.mceExecCommand('mceRemoveControl');
            element.appendTo('#poster-canvas');
            Omeka.Poster.hideExtraControls();
            Omeka.Poster.mceExecCommand('mceAddControl');
        });

        // Bind delete buttons
        jQuery('.poster-delete').click(function (event) {
            var element = jQuery(this).parents('.poster-spot');
            event.preventDefault();
            Omeka.Poster.mceExecCommand('mceRemoveControl');
            element.remove();
            Omeka.Poster.hideExtraControls();
            Omeka.Poster.mceExecCommand('mceAddControl');
        });
    }
};
