<?php
    $pageTitle = 'Edit Poster: &quot;' . html_escape($poster->title) . '&quot;';
//queue_js_file(array('tiny_mce/tiny_mce', 'poster'));
echo queue_js_file('poster');
echo queue_js_file('vendor/tiny_mce/tiny_mce');
echo queue_css_file('jquery-ui');
echo queue_css_file('poster');
   echo  head(array('title'=>$pageTitle, 'bodyclass' => 'posters edit'));
?>
<script type="text/javascript">
    // Set the initial Item Count
    Omeka.Poster.itemCount = <?php echo count($poster->Items); ?>;

    jQuery(window).load(Omeka.Poster.init);
</script>
<h1><?php echo $pageTitle; ?></h1>

<ul class="poster-actions">
    <li><a href="<?php echo html_escape(url(array('action'=>'help'), get_option('poster_page_path'))); ?>" class="help-link">Help</a></li>
    <li><a href="<?php echo html_escape(url(array('action'=>'share'), get_option('poster_page_path'))); ?>" class="share-link">Share Poster</a></li>
    <li><a href="<?php echo html_escape(url(array('action'=>'print'), get_option('poster_page_path'))); ?>" class="print" media="print" >Print</a></li>
 </ul>

<div id="poster">
    <div id="poster-info">
          <h2><?php echo __('Poster Meta'); ?></h2>
          <form action="<?php echo html_escape(url(array('action'=>'save', 'id'=>$poster->id), get_option('poster_page_path'))); ?>" method="post" accept-charset="utf-8" id="poster-form">
              <div class="field">
                  <label for="title">Title of Poster</label>
                  <div class="inputs">
                  <?php echo $this->formText('title', $poster->title, array('id'=>'title')); ?>
                  </div>
              </div>
              <div class="field">
                  <label for="description">Description</label>
                  <div class="inputs">
                      <?php echo $this->formTextarea('description', $poster->description, 
                      array('id'=>'description', 'rows'=>'8', 'cols'=>'20')); ?>
                  </div>
              </div>
    
              <h2 id="poster-items-title">Poster Items</h2>

              <?php $noItems = (count($poster->Items) < 1) ? 'class="no-items"' : ''; ?>

              <p id="poster-no-items-yet" <?php echo $noItems; ?>>You have not added any items to this poster yet.</p>
              
              <div id="poster-canvas" <?php echo $noItems; ?>>
                  <table id="poster-items">
                      <thead>
                          <th id="poster-item-title-col"><?php echo __('Title'); ?></th>
                          <th id="poster-item-caption-col"><?php echo __('Caption'); ?></th>
                      </thead>
                      <tbody>
                      <?php foreach ($poster->Items as $posterItem){
                              $posterItem->posterId = $poster->id;
                              echo common('spot', array('posterItem'=>$posterItem),'posters' );
                          }
                      ?>
                      </tbody>
                  </table>
              </div>

              <div id="poster-additem">
              <?php if (count($items)): ?>
                  <button type="button" id="add-item-button">Add an Item</button>
              <?php else: ?>
                  <button type="button" id="add-item-button" disabled="disabled">Add an item &rarr;</button>
                      <p>You have to add notes or tags to an item before adding them to a poster</p>
              <?php endif; ?>
              </div>
      
              <div id="submit-poster">
                  <input type="submit" name="save_poster" value="Save Poster" > or 
                  <?php if (is_admin_theme()): ?>
                      <a href="<?php echo html_escape(url(array('action'=>'discard'), get_option('poster_page_path'))); ?>">Discard Changes and Return to Poster Administration</a>
                  <?php else: ?>
                      <a href="<?php echo html_escape(url(array('action'=> 'discard'), get_option('poster_page_path'))); ?>">Discard Changes and Return to the Dashboard</a>
                  <?php endif ?>
                  <input type="hidden" name="itemCount" value="<?php echo count($poster->Items); ?>" id="itemCount"/>
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
<script type="text/javascript" charset="utf-8">
                //<![CDATA[
   
    jQuery(document).ready(function(){
        Omeka.Poster.setUpItemsSelect(<?php echo js_escape(url(get_option('poster_page_path').'/add-poster-item'));?>);
        Omeka.Poster.wysiwyg();
    });

//]]>
</script>            
<?php echo foot(); ?>
