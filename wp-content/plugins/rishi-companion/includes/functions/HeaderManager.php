<?php
/**
 * RishiCompanionHeaderAdditions class
 *
 * @package Rishi_Companion
 */
namespace Rishi;

defined( 'ABSPATH' ) || exit;

class RishiCompanionHeaderAdditions {
	private $has_transparent_header = '__DEFAULT__';
	private $has_sticky_header = '__DEFAULT__';

	public function __construct() {
		add_action(
			'customize_controls_enqueue_scripts',
			function () {
				$this->enqueue_static();
			}
		);

		add_action(
			'admin_enqueue_scripts',
			function () {
				$this->enqueue_static();
			},
			50
		);

		add_filter('rt:header:device-wrapper-attr', function ($attr, $device) {
			$transparent_result = $this->current_screen_has_transparent();

			if (! $transparent_result) {
				return $attr;
			}

			if (in_array($device, $transparent_result)) {
				$attr['data-transparent'] = '';
			}

			return $attr;
		}, 10, 2);

		add_filter('rishi:header:item-template-args', function ($args) {
			$args['has_transparent_header'] = $this->current_screen_has_transparent();
			$args['has_sticky_header'] = $this->current_screen_has_sticky();

			return $args;
		});

		add_filter('rishi:header:row-wrapper-attr', function ($attr, $row, $device) {
			$current_section = rishi__cb_customizer_manager()->header_builder->get_current_section();

			if (! isset($current_section['settings'])) {
				$current_section['settings'] = [];
			}

			$atts = $current_section['settings'];

			$transparent_result = $this->current_screen_has_transparent();

			if ($transparent_result) {
				if (in_array($device, $transparent_result)) {
					$attr['data-transparent-row'] = 'yes';
				}
			}

			return $attr;
		}, 10, 3);

		add_filter(
			'rt:header:rows-render',
			function ($custom_content, $rows, $device) {
				$sticky_result = $this->current_screen_has_sticky();

				if (! $sticky_result) {
					return $custom_content;
				}

				if (! in_array($device, $sticky_result['devices'])) {
					return $custom_content;
				}

				$start_html = '<div class="rt-sticky-container">';
				$start_html .= '<div data-sticky="' . $sticky_result['effect'] . '">';

				$end_html = '</div></div>';

				if (
					$sticky_result['behaviour'] === 'top_middle'
					&&
					(
						isset($rows['top-row'])
						||
						isset($rows['middle-row'])
					)
				) {
					if (isset($rows['top-row'])) {
						$rows['top-row'] = $start_html . $rows['top-row'];
					} else {
						$rows['middle-row'] = $start_html . $rows['middle-row'];
					}

					if (isset($rows['middle-row'])) {
						$rows['middle-row'] = $rows['middle-row'] . $end_html;
					} else {
						$rows['top-row'] = $rows['top-row'] . $end_html;
					}

					return implode('', array_values($rows));
				}

				if (
					$sticky_result['behaviour'] === 'middle_bottom'
					&&
					(
						isset($rows['middle-row'])
						||
						isset($rows['bottom-row'])
					)
				) {
					if (isset($rows['middle-row'])) {
						$rows['middle-row'] = $start_html . $rows['middle-row'];
					} else {
						$rows['bottom-row'] = $start_html . $rows['bottom-row'];
					}

					if (isset($rows['bottom-row'])) {
						$rows['bottom-row'] = $rows['bottom-row'] . $end_html;
					} else {
						$rows['middle-row'] = $rows['middle-row'] . $end_html;
					}

					return implode('', array_values($rows));
				}

				if (
					$sticky_result['behaviour'] === 'middle'
					&&
					isset($rows['middle-row'])
				) {
					$rows['middle-row'] = $start_html . $rows['middle-row'] . $end_html;
					return implode('', array_values($rows));
				}

				if (
					$sticky_result['behaviour'] === 'bottom'
					&&
					isset($rows['bottom-row'])
				) {
					$rows['bottom-row'] = $start_html . $rows['bottom-row'] . $end_html;
					return implode('', array_values($rows));
				}

				if (
					$sticky_result['behaviour'] === 'top'
					&&
					isset($rows['top-row'])
				) {
					$rows['top-row'] = $start_html . $rows['top-row'] . $end_html;
					return implode('', array_values($rows));
				}

				if (
					$sticky_result['behaviour'] === 'entire_header'
				) {
					return $start_html . implode('', array_values($rows)) . $end_html;
				}

				return null;
			},
			10, 3
		);

		add_filter('rishi:general:body-header-attr', function ($attr) {
			if ($this->current_screen_has_sticky()) {
				return $attr .= ':sticky';
			}

			return $attr;
		});

		add_filter('rishi:header:dynamic-styles-args', function ($args) {

			$check_transparent_conditions = false;

			if (isset($args['check_transparent_conditions'])) {
				$check_transparent_conditions = $args[
					'check_transparent_conditions'
				];
			}

			$args['has_transparent_header'] = $this->current_screen_has_transparent(
				$check_transparent_conditions
			);
			$args['has_sticky_header'] = isset( $args['section_id'] ) ? $this->current_screen_has_sticky($args['section_id']) : false;

			return $args;
		});
	}

	public function enqueue_static() {
		if (! function_exists('get_plugin_data')) {
			require_once(ABSPATH . 'wp-admin/includes/plugin.php');
		}

		global $wp_customize;

		$data = get_plugin_data(__FILE__);

		$deps = ['rt-options-scripts'];

		$current_screen = get_current_screen();

		if ($current_screen && $current_screen->id === 'customize') {
			$deps = ['rara-customizer-controls'];
		}

		wp_enqueue_script(
			'rc-admin-scripts',
			plugin_dir_url(RISHI_COMPANION_PLUGIN_FILE) . 'assets/build/options.js',
			$deps,
			$data['Version'],
			true
		);

		$conditions_manager = new RishiCompanionConditionsManager();

		$localize = array_merge(
			[
				'all_condition_rules' => $conditions_manager->get_all_rules(),
				'ajax_url' => admin_url('admin-ajax.php'),
				'rest_url' => get_rest_url(),
			]
		);

		wp_localize_script(
			'rc-admin-scripts',
			'RishiCompanionAdmin',
			$localize
		);

		wp_enqueue_style(
			'rc-options-styles',
			plugin_dir_url(RISHI_COMPANION_PLUGIN_FILE) . 'assets/build/public.css',
			[],
			$data['Version']
		);
	}

	public function current_screen_has_transparent($check_conditions = true) {
		if (
			true
			||
			$this->has_transparent_header === '__DEFAULT__'
			||
			! $check_conditions
		) {
			$current_section = rishi__cb_customizer_manager()->header_builder->get_current_section();

			if (! isset($current_section['settings'])) {
				$current_section['settings'] = [];
			}

			$atts = $current_section['settings'];

			if (rishi__cb_get_akv('has_transparent_header', $atts, 'no') === 'no') {
				$this->has_transparent_header = false;
				return false;
			}

			$transparent_behaviour = rishi__cb_get_akv(
				'transparent_behaviour',
				$atts,
				[
					'desktop' => true,
					'tablet' => true,
					'mobile' => true,
				]
			);

			$transparent_result = [];

			foreach ($transparent_behaviour as $device => $value) {
				if (! $value) {
					continue;
				}

				$transparent_result[] = $device;
			}

			$conditions_manager = new RishiCompanionConditionsManager();

			$this->has_transparent_header = false;

			if (
				count($transparent_result) > 0
				&&
				(
					(
						$current_section['id'] === 'type-1'
						&&
						$conditions_manager->condition_matches(rishi__cb_get_akv(
							'transparent_conditions',
							$atts,
							[
								[
									'type' => 'include',
									'rule' => 'everywhere'
								],

								[
									'type' => 'exclude',
									'rule' => '404'
								],

								[
									'type' => 'exclude',
									'rule' => 'search'
								],

								[
									'type' => 'exclude',
									'rule' => 'archives'
								]
							]
						))
					)
					||
					$current_section['id'] !== 'type-1'
					||
					! $check_conditions
				)
				&&
				apply_filters(
					'rt:header:transparent:current-screen-allowed',
					true,
					$current_section,
					$transparent_result
				)
			) {
				$this->has_transparent_header = $transparent_result;
			}
		}

		return $this->has_transparent_header;
	}

	public function current_screen_has_sticky($section_id = null) {
		if (
			$this->has_sticky_header !== '__DEFAULT__'
			&&
			! $section_id
		) {
			return $this->has_sticky_header;
		}

		$current_section = rishi__cb_customizer_manager()->header_builder->get_current_section(
			$section_id
		);

		if (! isset($current_section['settings'])) {
			$current_section['settings'] = [];
		}

		$atts = $current_section['settings'];

		if (rishi__cb_get_akv('has_sticky_header', $atts, 'no') === 'no') {
			$has_sticky_header_result = false;
		} else {
			$atts = $current_section['settings'];

			$sticky_behaviour = rishi__cb_get_akv(
				'sticky_behaviour',
				$atts,
				[
					'desktop' => true,
					'mobile' => true,
				]
			);

			$has_sticky_header_result = [
				'devices' => [],

				// top
				// middle
				// bottom
				// middle_bottom
				// entire_header
				// 'behaviour' => 'middle_bottom'
				// 'behaviour' => 'middle'
				// 'behaviour' => 'middle_bottom'
				'behaviour' => rishi__cb_get_akv('sticky_rows', $atts, 'middle'),
				'effect' => 'shrink'
			];

			foreach ($sticky_behaviour as $device => $value) {
				if (! $value) {
					continue;
				}

				$has_sticky_header_result['devices'][] = $device;
			}
		}

		if ($section_id) {
			$this->has_sticky_header = $has_sticky_header_result;
		}

		return $has_sticky_header_result;
	}

	public function patch_conditions($post_id, $old_post_id) {
		$conditions = $this->get_conditions();

		foreach ($conditions as $index => $single_condition) {
			$particular_conditions = $single_condition['conditions'];

			foreach ($particular_conditions as $nested_index => $single_particular_condition) {
				if (
					(
						$single_particular_condition['rule'] === 'page_ids'
						||
						$single_particular_condition['rule'] === 'post_ids'
					) && (
						isset($single_particular_condition['payload'])
						&&
						isset($single_particular_condition['payload']['post_id'])
						&&
						intval(
							$single_particular_condition['payload']['post_id']
						) === $old_post_id
					)
				) {
					$particular_conditions[$nested_index]['payload']['post_id'] = $post_id;
				}
			}

			$conditions[$index]['conditions'] = $particular_conditions;
		}

		$this->set_conditions($conditions);

		$section_value = rishi__cb_customizer_manager()->header_builder->get_section_value();

		foreach ($section_value['sections'] as $index => $current_section) {
			if (! isset($current_section['settings'])) {
				continue;
			}

			if (! isset($current_section['settings']['transparent_conditions'])) {
				continue;
			}

			foreach ($current_section['settings']['transparent_conditions'] as $cond_index => $single_condition) {
				$particular_conditions = $single_condition;

				if (
					(
						$single_condition['rule'] === 'page_ids'
						||
						$single_condition['rule'] === 'post_ids'
					) && (
						isset($single_condition['payload'])
						&&
						isset($single_condition['payload']['post_id'])
						&&
						intval(
							$single_condition['payload']['post_id']
						) === $old_post_id
					)
				) {
					$single_condition['payload']['post_id'] = $post_id;
				}

				$section_value['sections'][$index]['settings'][
					'transparent_conditions'
				][$cond_index] = $single_condition;
			}
		}

		set_theme_mod('header_placements', $section_value);
	}

	public function get_conditions() {
		$option = get_theme_mod('rishi_premium_header_conditions', []);

		if (empty($option)) {
			return [];
		}

		return $option;
	}

	public function set_conditions($conditions) {
		set_theme_mod('rishi_premium_header_conditions', $conditions);
	}

	public function get_call_fn($args = [], ...$params) {
	$args = wp_parse_args(
		$args,
		[
			'fn' => null,

			// string | null | array
			'default' => ''
		]
	);

	if (! $args['fn']) {
		throw new Error('$fn must be specified!');
	}

	if (! function_exists($args['fn'])) {
		return $args['default'];
	}

	return call_user_func($args['fn'], ...$params);
}
}

