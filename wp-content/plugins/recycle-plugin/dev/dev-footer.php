<?php
?>
<span class="activatedev" style="position: fixed; width: 42px; height: 42px; cursor: pointer; bottom:6px; left:6px; border: 1px solid #ccc; border-radius: 50%; line-height:42px; text-align: center; color: #ccc; opacity:0.5; font-size: 12px;">
dev	
</span>

<script type="text/javascript">
jQuery('.activatedev').on('click', function(){
	jQuery('.site').toggleClass('devel');
	if(!jQuery('.show-grid').length) {
		jQuery('.site').append('<div class="show-grid"></div>');
	}
})
</script>
