<?php
$pageTitle = 'Poster: &quot;' . html_escape($poster->title) . '&quot;';
echo head(array('title' => $pageTitle)); 
?>

<div id="primary">
    <h1><?php echo $pageTitle; ?></h1>
    <div id="poster">
        <div id="poster-info">
            <?php echo $poster->description; ?>
        </div>
    </div>
</div>
<?php echo foot(); ?>