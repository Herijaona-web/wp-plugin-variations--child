<?php

/**
 * Fired during plugin activation
 *
 * @link       x
 * @since      4.0.0
 *
 * @package    Etapes_Print
 * @subpackage Etapes_Print/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      4.0.0
 * @package    Etapes_Print
 * @subpackage Etapes_Print/includes
 * @author     Njakasoa Rasolohery <ras.njaka@gmail.com>
 */
class Etapes_Print_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    4.0.0
	 */
	public static function activate() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		$table_name = $wpdb->prefix."etapes_print_paper";
		$sql_create_paper = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` mediumint(11) NOT NULL AUTO_INCREMENT,
			`code` varchar(80) NOT NULL,
			`name` varchar(80) NOT NULL,
			`position` smallint(5) NOT NULL,
			`weight` varchar(20) NOT NULL,
			`paper_p100kg` varchar(255),
			`paper_sq_rn` varchar(255),
			`packing_value` varchar(255),
			`packing_paper_color` varchar(16),
			`margin` varchar(255),
			PRIMARY KEY  (`id`, `code`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$sql_drop_paper = "DROP TABLE IF EXISTS `$table_name`;";

		$table_name = $wpdb->prefix."etapes_print_format";
		$sql_create_format = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` mediumint(11) NOT NULL AUTO_INCREMENT,
			`code` varchar(80) NOT NULL,
			`name` varchar(80) NOT NULL,
			`position` smallint(5) NOT NULL,
			`height` varchar(255) NOT NULL,
			`width` varchar(255) NOT NULL,
			`format_setup_price` varchar(255),
			`format_p1000` varchar(255),
			PRIMARY KEY  (`id`, `code`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$sql_drop_format = "DROP TABLE IF EXISTS `$table_name`;";

		$table_name = $wpdb->prefix."etapes_print_colors";
		$sql_create_colors = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` mediumint(11) NOT NULL AUTO_INCREMENT,
			`code` varchar(80) NOT NULL,
			`name` varchar(80) NOT NULL,
			`position` smallint(5) NOT NULL,
			`colors_front` smallint(5) NOT NULL,
			`colors_back` smallint(5) NOT NULL,
			`colors_setup_price` varchar(255),
			`colors_p1000` varchar(255),
			`colors_sq_rn` varchar(255),
			`margin` varchar(255),
			PRIMARY KEY  (`id`, `code`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$sql_drop_colors = "DROP TABLE IF EXISTS `$table_name`;";


		$table_name = $wpdb->prefix."etapes_print_book_binding";
		$sql_create_book_binding = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` mediumint(11) NOT NULL AUTO_INCREMENT,
			`code` varchar(80) NOT NULL,
			`name` varchar(80) NOT NULL,
			`position` smallint(5) NOT NULL,
			`production_time` smallint(1) NOT NULL,
			`book_binding_setup_price` varchar(255),
			`book_binding_p1000` varchar(255),
			`book_binding_sq_rn` varchar(255),
			PRIMARY KEY  (`id`, `code`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$sql_drop_book_binding = "DROP TABLE IF EXISTS `$table_name`;";


		$table_name = $wpdb->prefix."etapes_print_refinement";
		$sql_create_refinement = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` mediumint(11) NOT NULL AUTO_INCREMENT,
			`code` varchar(80) NOT NULL,
			`name` varchar(80) NOT NULL,
			`position` smallint(5) NOT NULL,
			`production_time` smallint(1) NOT NULL,
			`refinement_setup_price` varchar(255),
			`refinement_p1000` varchar(255),
			`refinement_sq_rn` varchar(255),
			`margin` varchar(255),
			PRIMARY KEY  (`id`, `code`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$sql_drop_refinement = "DROP TABLE IF EXISTS `$table_name`;";



		$table_name = $wpdb->prefix."etapes_print_finishing";
		$sql_create_finishing = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` mediumint(11) NOT NULL AUTO_INCREMENT,
			`code` varchar(80) NOT NULL,
			`name` varchar(80) NOT NULL,
			`position` smallint(5) NOT NULL,
			`finishing_setup_price` varchar(255),
			`finishing_p1000` varchar(255),
			`finishing_sq_rn` varchar(255),
			PRIMARY KEY  (`id`, `code`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$sql_drop_finishing = "DROP TABLE IF EXISTS `$table_name`;";

		$table_name = $wpdb->prefix."etapes_print_modele";
		$sql_create_modele = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` mediumint(11) NOT NULL AUTO_INCREMENT,
			`code` varchar(80) NOT NULL,
			`name` varchar(80) NOT NULL,
			`position` smallint(5) NOT NULL,
			`modele_setup_price` varchar(255),
			PRIMARY KEY  (`id`, `code`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$sql_drop_modele = "DROP TABLE IF EXISTS `$table_name`;";

		$table_name = $wpdb->prefix."etapes_print_proof_group";
		$sql_create_proof_group = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` mediumint(11) NOT NULL AUTO_INCREMENT,
			`code` varchar(80) NOT NULL,
			`name` varchar(80) NOT NULL,
			`position` smallint(5) NOT NULL,
			`proof_group_setup_price` varchar(255),
			PRIMARY KEY  (`id`, `code`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$sql_drop_proof_group = "DROP TABLE IF EXISTS `$table_name`;";

		$table_name = $wpdb->prefix."etapes_print_select_rule";
		$sql_create_select_rule = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` mediumint(11) NOT NULL AUTO_INCREMENT,
			`code` varchar(80) NOT NULL,
			`select` varchar(1000),
			`denies` varchar(1000),
			PRIMARY KEY  (`id`, `code`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$sql_drop_select_rule = "DROP TABLE IF EXISTS `$table_name`;";

		$table_name = $wpdb->prefix."etapes_print_deny_rule";
		$sql_create_deny_rule = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` mediumint(11) NOT NULL AUTO_INCREMENT,
			`code` varchar(80) NOT NULL,
			`deny` varchar(1000),
			PRIMARY KEY  (`id`, `code`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$sql_drop_deny_rule = "DROP TABLE IF EXISTS `$table_name`;";

		$table_name = $wpdb->prefix."etapes_print_cover";
		$sql_create_cover = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` mediumint(11) NOT NULL AUTO_INCREMENT,
			`code` varchar(80) NOT NULL,
			`format` varchar(1000),
			`default_format` varchar(80),
			`paper` varchar(1000),
			`default_paper` varchar(80),
			PRIMARY KEY  (`id`, `code`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$sql_drop_cover = "DROP TABLE IF EXISTS `$table_name`;";

		$table_name = $wpdb->prefix."etapes_print_product_api_list";
		$sql_create_product_api_list = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` mediumint(11) NOT NULL AUTO_INCREMENT,
			`product_name` varchar(80) NOT NULL,
			`category_name` varchar(80) NOT NULL,
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$sql_drop_product_api_list = "DROP TABLE IF EXISTS `$table_name`;";

		$table_name = $wpdb->prefix."etapes_print_gestion_market";
		$sql_create_gestion_market = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` mediumint(11) NOT NULL AUTO_INCREMENT,
			`societe` varchar(80),
			`nom_gestionnaire` varchar(80),
			`adresse_postale` varchar(80),
			`contact` varchar(80),
			`url_marketplace` varchar(80),
			`cle_identification` varchar(1000),
			`remise_revendeur` varchar(80),
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;"; 
		$sql_drop_gestion_market = "DROP TABLE IF EXISTS `$table_name`;";

		$table_name = $wpdb->prefix."etapes_print_gestion_market_consultation_facture";
		$sql_create_gestion_market_consultation_facture = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` mediumint(11) NOT NULL AUTO_INCREMENT,
			`date` date NOT NULL,
			`numeros` mediumint(50) NOT NULL,
			`reference` varchar(50) NOT NULL,
			`votre_reference` varchar(50) NOT NULL,
			`contact` varchar(50) NOT NULL,
			`montant_ttc` varchar(50) NOT NULL,
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;"; 
		$sql_drop_gestion_market_consultation_facture = "DROP TABLE IF EXISTS `$table_name`;";

		$table_name = $wpdb->prefix."etapes_print_status_plugin";
		$sql_create_status_plugin = "CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` mediumint(11) NOT NULL AUTO_INCREMENT,
			`status_plugin` varchar(10) NOT NULL DEFAULT 'actif',
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;"; 
		$sql_drop_status_plugin = "DROP TABLE IF EXISTS `$table_name`;";




		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		/*
		$wpdb->query($sql_drop_paper);
		$wpdb->query($sql_drop_format);
		$wpdb->query($sql_drop_colors);
		$wpdb->query($sql_drop_book_binding);
		$wpdb->query($sql_drop_refinement);
		$wpdb->query($sql_drop_finishing);
		$wpdb->query($sql_drop_modele);
		$wpdb->query($sql_drop_cover);
		*/
	
		/*
		dbDelta($sql_create_paper);
		dbDelta($sql_create_format);
		dbDelta($sql_create_colors);
		dbDelta($sql_create_book_binding);
		dbDelta($sql_create_refinement);
		dbDelta($sql_create_finishing);
		dbDelta($sql_create_modele);
		dbDelta($sql_create_proof_group);
		dbDelta($sql_create_select_rule);
		dbDelta($sql_create_deny_rule);
		dbDelta($sql_create_cover);
		dbDelta($sql_create_gestion_market);
		dbDelta($sql_create_gestion_market_consultation_facture);
		*/
		dbDelta($sql_create_status_plugin);
		dbDelta($sql_create_product_api_list);
		dbDelta($sql_create_gestion_market_consultation_facture);
		dbDelta($sql_create_gestion_market);

		/*
		if (!get_option('etapes_print_price_array')) {
			update_option('etapes_print_price_debugger', '127.0.0.1');
			update_option('etapes_print_custom_display_limit', 5);
			update_option('etapes_print_delivery_price', 7);
			update_option('etapes_print_price_array', '50,150,250,500,1000,1500,2000');
			update_option('etapes_print_default_quantity', 1000);
			update_option('etapes_print_delay_delivery', 1);
		}
		*/

		$table_name2 = $wpdb->prefix . 'etapes_print_status_plugin';
		$wpdb->insert( $table_name2, array( 'status_plugin' => 'actif', ) );
	}



}
