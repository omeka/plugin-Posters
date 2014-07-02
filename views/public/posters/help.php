<?php
    $pageTitle = html_escape(get_option('poster_page_title'). ': Help');
    echo head(array('title' => $pageTitle));
?>
<div id="poster-help">
    <h1><?php echo $pageTitle; ?></h1>
        <?php echo __(get_option('poster_help')); ?>
</div>
<?php echo foot(); ?>