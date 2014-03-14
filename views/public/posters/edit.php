<?php
    $pageTitle = 'Edit Poster: &quot;' . html_escape($poster->title) . '&quot;';
//queue_js_file(array('tiny_mce/tiny_mce', 'poster'));
queue_js_file('poster');
queue_js_file('vendor/tiny_mce/tiny_mce');
queue_css_file('jquery-ui');
queue_css_file('poster');
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
            <form action="<?php echo html_escape(url(array('action'=>'save', 'id'=>$poster->id), 'posters')); ?>" method="post" accept-charset="utf-8" id="poster-form">
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
                <?php var_dump($poster->Items); if (!count($poster->Items)): ?>
                    <p id="poster-no-items-yet">You have not added any items to this poster yet.</p>
                <?php endif; ?>
                
                <div id="poster-canvas">
                <?php //var_dump($items);
                    if (count($poster->Items)):
                        foreach ($poster->Items as $posterItem):
                            $noteObj = my_omeka_get_note_for_item($posterItem);
                            common('spot', array('posterItem'=>$posterItem, 'noteText'=>$noteObj->note), 'poster');
                        endforeach;
                    endif;
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
                <?php echo $this->formSubmit('save_poster',__('Save Poster'), array('class' => 'submit big green button')); ?>
                    <!--input type="submit" name="save_poster" value="Save Poster" /--> or 
                    <?php if (is_admin_theme()): ?>
                        <a href="<?php echo html_escape(url(array('action'=>'discard'), 'default')); ?>">Discard Changes and Return to Poster Administration</a>
                    <?php else: ?>
                        <a href="<?php echo html_escape(url(array('action'=> 'discard'), 'default')); ?>">Discard Changes and Return to the Dashboard</a>
                    <?php endif ?>
                    <input type="hidden" name="itemCount" value="<?php echo count($poster->Items); ?>" id="itemCount"/>

                    <div id="help">
                	    <p><a href="<?php echo html_escape(url(array('action'=>'help'), 'default')); ?>" class="help-link">Help</a></p>
                	</div>

                </div>
            
            </form>
            <!-- pop-up -->
            <div id="additem-modal" >
            <?php echo item_search_filters(); 
                $items = get_records('Item', array('public' => true));
            ?>
            <?php if (count($items) === 0): ?>
                <p><?php echo __('There are no items to choose from'); ?> </p>
             <?php endif; ?>
             <?php foreach ($items as $item): ?>
                 <div class="additem-item" data-item-id="<?php echo $item->id; ?>">
                    <?php 
                        if (metadata($item, 'has files')) {
                            foreach($item->Files as $displayFile) {
                                if ($displayFile->hasThumbnail()) {
                                    echo '<div class="item-file">'
                                        . file_image('square_thumbnail', array(), $displayFile)
                                        . '</div>';
                                    break;
                                }
                            }
                        }
                        $private = '';
                        if (!metadata($item, 'public')) {
                            $private = ' ' . __('(Private)'); 
                        }
                        echo '<h4 class="title">'
                            .metadata($item, array('Dublin Core', 'Title'))
                            .$private
                            .'</h4>'
                            .'<button type="button" class="select-item">'
                            . __('Select Item')
                            .'</button>';
                    ?>
                </div>
             <?php endforeach; ?>
            </div>
            <!-- end pop-up -->
        </div> <!-- end poster-info div -->
    </div> <!-- end poster div -->
</div> <!-- end primary div -->
<?php echo foot(); ?>
