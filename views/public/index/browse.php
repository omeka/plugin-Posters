<?php
//$head = array('title' => __('Browse Posters'));
$pageTitle = html_escape(get_option('poster_page_title'));
echo head(array('title' => $pageTitle)); ?>

<div id="primary">
    <h1><?php echo $pageTitle; ?></h1>
    <?php echo flash(); ?>
    <h2>Your Posters</h2>
    <!-- Begin Slideshow -->
       <div id="posters">
       <?php var_dump($posters); ?>
       <?php foreach($posters as $poster): ?>
           <?php var_dump($poster); ?>
            <div class="poster">
                <h3 class="poster-title">
                   <a href="<?php echo html_escape(url(array('action' => 'show','id' => $poster->id),'default')); ?>" 
                       class="view-poster-link"><?php html_escape($poster); ?> </a>
                </h3>
            </div>
       <?php endforeach; ?>
    </div>
</div>
<?php echo foot(); ?>

