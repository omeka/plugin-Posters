<?php
queue_css_file('poster');

$pageTitle = html_escape(get_option('poster_page_title'));
echo head(array('title' => $pageTitle));
?>
<div id="primary">
<?php $posters = $this->posters; ?>
<?php foreach($posters as $poster): ?>
    <div class="poster">
        <h3 class="poster-title">
            <a href="<?php echo html_escape(url(array('action' => 'show','id'=>$poster->id), get_option('poster_page_path'))); ?>"
            class="view-poster-link"><?php echo html_escape($poster->title); ?></a>
        </h3>
        <ul class="poster-meta">
            <li class="poster-date"><?php echo html_escape($poster->date_created); ?></li>
            <li class="poster-description"><?php echo html_escape(snippet($poster->description,0, 200)); ?></li>
            <li><a href="<?php echo html_escape(url(array('action' => 'delete-confirm', 'id' => $poster->id),  get_option('poster_page_path'))); ?>">Delete</a>
            <a href="<?php echo html_escape(url(array('action'=>'edit','id' => $poster->id), get_option('poster_page_path'))); ?>">edit</a>
            <a href="<?php echo html_escape(url(array('action'=>'share','id' => $poster->id), get_option('poster_page_path'))); ?>">Share Poster</a>
            </li>
        </ul>
    </div>
<?php endforeach; ?>
</div>
<?php echo foot(); ?>
