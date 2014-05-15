var Omeka = Omeka || {};
Omeka.Poster = {};

(function ($) {
    itemCount: 0;

    Omeka.Poster.setUpItemsSelect = function (itemOptionsUrl) {
        /*
         * Use Ajax to retrieve the list of items that can be attached.
         */
        var modalDiv = $('#additem-modal');
        modalDiv.hide();
        
        //this.wysiwyg('mceAddControl');
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

        $('#poster-form').submit(function(){
            var index = 1;
            $('.poster-item-annotation').each(function() {
                $(this).find('textarea')
                       .attr('name','annotation-' + index)
                       .end()
                       .siblings('.hidden-item-id')
                       .attr('name','itemID-' + index);
                index++;
            })
            $('#itemCount').val(index-1);
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
        });
        $('#item-select').on('click', '.item-selected',function(event){
            event.preventDefault();
            var d = itemOptionsUrl+'/'+$('#item-select .item-selected').data('itemId');
            //alert(itemOptionsUrl);
            $.get(d, function(data){
                $('#poster-canvas').append(data);
                Omeka.Poster.hideExtraControls();
                Omeka.Poster.bindControls();
                modalDiv.dialog('close');
            });
        });
        

        if (Omeka.Poster.itemCount > 0) {
            //When the form loads, hide up and down controls that can't be used
            Omeka.Poster.hideExtraControls();
            Omeka.Poster.bindControls();
        }

    }

    /*
     * wraps tinyMCE.execCommand.
     */
    Omeka.Poster.wysiwyg = function(params) {
        //$('textarea').each(function (){
        //    tinyMCE.execCommand(command, true, this.id);
            
        //});
        //Default Params
        initParams = {
            convert_urls: false,
            mode: "textareas", //All textAreas
            theme: "advanced",
            theme_advanced_toolbar_location: "top",
            theme_advanced_statusbar_location: "none",
            theme_advanced_toolbar_align: "left",
            theme_advanced_buttons1: "bold,italic,underline,|,justifyleft,justifycenter,justifyright,|,bullist,numlist,|,link,formatselect,code",
            theme_advanced_buttons2: "",
            theme_advanced_buttons3: "",
            plugins: "paste,media",
            media_strict: false,
            width: "100%"
        };

        tinyMCE.init($.extend(initParams, params));
    }
    /**
     * Hides the move up and down options on the top and bottom items
     */
    Omeka.Poster.hideExtraControls = function(){
        $('.poster-control').show();
        $('.poster-move-up').first().hide();
        $('.poster-move-top').first().hide();
        $('.poster-move-down').last().hide();
        $('.poster-move-bottom').last().hide();
    }

    /**
     * bind functions to items controls
     */

    Omeka.Poster.bindControls = function(){
        //Remove all previous binding for controls
        $('.poster-control').unbind();

        //Bind move up buttons
        $('.poster-move-up').click(function (event) {
            var element = $(this).parents('.poster-spot');
            event.preventDefault();
            Omeka.Poster.wysiwyg('mceRemoveControl');
            element.insertBefore(element.prev());
            Omeka.Poster.hideExtraControls();
            Omeka.Poster.wysiwyg('mceAddControl');
        });
        $('.poster-move-down').click(function (event) {
            var element = $(this).parents('.poster-spot');
            event.preventDefault();
            Omeka.Poster.wysiwyg('mceRemoveControl');
            element.insertBefore(element.next());
            Omeka.Poster.hideExtraControls();
            Omeka.Poster.wysiwyg('mceAddControl');
        });

        $('.poster-move-top').click(function (event) {
            var element = $(this).parents('.poster-spot');
            event.preventDefault();
            Omeka.Poster.wysiwyg('mceRemoveControl');
            element.prependTo('#poster-canvas');
            Omeka.Poster.hideExtraControls();
            Omeka.Poster.wysiwyg('mceAddControl');
        });
        $('.poster-move-bottom').click(function (event) {
            var element = $(this).parents('.poster-spot');
            event.preventDefault();
            Omeka.Poster.wysiwyg('mceRemoveControl');
            element.apendTo('#poster-canvas');
            Omeka.Poster.hideExtraControls();
            Omeka.Poster.wysiwyg('mceAddControl');
        });

        $('.poster-delete').click(function (event) {
            var element = $(this).parents('.poster-spot');
            event.preventDefault();
            Omeka.Poster.wysiwyg('mceRemoveControl');
            element.remove();
            Omeka.Poster.hideExtraControls();
            Omeka.Poster.wysiwyg('mceAddControl');
        });

    }
    
  })(jQuery);
