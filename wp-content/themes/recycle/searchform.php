<form class="search-form" method="get" action="<?php echo esc_url(home_url( '/' )); ?>">
    <div class="wrap">
    	<label class="screen-reader-text"><?php echo esc_html('Search for:', 'recycle');?></label>
        <input class="searchfield" type="text" value="" placeholder="<?php esc_html_e('Search','recycle')?>" name="s" />
        <input class="search-submit" type="submit" value="&#x55;" />
    </div>
</form>