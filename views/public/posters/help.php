<?php
    $pageTitle = html_escape(get_option('poster_page_title'). ': Help');
    echo head(array('title' => $pageTitle));
?>
<div id="primary">
<div id="poster-help">
    <h1><?php echo $pageTitle; ?></h1>

       
        <h2>Your Posters</h2>
        <p>Once you have installed Posters plugin, you may use any public item you would like to include on your poster. You may also include any personal caption which will also be included on the poster.</p>
        <p> Click the button that says &quot;New Poster&quot;. Assign a title to your poster, and fill in the description field with a description of your project. Click the tab that says &quot;Add an Item,&quot; and select the items that you wish to include in your poster.</p>
        <p>Be sure to save your poster; you may return to edit your poster at anytime.</p>
</div>
</div>
