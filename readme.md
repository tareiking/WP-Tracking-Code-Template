### Sennza Tracking Code Template

WordPress plugin designed to add a page template named **Tracking Code*** where you input unfiltered JS codes into your content.

### Pre-requisities:

- [ ] Advanced Custom Fields

### Future considerations

- [ ] Remove reliance on Template file so code is applied to all post types
- [ ] Add filters for selecting post types to filter
- [ ] Hide template from page template view if stct_display_options filter alters the default

### Filter Usage

```stct_display_options```

Example:

```
		/**
		 * Change the ACF location array which controls visibility
		 *
		 * This example shows meta boxes on all pages.
		 */
		function show_tracking_code_on_pages( $acf_location ) {

			$acf_location =	array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'page',
							'order_no' => 0,
							'group_no' => 0,
						);

			return $acf_location;
		}

		add_filter( 'stct_display_options', show_tracking_code_on_pages );
```

