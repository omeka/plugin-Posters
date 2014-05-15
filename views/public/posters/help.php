<?php
    $pageTitle = html_escape(get_option('poster_page_title'). ': Help');
    echo head(array('title' => $pageTitle));
?>
<div id="primary">
<div id="poster-help">
    <h1><?php echo $pageTitle; ?></h1>

        <h2>Posters</h2>
    <p>The Poster Builder lets you create a short presentation of items from this website, together with your own captions. Click the New Poster button. Add a title to your poster, and fill in a short description of your project. Click the tab that says &quot;Add an Item,&quot; and browse or search through the items in this website to find ones that you wish to include in your poster. Add captions for each item you choose.</p>
        <p>Be sure to save your poster; you may return to edit your poster at anytime.</p>
</div>
</div>
