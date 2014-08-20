<?php

/**
 *  Install Add-ons
 *
 *  The following code will include all 4 premium Add-Ons in your theme.
 *  Please do not attempt to include a file which does not exist. This will produce an error.
 *
 *  All fields must be included during the 'acf/register_fields' action.
 *  Other types of Add-ons (like the options page) can be included outside of this action.
 *
 *  The following code assumes you have a folder 'add-ons' inside your theme.
 *
 *  IMPORTANT
 *  Add-ons may be included in a premium theme as outlined in the terms and conditions.
 *  However, they are NOT to be included in a premium / free plugin.
 *  For more information, please read http://www.advancedcustomfields.com/terms-conditions/
 */

/**
 *  Register Field Groups
 *
 *  The register_field_group function accepts 1 array which holds the relevant data to register a field group
 *  You may edit the array as you see fit. However, this may result in errors if the array is not compatible with ACF
 */

if ( function_exists( "register_field_group" ) ) {

	$default_location =	array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'tracking-code.php',
					'order_no' => 0,
					'group_no' => 0,
				);

	$locations = apply_filters( 'stct_display_options' , $default_location );

	register_field_group(array (
		'id' => 'acf_conversion-codes',
		'title' => 'Conversion Codes',
		'fields' => array (
			array (
				'key' => 'field_53e435fbdaae7',
				'label' => 'Header Conversion Code',
				'name' => 'header_code',
				'type' => 'textarea',
				'instructions' => 'Any codes where you are asked to place them between HEAD tags.',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'html',
			),
			array (
				'key' => 'field_53e43630daae8',
				'label' => 'Other Conversion Codes',
				'name' => 'other_codes',
				'type' => 'textarea',
				'instructions' => 'All codes here will be loaded before the closing /BODY tag.',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'html',
			),
		),
		'location' => array( array ( $locations ) ),

		'options' => array (
			'position' => 'normal',
			'layout' => 'meta_box',
			'hide_on_screen' => array (),
		),
		'menu_order' => 0,
	) ) ;
}