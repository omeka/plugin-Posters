<?php
    $pageTitle = 'Edit Poster: &quot;' . html_escape($poster->title) . '&quot;';
//queue_js_file(array('tiny_mce/tiny_mce', 'poster'));
echo queue_js_file('poster');
echo queue_js_file('vendor/tiny_mce/tiny_mce');
echo queue_css_file('jquery-ui');
echo queue_css_file('poster');
   echo  head(array('title'=>$pageTitle));
?>
<script type="text/javascript">
    // Set the initial Item Count
    Omeka.Poster.itemCount = <?php echo count($poster->Items); ?>;

    jQuery(window).load(Omeka.Poster.init);
</script>
<div id="primary">
    <h1><?php echo $pageTitle; ?></h1>
    <div id="poster">
	    <div id="poster-info">
            <form action="<?php echo html_escape(url(array('action'=>'save', 'id'=>$poster->id), get_option('poster_page_path'))); ?>" method="post" accept-charset="utf-8" id="poster-form">
                <div class="field">
                    <label for="title">Title of Poster:</label>
                    <?php echo $this->formText('title', $poster->title, array('id'=>'title')); ?>
                </div>
                <div class="field">
                    <label for="description">Description:</label>
                    <?php echo $this->formTextarea('description', $poster->description, 
                    array('id'=>'description', 'rows'=>'8', 'cols'=>'20')); ?>
                </div>

                <h2>Poster Items</h2>
                <?php if (!count($poster->Items)): ?>
                    <p id="poster-no-items-yet">You have not added any items to this poster yet.</p>
                <?php endif; ?>
                
                <div id="poster-canvas">
                <?php if (count($poster->Items)){
                    foreach ($poster->Items as $posterItem){
                        echo common('spot', array('posterItem'=>$posterItem),'posters' );
                    }
                }
                ?>
                </div>
                <div id="poster-additem">
                   
                    <?php if (count($items)): ?>
                    <?php //echo $_REQUEST['item_id']; ?>
		            <button type="button">Add an Item &rarr;</button>
                    <?php else: ?>
                        <button type="button" disabled="disabled">Add an item &rarr;</button>
                        <p>You have to add notes or tags to an item before adding them to a poster</p>
                    <?php endif; ?>
                </div>
        
                <div id="submit-poster">
                <?php //echo $this->formSubmit('save_poster',__('Save Poster'), array('class' => 'submit big green button')); ?>
                    <input type="submit" name="save_poster" value="Save Poster" > or 
                    <?php if (is_admin_theme()): ?>
                        <a href="<?php echo html_escape(url(array('action'=>'discard'), get_option('poster_page_path'))); ?>">Discard Changes and Return to Poster Administration</a>
                    <?php else: ?>
                        <a href="<?php echo html_escape(url(array('action'=> 'discard'), get_option('poster_page_path'))); ?>">Discard Changes and Return to the Dashboard</a>
                    <?php endif ?>
                    <input type="hidden" name="itemCount" value="<?php echo count($poster->Items); ?>" id="itemCount"/>

                    <div id="help">
                        <p><a href="<?php echo html_escape(url(array('action'=>'help'), get_option('poster_page_path'))); ?>" class="help-link">Help</a></p>
                    </div>
                    <div id="share">
                        <p><a href="<?php echo html_escape(url(array('action'=>'share'), get_option('poster_page_path'))); ?>" class="share-link">Share Poster</a></p>
                    </div>
                     <div id="print">
                        <p><a href="<?php echo html_escape(url(array('action'=>'print'), get_option('poster_page_path'))); ?>" class="print" media="print" >Print</a></p>
                        
                     </div>
                </div>
            
            </form>
            <!-- pop-up -->
<div id="additem-modal" >
    <div id="item-form">
        <button type="button" id="revert-selected-item"><?php echo __('Revert to Selected Item'); ?></button>
        <button type="button" id="show-or-hide-search" class="show-form blue">
            <span class="show-search-label"><?php echo __('Show Search Form'); ?></span>
            <span class="hide-search-label"><?php echo __('Hide Search Form'); ?></span>
        </button>
        <a href="<?php echo url(get_option('poster_page_path') . '/items/browse'); ?>" id="view-all-items" class="green button"><?php echo __('View All Items'); ?></a>
        <div id="page-search-form" class="container-twelve">
            <?php 
                $action = url(array(
                        'module' => 'posters',
                        'controller' => 'items',
                        'action' =>'browse'),
                'default', array(), true);
                echo items_search_form(array('id' => 'search'), $action);
            ?>
        </div>
        <div id="item-select"></div>
    </div>
</div>
            <!-- end pop-up -->
        </div> <!-- end poster-info div -->
    </div> <!-- end poster div -->
</div> <!-- end primary div -->
<script type="text/javascript" charset="utf-8">
                //<![CDATA[
   
    jQuery(document).ready(function(){
        Omeka.Poster.setUpItemsSelect(<?php echo js_escape(url(get_option('poster_page_path').'/add-poster-item'));?>);
        Omeka.Poster.wysiwyg();
    });

//]]>
</script>            
<?php echo foot(); ?>
