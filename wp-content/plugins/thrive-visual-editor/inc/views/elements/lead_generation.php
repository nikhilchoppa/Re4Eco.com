<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package TCB2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden
}

?>
<div class="thrv_wrapper thrv_lead_generation tve-lead-generation-template tve-draggable tve-droppable edit_mode active_delete" data-connection="api"><input type="hidden" class="tve-lg-err-msg" value="{&quot;email&quot;:&quot;Email address invalid&quot;,&quot;phone&quot;:&quot;Phone number invalid&quot;,&quot;password&quot;:&quot;Password invalid&quot;,&quot;passwordmismatch&quot;:&quot;Password mismatch error&quot;,&quot;required&quot;:&quot;Required field missing&quot;,&quot;file_size&quot;:&quot;{file} exceeds the maximum file size of {filelimit}&quot;,&quot;file_extension&quot;:&quot;Sorry, {fileextension} files are not allowed&quot;}">
	<div class="thrv_lead_generation_container tve_clearfix">
		<form action="#" method="post" novalidate="">
			<div class="tve_lead_generated_inputs_container tve_clearfix">
				<div class="tve_lg_input_container tve_lg_input tcb-plain-text tcb-no-clone">
					<input class="tcb-plain-text" type="text" data-field="name" name="name" placeholder="Name" data-placeholder="Name">
				</div>
				<div class="tve_lg_input_container tve_lg_input tcb-plain-text tcb-no-clone tcb-no-delete">
					<input class="tcb-plain-text" type="email" data-field="email" data-required="1" data-validation="email" name="email" placeholder="Email" data-placeholder="Email">
				</div>
				<div class="thrv_wrapper tve-form-button tcb-local-vars-root">
					<div class="thrive-colors-palette-config" style="display: none !important">__CONFIG_colors_palette__{"active_palette":0,"config":{"colors":{"cf6ff":{"name":"Main Color","parent":-1},"73c8d":{"name":"Dark Accent","parent":"cf6ff"}},"gradients":[]},"palettes":[{"name":"Default","value":{"colors":{"cf6ff":{"val":"rgb(20, 115, 210)","hsl":{"h":210,"s":0.82,"l":0.45}},"73c8d":{"val":"rgb(21, 89, 162)","hsl_parent_dependency":{"h":211,"s":0.77,"l":0.35}}},"gradients":[]}}]}__CONFIG_colors_palette__</div>
					<a href="#" class="tcb-button-link tve-form-button-submit tcb-plain-text">
						<span class="tcb-button-texts"><span class="tcb-button-text thrv-inline-text">Sign Up</span></span>
					</a>
					<input type="submit" style="display: none !important;">
				</div>
			</div>
			<input id="_submit_option" type="hidden" name="_submit_option" value="redirect">
			<input id="_sendParams" type="hidden" name="_sendParams" value="1">
			<input id="_back_url" type="hidden" name="_back_url" value="#">
		</form>
	</div>
</div>
