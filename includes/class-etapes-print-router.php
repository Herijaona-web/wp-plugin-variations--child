<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       x
 * @since      4.0.0
 *
 * @package    Etapes_Print
 * @subpackage Etapes_Print/studio
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      4.0.0
 * @package    Etapes_Print
 * @subpackage Etapes_Print/studio
 * @author     Njakasoa Rasolohery <ras.njaka@gmail.com>
 */
class Etapes_Print_Router {
	public function include_template( $template )
	{
			//try and get the query var we registered in our query_vars() function
			$studio_page = get_query_var( 'studio_page' );

			//if the query var has data, we must be on the right page, load our custom template
			if ( $studio_page ) {
				return plugin_dir_path( dirname( __FILE__ ) ) . "studio/index.html";
			}

			return $template;
	}

	public function flush_rules()
	{
			$this->rewrite_rules();
			flush_rewrite_rules();
	}

	public function rewrite_rules()
	{
			add_rewrite_rule( 'studio/(.+?)$', 'index.php?studio_page=$matches[1]', 'top');
			add_rewrite_tag( '%studio_page%', '([^&]+)' );
	}
}
