<?php
    
    $pageTitle = 'Edit Poster: &quot;' . html_escape($poster->title) . '&quot';
    echo head(array('title' => $pageTitle));
?>
<div id="primary">
    <h1><?php echo $pageTitle; ?></h1>
    <div id="poster">
        <div id="poster-info">
                      <form action="<?php echo html_escape(url(array('action'=>'save', 'id'=>$poster->id), 'default')); ?>" method="post" accept-charset="utf-8" id="poster-poster-form">
                <div class="poster-field">
                    <label for="poster-title">Title of Poster:</label>
                    <?php echo $this->formText('title', $poster->title, array('id'=>'poster-title')); ?>
                </div>
                
                <div class="poster-field">
                    <label for="poster-description">Description:</label>
                    <?php echo $this->formTextarea('description', $poster->description, 
                    array('id'=>'poster-description', 'rows'=>'8', 'cols'=>'20')); ?>
                </div>

                <h2>Poster Items</h2>
                <?php if (!count($poster->Items)): ?>
                    <p id="poster-poster-no-items-yet">You have not added any items to this poster yet.</p>
                <?php endif; ?>
                
                    <div id="poster-poster-canvas">
                                        <?php
                        if (count($poster->Items)):
                                                    foreach ($poster->Items as $posterItem):
                                                                                    $noteObj = my_omeka_get_note_for_item($posterItem);
                                common('spot', array('posterItem'=>$posterItem, 'noteText'=>$noteObj->note), 'poster');
                            endforeach;
                        endif;
                    ?>
                </div>
        
                <div id="poster-poster-additem">
                    <?php if (count($items)): ?>
                    <?php echo $_REQUEST['item_id']; ?>
                            <button type="button">Add an Item &rarr;</button>
                    <?php else: ?>
                        <button type="button" disabled="disabled">Add an item &rarr;</button>
                        <p>You have to add notes or tags to an item before adding them to a poster</p>
                    <?php endif; ?>
                </div>
        
                <div id="poster-submit-poster">
                    <input type="submit" name="save_poster" value="Save Poster" /> or 
                    <?php if (is_admin_theme()): ?>
                        <a href="<?php echo html_escape(url(array('action'=>'discard'), 'default')); ?>">Discard Changes and Return to Poster Administration</a>
                    <?php else: ?>
                        <a href="<?php echo html_escape(url(array('action'=> 'discard'), 'default')); ?>">Discard Changes and Return to the Dashboard</a>
                    <?php endif ?>
                    <input type="hidden" name="itemCount" value="<?php echo count($poster->Items); ?>" id="poster-itemCount"/>

                    <div id="poster-help">
                            <p><a href="<?php echo html_escape(url(array('action'=>'help'), 'default')); ?>" class="poster-help-link">Help</a></p>
                        </div>

                </div>
            
            </form>
        </div>
    </div>
</div>

<?php echo foot(); ?>
