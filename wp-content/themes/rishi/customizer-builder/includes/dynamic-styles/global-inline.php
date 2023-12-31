<?php

$args = apply_filters('rishi:header:dynamic-styles-args', [
	'section_id' => rishi__cb_customizer_manager()->header_builder->get_current_section_id(),
	'check_transparent_conditions' => true
]);

do_action(
	'rt:global-dynamic-css:enqueue:inline',
	[
		'context' => $context,
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css
	]
);

if (
	! isset($args['has_transparent_header'])
	||
	! $args['has_transparent_header']
) {
	return;
}

$render = new \Rishi_Header_Builder_Render([
	'current_section_id' => $args['section_id']
]);

$root_selector = $render->get_root_selector();

$has_transparent_header = $args['has_transparent_header'];

rishi__cb_customizer_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => rishi__cb_customizer_assemble_selector($root_selector),
	'variableName' => 'has-transparent-header',
	'value' => [
		'desktop' => in_array('desktop', $has_transparent_header) ? '1' : '0',
		'tablet' => in_array('mobile', $has_transparent_header) ? '1' : '0',
		'mobile' => in_array('mobile', $has_transparent_header) ? '1' : '0'
	],
	'unit' => ''
]);
