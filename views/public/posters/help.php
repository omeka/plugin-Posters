<?php
    $pageTitle = html_escape(get_option('poster_page_title'). ': Help');
    echo head(array('title' => $pageTitle));
?>
<div id="primary">
<div id="poster-help">
    <h1><?php echo $pageTitle; ?></h1>

       
        <h2>Your Posters</h2>
        <p> To build a poster, you may use any public item in this website and add a caption. </p>
        <p> Click the button that says &quot;New Poster&quot;. Assign a title to your poster, and add a short description. Click the tab that says &quot;Add an Item,&quot; and select an item that you wish to include in your poster. Continue adding items and captions.</p>
       <p>  Be sure to save your poster. You may return to edit your poster at anytime.</p>
       <p> You may print this poster, or share it by email. </p>
</div>
</div>
