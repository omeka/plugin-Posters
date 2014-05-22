<?php $view = get_view(); ?>

<div class="field">
    <div class="two columns alpha">
        <label><?php echo __('Poster Page Title'); ?></label>    
    </div>
    <div class="inputs five columns omega" >
        <p class='explanation'><?php echo __("Replace default Poster page title."); ?>
        </p>
        <div class="input-block">
            <input name="poster_page_title" value="<?php echo get_option('poster_page_title'); ?>" type="text" />
        </div>

    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <label><?php echo __('Poster Page Path'); ?></label>    
    </div>
    <div class="inputs five columns omega" >
        <p class='explanation'><?php echo __("Replace default Poster page path."); ?>
        </p>
        <div class="input-block">
            <input name="poster_page_path" value="<?php echo get_option('poster_page_path'); ?>" type="text" />
        </div>

    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <label><?php echo __('Poster Page Disclaimer'); ?></label>    
    </div>
    <div class="inputs five columns omega" >
        <p class='explanation'><?php echo __("Replace default Poster Disclaimer."); ?>
        </p>
        <div class="input-block">
            <textarea name="poster_disclaimer" rows="8" cols="40"><?php echo get_option('poster_disclaimer'); ?></textarea>
        </div>

    </div>
<div class="field">
    <div class="two columns alpha">
        <label><?php echo __('Poster Page Help'); ?></label>    
    </div>
    <div class="inputs five columns omega" >
        <p class='explanation'><?php echo __("Replace default Poster Help."); ?>
        </p>
        <div class="input-block">
            <textarea name="poster_help" rows="8" cols="40"><?php echo get_option('poster_help'); ?></textarea>
        </div>

    </div>
</div>
