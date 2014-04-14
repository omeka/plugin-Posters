var Omeka = Omeka || {};
Omeka.Poster = {};

(function ($) {
    Omeka.Poster.setUpItemsSelect = function (itemOptionsUrl) {
        /*
         * Use Ajax to retrieve the list of items that can be attached.
         */
        var modalDiv = $('#additem-modal');
        modalDiv.hide();
        
        //Click Handler
        $('#poster-additem button').click(function(){
            //show items in a popup
            modalDiv.dialog({
                modal: true,
                width: "572",
                height: "500",
                title: "Add Item"
            });
            //Hide unneccesarry buttons 
           setSearchVisibility(false);
             
            
        });

        function getItems(uri, params) {
            modalDiv.addClass('loading');
            $.ajax({
                url: uri,
                data: params,
                method: 'GET',
                success: function(data) {
                    $('#item-select').html(data);
                    $(document).trigger("omeka: loaditems");
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('Error getting items: ', textStatus);
                },
                complete: function() {
                    modalDiv.removeClass('loading');
                }
            });
        }
        function setSearchVisibility(show){
            var searchForm = $('#page-search-form');
            var searchButton = $('#show-or-hide-search');
           $('#revert-selected-item').hide();
            if(typeof show === 'undefined'){
                show = !searchForm.is(':visible');
                $('#item-select').show();
            }
            if(show) {
                searchForm.show();
                //searchButton.addClass('hide-form').removeClass('show-form');
                $('.show-search-label').hide();
                $('.hide-search-label').show();
                $('#item-select').hide();
            } else {
                searchForm.hide();
                $('.show-search-label').show();
                $('.hide-search-label').hide();
                $('#item-select').show();
                
            }    
        }
        //initially load the paginated items
       getItems($('#search').attr('action'));
       
       $('#search').submit(function(event){
            event.preventDefault();
            getItems(this.action, $(this).serialize());
            setSearchVisibility(false);
       });
       //make searcn and pagination use ajax to respond.
       $('#item-form').on('click', '.pagination a, #view-all-items', function (event) {
            event.preventDefault();
            getItems(this.href);
            setSearchVisibility(false);
            
       });
       $('#item-select').on('submit', '.pagination form', function(event) {
            event.preventDefault();
            getItems(this.action + '?' + $(this).serialize());
            setSearchVisibility(false);
       });
       setSearchVisibility(false);
       $('#show-or-hide-search').click(function (event) {
            event.preventDefault();
            setSearchVisibility();
       });
       
       //Make Items Selectable
       $('#item-select').on('click', '.item-listing', function(event) {
              $('#item-list .item-selected').removeClass('item-selected');
              $(this).addClass('item-selected');
               
              /*$('.select-item').on('click', function(event){
                    var form = $('#poster-form');
                    var submitButtons = $('.additem-submit');
                    event.preventDefault();
                    submitButtons.attr('disabled','disabled');
                    $.get(form.attr('action'), form.serialize(), function(data) {
                        //alert(data);
                        $('#poster-canvas').append(data);
                        modalDiv.dialog('close');
                        submitButtons.removeAttr('disabled');
                    });
                    $('#poster-no-items-yet').hide();
              });*/  
               });
         $('.additem-form').submit(function (event) {
        	var form = $(this), submitButtons = $('.additem-submit');
            event.preventDefault();
            submitButtons.attr('disabled', 'disabled');
            Omeka.Poster.mceExecCommand('mceRemoveControl');
            $.get(form.attr('action'), form.serialize(), function (data) {
                  alert(data);
            	$('#poster-canvas').append(data);
            	Omeka.Poster.hideExtraControls();
            	Omeka.Poster.mceExecCommand('mceAddControl');
                Omeka.Poster.bindControls();
	            modalDiv.dialog('close');
	            submitButtons.removeAttr('disabled');
            });
            $('#poster-no-items-yet').hide();
        });  
              
    

        //$('.select-item').on('click','.item-listing', function(){
          //  alert('clicked');
       // });

        
    }
    Omeka.Poster.mceExecComman = function(command) {
        $('#poster-canvas textarea').each(function(){
            tinyMce.execCommand(command, false, this.id);
        });
    }
    Omeka.Poster.setUpWysiwyg = function() {
        $(event.target).find('textarea').each(function (){
            tinyMCE.execCommand('mceAddControl', true, this.id);
        });
    }
})(jQuery);
