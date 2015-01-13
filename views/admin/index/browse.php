<?php
//$head = array('title' => __('Browse Posters'));
$pageTitle = html_escape(get_option('poster_page_title'));
echo head(array('title' => $pageTitle)); ?>
<script>
 $('.poster').carousel();

</script>
<div id="primary">
    <?php echo flash(); ?>
    <!-- Begin Slideshow -->
       <div id="posters">
           <table>
               <thead>
                   <tr>
                       <th><?php echo __('Title'); ?></th>
                       <th><?php echo __('Date Created'); ?></th>
                       <th><?php echo __('Description'); ?></th>
                   </tr>
               </thead>
               <tbody>
                   
                       <?php foreach($posters as $poster): ?>
                       <tr><td><a href="<?php echo html_escape(public_url(get_option('poster_page_path').'/show/'.$poster->id)); ?>" target="_blank" 
                                  class="view-poster-link"><?php echo html_escape($poster->title); ?></a>
                               <ul class="action-links group">
                                   <?php if(is_allowed('Posters_Poster', 'delete')): ?>
                                   <li> 
                                    <a href="<?php echo html_escape(
                                                    url(
                                                       array(
                                                            'action' => 'delete-confirm', 
                                                            'id' => $poster->id),
                                                   'default')); ?>
                                     ">Delete</a>
                                   </li>
                                   <?php endif; ?>
                               </ul>
                           </td>
                       <td><?php echo html_escape(format_date($poster->date_created)); ?></td>
                       <td><?php echo html_escape(snippet($poster->description, 0, 50)); ?></td>
                       <!--td><?php // echo html_escape($poster->user_id); ?></td-->
                       </tr>
                       <?php endforeach;?>
                       
                   
               </tbody>
           </table>
    </div>
</div>
<?php echo foot(); ?>

