<?php
$pageTitle = html_escape(get_option('poster_page_title'));
echo head(array('title' => $pageTitle)); ?>

<?php var_dump($posters); ?>
<?echo foot(); ?>