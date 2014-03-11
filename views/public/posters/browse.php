<?php
$pageTitle = html_escape(get_option('poster_page_title'));
echo head(array('title' => $pageTitle));

?>
<div id="primary">
<?php foreach($posters as $poster): ?>
    <div class="poster">
        <h3 class="poster-title">
            <a href="<?php echo html_escape(url(array('action' => 'show','id'=>$poster->id), 'default')); ?>"
            class="view-poster-link"><?php echo html_escape($poster->title); ?></a>
        </h3>
        <ul class="poster-meta">
            <li class="poster-date"><?php echo html_escape($poster->date_created); ?></li>
            <li class="poster-description"><?php echo html_escape(snippet($poster->description,0, 200)); ?></li>
        </ul>
    </div>
<?php endforeach; ?>
</div>
<?php echo foot(); ?>
