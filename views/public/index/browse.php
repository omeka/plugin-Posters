<?php
//$head = array('title' => __('Browse Posters'));
$pageTitle = html_escape(get_option('poster_page_title'));
echo head(array('title' => $pageTitle)); ?>
<script>
 $('.poster').carousel();

</script>
<div id="primary">
    <h1><?php echo $pageTitle; ?></h1>
    <?php echo flash(); ?>
    <h2>Your Posters</h2>
    <!-- Begin Slideshow -->
       <div id="posters">
           <table>
               <thead>
                   <tr>
                       <th>Title</th>
                       <th>Date Created</th>
                       <th>Description</th>
                   </tr>
               </thead>
               <tbody>
                   
                       <?php foreach($posters as $poster): ?>
                       <tr><td><a href="<?php echo html_escape(url(array('action' => 'show', 'id' => $poster->id),'default')); ?>" 
                                  class="view-poster-link"><?php echo html_escape($poster->title); ?></a></td>
                       <td><?php echo html_escape($poster->date_created); ?></td>
                       <td><?php echo html_escape(snippet($poster->description, 0, 50)); ?></td>
                       </tr>
                       <?php endforeach;?>
                   
               </tbody>
           </table>
           
           
           
       <?php //if(count($posters) > 0): ?>
       <?php foreach($posters as $poster): ?>
         
            <div class="poster">
                <h3 class="poster-title">
                   <a href="<?php echo html_escape(url(array('action' => 'show','id' => $poster->id),'default')); ?>" 
                       class="view-poster-link"><?php echo html_escape($poster->title); ?> </a>
                </h3>
                <ul class="poster-meta">
                    <li class="poster-date"><?php echo html_escape($poster->date_created); ?></li>
                    <li class="poster-description"><?php echo html_escape(snippet($poster->description, 0, 200)); ?></li>
                    
                </ul>
            </div>
       <?php endforeach; ?>
           <?php //endif; ?>
    </div>
</div>
<?php echo foot(); ?>

