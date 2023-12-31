<?php

/**
 * Generate colors based on input.
 *
 * @param array $color_descriptor Colors array.
 */
if ( ! function_exists( 'rishi__cb_customizer_get_colors' ) ) {
	function rishi__cb_customizer_get_colors( $color_descriptor, $defaults ) {
		$result = array();

		foreach ( $defaults as $id => $default_data ) {
			$data = $default_data;

			if (
				is_array( $color_descriptor )
				&&
				isset( $color_descriptor[ $id ] )
				&&
				is_array( $color_descriptor[ $id ] )
			) {
				$data = $color_descriptor[ $id ];
			}

			$result[ $id ] = rishi__cb_customizer_get_color( $data );
		}

		return $result;
	}
}

/**
 * Extract color from a descriptor.
 * id:
 *   - fw-custom
 *   - fw-no-color
 *   - color_skin_*
 *   - fw-inherit:location
 *   - fw-inherit:location:hover
 *   - fw-inherit:location:default
 *
 * @param array $color_descriptor Single color descriptor.
 */
if ( ! function_exists( 'rishi__cb_customizer_get_color' ) ) {
	function rishi__cb_customizer_get_color( $color_descriptor ) {
		if ( ! isset( $color_descriptor['color'] ) ) {
			return null;
		}

		return $color_descriptor['color'];
	}
}

if ( ! function_exists( 'rishi__cb_customizer_output_colors' ) ) {
	function rishi__cb_customizer_output_colors( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'css'                     => null,
				'tablet_css'              => null,
				'mobile_css'              => null,
				'value'                   => null,
				'default'                 => null,
				'variables'               => array(),

				'desktop_selector_prefix' => '',
				'tablet_selector_prefix'  => '',
				'mobile_selector_prefix'  => '',

				'important'               => false,
				'responsive'              => false,
			)
		);

		rishi__cb_customizer_assert_args( $args, array( 'css', 'default' ) );

		if ( $args['responsive'] ) {
			rishi__cb_customizer_assert_args( $args, array( 'tablet_css', 'mobile_css' ) );
		}

		$responsive_value         = rishi__cb_customizer_expand_responsive_value( $args['value'] );
		$responsive_default_value = rishi__cb_customizer_expand_responsive_value( $args['default'] );

		$desktop_colors = rishi__cb_customizer_get_colors(
			$responsive_value['desktop'],
			$responsive_default_value['desktop']
		);

		$tablet_colors = rishi__cb_customizer_get_colors(
			$responsive_value['tablet'],
			$responsive_default_value['tablet']
		);

		$mobile_colors = rishi__cb_customizer_get_colors(
			$responsive_value['mobile'],
			$responsive_default_value['mobile']
		);

		foreach ( $args['variables'] as $key => $descriptor ) {
			if ( ! isset( $descriptor['selector'] ) ) {
				$descriptor['selector'] = ':root';
			}

			$local_args = array(
				'css'                     => $args['css'],
				'tablet_css'              => $args['tablet_css'],
				'mobile_css'              => $args['mobile_css'],

				'desktop_selector_prefix' => $args['desktop_selector_prefix'],
				'tablet_selector_prefix'  => $args['tablet_selector_prefix'],
				'mobile_selector_prefix'  => $args['mobile_selector_prefix'],

				'selector'                => $descriptor['selector'],
				'variableName'            => $descriptor['variable'],
				'value'                   => array(
					'desktop' => $desktop_colors[ $key ],
					'tablet'  => $tablet_colors[ $key ],
					'mobile'  => $mobile_colors[ $key ],
				),

				'responsive'              => $args['responsive'],
			);

			if ( $args['important'] ) {
				$local_args['value_suffix'] = ' !important';
			}

			rishi__cb_customizer_output_css_vars( $local_args );
		}
	}
}
