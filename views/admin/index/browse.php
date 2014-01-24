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
                       <th></th>
                   </tr>
               </thead>
               <tbody>
                   
                       <?php foreach($posters as $poster): ?>
                       <tr><td><a href="<?php echo html_escape(url(array('action' => 'show', 'id' => $poster->id),'default')); ?>" 
                                  class="view-poster-link"><?php echo html_escape($poster->title); ?></a>
                               <ul class="action-links group">
                                   <?php if(is_allowed($poster, 'delete')): ?>
                                   <li> 
                                       <a href="<?php echo html_escape(url(array('action'=>'delete','id' => $poster->id), 'default')); ?>">Delete</a>
                                   </li>
                                   <?php endif; ?>
                               </ul>
                           </td>
                       <td><?php echo html_escape($poster->date_created); ?></td>
                       <td><?php echo html_escape(snippet($poster->description, 0, 50)); ?></td>
                       <td>Delete</td>
                       </tr>
                       <?php endforeach;?>
                   
               </tbody>
           </table>
    </div>
</div>
<?php echo foot(); ?>

