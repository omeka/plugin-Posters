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
<div class="field">
    <div class="two columns alpha">
        <label><?php echo __('Poster File Size'); ?></label>    
    </div>
    <div class="inputs five columns omega" >
        <p class='explanation'><?php echo __("Select image size for item show page."); ?>
        </p>

        <div class="input-block">
        <select name="poster_default_file_type" >
        <?php foreach(array('fullsize','thumbnail') as $ftype): ?>
                <?php if($ftype == get_option('poster_default_file_type')): ?>
                    <option  value="<?php echo $ftype; ?>" selected ><?php echo $ftype; ?></option>
                <?php else: ?>
                    <option  value="<?php echo $ftype; ?>"><?php echo $ftype; ?></option>
                <?php endif; ?>
        <?php endforeach; ?>
        </select>
  
        <p class='explanation'><?php echo __("Select image size for print page."); ?>
        </p>
        <div class="input-block">
        <select name="poster_default_file_type_print">
        <?php foreach(array('fullsize','thumbnail') as $ftype): ?>
                <?php if($ftype == get_option('poster_default_file_type_print')): ?>
                    <option  value="<?php echo $ftype; ?>" selected ><?php echo $ftype; ?></option>
                <?php else: ?>
                    <option  value="<?php echo $ftype; ?>"><?php echo $ftype; ?></option>
                <?php endif; ?>
        <?php endforeach; ?>
        </select>
        </div>

    </div>
</div>
<div class="field">
    <div class="two columns alpha">
        <label><?php echo __('Poster Display Show Page'); ?></label>    
    </div>
    <div class="inputs five columns omega" >
        <p class='explanation'><?php echo __("Select carousel or grid."); ?>
        </p>
        <?php
             echo $view->formCheckbox(
                        'poster_show_option', 
                        true, 
                        array(
                            'checked' => (boolean) get_option('poster_show_option')
                        )
                    ); 
        ?>
    </div>
</div>

