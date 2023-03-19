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
<div id="tve-lead_generation_checkbox_option-component" class="tve-component" data-view="LeadGenerationCheckboxOption">
	<div class="dropdown-header" data-prop="docked">
		<?php echo __( 'Main Options', 'thrive-cb' ); ?>
		<i></i>
	</div>

	<div class="dropdown-content">
		<div class="tve-control gl-st-button-toggle-1" data-view="CheckboxPalettes"></div>
		<div class="tve-control tve-style-options no-space preview" data-view="StyleChange"></div>
		<div class="tve-control" data-key="CheckboxStylePicker" data-initializer="checkboxStylePicker"></div>
		<hr>
		<div class="tve-control" data-view="LabelAsValue"></div>
		<div class="tve-control" data-view="InputValue"></div>
		<div class="tve-control" data-view="SetAsDefault"></div>
		<div class="tve-control" data-view="CheckboxSize"></div>

		<div class="tve-advanced-controls">
			<div class="dropdown-header" data-prop="advanced">
				<span class="mb-5">
					<?php echo __( 'Answer based tagging', 'thrive-cb' ); ?>
				</span>
			</div>
			<div class="dropdown-content pt-0">
				<span><?php echo __( 'The following tag will be sent to your autoresponder if this answer is selected', 'thrive-cb' ); ?></span>
				<div class="tve-control mt-10" data-view="CustomAnswerInput"></div>
			</div>
		</div>
	</div>
</div>
