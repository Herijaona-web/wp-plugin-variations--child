<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       x
 * @since      4.0.0
 *
 * @package    Etapes_Print
 * @subpackage Etapes_Print/admin
 */

global $wpdb;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Etapes_Print
 * @subpackage Etapes_Print/admin
 * @author     Njakasoa Rasolohery <ras.njaka@gmail.com>
 */
class Etapes_Print_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    4.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    4.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $dataset;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    4.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $dataset ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->dataset = $dataset;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    4.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Etapes_Print_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Etapes_Print_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/etapes-print-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    4.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Etapes_Print_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Etapes_Print_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/etapes-print-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_menu() {
		add_menu_page( 'Etapes Print Admin', 'EP Admin', 'manage_woocommerce', $this->plugin_name, array( $this, 'displayAdminEPOptions' ));

		$options = $this->dataset->get_options_table();

		foreach ($options as $option) {
			add_submenu_page(
				$this->plugin_name,
				$this->dataset->get_label_by_key($option),
				$this->dataset->get_label_by_key($option),
				'manage_woocommerce',
				$this->plugin_name . '-' . $option,
				array($this,'displayAdminPageOptions')
			);
		}

		// ADD COVER SUBMENU
		add_submenu_page(
			$this->plugin_name,
			'Couverture',
			'Couverture',
			'manage_woocommerce',
			$this->plugin_name . '-cover',
			array($this,'displayAdminPageCover')
		);

		// ADD RULE SUBMENU PAGES
		add_submenu_page(
			$this->plugin_name,
			'Select Rules',
			'Select Rules',
			'manage_woocommerce',
			$this->plugin_name . '-select-rule',
			array($this,'displayAdminPageRule')
		);
		add_submenu_page(
			$this->plugin_name,
			'Deny Rules',
			'Deny Rules',
			'manage_woocommerce',
			$this->plugin_name . '-deny-rule',
			array($this,'displayAdminPageRule')
		);
		add_submenu_page(
			$this->plugin_name,
			'Produits Etapes Print',
			'Produits Etapes Print',
			'manage_woocommerce',
			$this->plugin_name . '-produits-etapes-print',
			array($this,'displayAdminPageproduitsEtapesPrint')
		);	
		add_submenu_page(
			$this->plugin_name,
			"Mes factures d'achats",
			"Mes factures d'achats",
			'manage_woocommerce',
			$this->plugin_name . '-factures-achats',
			array($this,'displayAdminFacturationClient')
		);
	}

	/**
	 * Factures d'achats
	 */
	public function displayAdminFacturationClient(){
		if ( ! class_exists( 'Gestion_Market_Consultation_Facture' ) ) {
			require_once( plugin_dir_path( __FILE__ ) . 'modules/class-etapes-print-factures-achats.php' );
		}
		$my_table_list = new Gestion_Market_Factures_achats();
		$my_table_list->prepare_items();
		include( plugin_dir_path( __FILE__ ) . 'partials/factures-achats/etapes-print-admin-factures-achats.php' );
	}
		
	public function messageErreur($msg){
		echo '<div class="msg_pep">'.$msg;'</div>';
	}
	public function displayAdminPageproduitsEtapesPrint(){		
		global $wpdb;
		$table_name = $wpdb->prefix . 'etapes_print_gestion_market';
			if(isset($_POST['submit_cle_activation'])){
				if(isset($_POST['cle_activation']) && !empty($_POST['cle_activation'])){
					$cle=sanitize_text_field($_POST['cle_activation']);
					$site=site_url('/');
					$url = 'http://main-site.local/wp-json/etapes-print/v1/gestionMarket/'.$cle; 
					$data = @file_get_contents($url);										
					if($data){
						var_dump($data);	
						$mydata = json_decode($data, true);						
						if($mydata[0]['0']['status']=='1'){
							$row = array(
								'societe' => $mydata[0]['societe'],
								'nom_gestionnaire'=> $mydata[0]['nom_gestionnaire'],
								'adresse_postale'=> $mydata[0]['adresse_postale'],
								'contact'=> $mydata[0]['contact'],
								'email_contact'=> $mydata[0]['email_contact'],
								'url_marketplace'=> $mydata[0]['url_marketplace'],
								'cle_identification'=> $mydata[0]['cle_identification'],
								'remise_revendeur'=> $mydata[0]['remise_revendeur'],			
							);

							if($cle==$row['cle_identification'] AND $site==$row['url_marketplace']){
								$sql = $wpdb->prepare( "SELECT * FROM $table_name WHERE cle_identification = %s AND url_marketplace=%s", $mydata[0]['cle_identification'],$mydata[0]['url_marketplace']);
								$rs = $wpdb->get_row( $sql);
													
								if($rs==0){
									$wpdb->insert( $table_name, $row );								
								}												
								$query = $wpdb->prepare( "SELECT * FROM $table_name WHERE cle_identification = %s AND url_marketplace=%s", $mydata[0]['cle_identification'],$mydata[0]['url_marketplace']);
								$result = $wpdb->get_row( $query);
								if($result){
									
									include( plugin_dir_path( __FILE__ ) .'partials/produits-etapes-print/displayAdminFormPageproduitsEtapesPrint.php' );
								
								}				
							}else{
								$erreur='Clé d\'identification non valide';
								$msg=$this->messageErreur($erreur);				
							}


						}else{

							$erreur='Connexion réfuser';
							$msg=$this->messageErreur($erreur);	

						}
					}else{
						$erreur='Clé d\'identification non valide';
						$msg=$this->messageErreur($erreur);	
					}

				}else{
					$erreur='champ requis';
					$msg=$this->messageErreur($erreur);	
				}				
			}elseif(isset($_GET['facture_achat'])){
				include( plugin_dir_path( __FILE__ ) .'partials/produits-etapes-print/factureAchatProduitEtapesPrint.php' );	
			}else{
				include( plugin_dir_path( __FILE__ ) .'partials/produits-etapes-print/displayPageproduitsEtapesPrint.php' );		
			}

			
	}
	public function displayAdminPageCover() {
		global $wpdb;
		$page = $_GET['page'];
		$table_name = $wpdb->prefix . str_replace('-', '_', $page);
		$my_table_name = $this->dataset->get_label_by_key($page);
		if (isset( $_GET['action'] ) && $_GET['action'] == 'delete' && isset( $_GET['id'] ) ) {
			$id = intval( $_GET['id'] );
			$wpdb->delete( $table_name, array( 'id' => $id ) );
			wp_redirect( add_query_arg( array( 'page' => $page ), admin_url( 'admin.php' ) ) );
			exit;
		}

		$options_table = $this->dataset->get_options_table();
		if (isset( $_GET['action'] ) && $_GET['action'] == 'edit' && isset( $_GET['id'] ) ) {
			$id = intval( $_GET['id'] );
			if ( isset( $_POST['submit'] ) ) {
				$code = sanitize_text_field( $_POST['code'] );
				$row = array('code' => $code);
				$row['format'] = implode(',', $_POST['etapes_print_format_values']);
				$row['default_format'] = sanitize_text_field( $_POST['etapes_print_format_default_value'] );
				$row['paper'] = implode(',', $_POST['etapes_print_paper_values']);
				$row['default_paper'] = sanitize_text_field( $_POST['etapes_print_paper_default_value'] );
				$wpdb->update( $table_name, $row, array( 'id' => $id ) );
				wp_redirect( add_query_arg( array( 'page' => $page ), admin_url( 'admin.php' ) ) );
				exit;
			}

			$query = $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $id );
			$row = $wpdb->get_row( $query, ARRAY_A );
			if ( ! $row ) {
				wp_die( 'Ligne non trouvée!' );
			}
			$currentData['format'] = explode(',', $row['format']);
			$currentData['paper'] = explode(',', $row['paper']);
			$formatList = $this->dataset->get_option_table_values('format');
			$paperList = $this->dataset->get_option_table_values('paper');
			include( plugin_dir_path( __FILE__ ) . 'partials/cover/etapes-print-admin-cover-new-or-edit.php' );
			exit;
		}

		if ( isset( $_GET['action'] ) && $_GET['action'] == 'add' ) {
			if ( isset( $_POST['submit'] ) ) {
				$code = sanitize_text_field( $_POST['code'] );
				$row = array('code' => $code);
				$row['format'] = implode(',', $_POST['etapes_print_format_values']);
				$row['default_format'] = sanitize_text_field( $_POST['etapes_print_format_default_value'] );
				$row['paper'] = implode(',', $_POST['etapes_print_paper_values']);
				$row['default_paper'] =sanitize_text_field( $_POST['etapes_print_paper_default_value'] );
				$wpdb->insert( $table_name, $row );
				wp_redirect( add_query_arg( array( 'page' => $page ), admin_url( 'admin.php' ) ) );
				exit;
			}
			$currentData['format'] = [];
			$currentData['paper'] = [];
			$row = array('code' => '');
			$formatList = $this->dataset->get_option_table_values('format');
			$paperList = $this->dataset->get_option_table_values('paper');
			include( plugin_dir_path( __FILE__ ) . 'partials/cover/etapes-print-admin-cover-new-or-edit.php' );
			exit;
		}

		if ( ! class_exists( 'Cover_Table_List' ) ) {
			require_once( plugin_dir_path( __FILE__ ) . 'modules/class-etapes-print-cover-table.php' );
		}
		$my_table_list = new Cover_Table_List();
		$my_table_list->prepare_items();
		include( plugin_dir_path( __FILE__ ) . 'partials/cover/etapes-print-admin-cover-list.php' );
	}

	public function displayAdminPageRule() {
		global $wpdb;
		$page = $_GET['page'];
		$table_name = $wpdb->prefix . str_replace('-', '_', $page);
		$my_table_name = $this->dataset->get_label_by_key($page);
		if (isset( $_GET['action'] ) && $_GET['action'] == 'delete' && isset( $_GET['id'] ) ) {
			$id = intval( $_GET['id'] );
			$wpdb->delete( $table_name, array( 'id' => $id ) );
			wp_redirect( add_query_arg( array( 'page' => $page ), admin_url( 'admin.php' ) ) );
			exit;
		}

		$options_table = $this->dataset->get_options_table();
		if (isset( $_GET['action'] ) && $_GET['action'] == 'edit' && isset( $_GET['id'] ) ) {
			$id = intval( $_GET['id'] );
			if ( isset( $_POST['submit'] ) ) {
				$code = sanitize_text_field( $_POST['code'] );
				$select_array = array();
				foreach ( $options_table as $option ) {
					$name = 'etapes_print_' . $option . '_values';	
					$select_array[] = implode(',', $_POST[$name] ? $_POST[$name] : []);
				}
				$row = array('code' => $code);
				if ($page == 'etapes-print-select-rule') {
					$row['select'] = implode(';', $select_array);
					$row['denies'] = implode(',', $_POST['deny']);
				} else {
					$row['deny'] = implode(';', $select_array);
				}
				$wpdb->update( $table_name, $row, array( 'id' => $id ) );
				wp_redirect( add_query_arg( array( 'page' => $page ), admin_url( 'admin.php' ) ) );
				exit;
			}

			$query = $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $id );
			$row = $wpdb->get_row( $query, ARRAY_A );
			if ( ! $row ) {
				wp_die( 'Ligne non trouvée!' );
			}
			$options_data = array();
			$currentData = array();
			
			if ($page == 'etapes-print-select-rule') {
				$deny_table = $wpdb->prefix . 'etapes_print_deny_rule';
				$query = "SELECT code FROM $deny_table ORDER BY code ASC";
        		$denyData = $wpdb->get_results( $query, ARRAY_A );
				$denyList = explode(',', $row['denies']);
			}
			$select_array = explode(';', $page == 'etapes-print-select-rule' ? $row['select'] : $row['deny']);
			foreach ( $options_table as $index => $option ) {
				$options_data[$option] = $this->dataset->get_option_table_values($option);
				$currentData[$option] = explode(',', $select_array[$index]); 
			}
			include( plugin_dir_path( __FILE__ ) . 'partials/rule/etapes-print-admin-rule-new-or-edit.php' );
			exit;
		}

		if ( isset( $_GET['action'] ) && $_GET['action'] == 'add' ) {
			if ( isset( $_POST['submit'] ) ) {
				$code = sanitize_text_field( $_POST['code'] );
				$select_array = array();
				foreach ( $options_table as $option ) {
					$name = 'etapes_print_' . $option . '_values';	
					$select_array[] = implode(',', $_POST[$name] ? $_POST[$name] : []);
				}
				$row = array('code' => $code);
				if ($page == 'etapes-print-select-rule') {
					$row['select'] = implode(';', $select_array);
					$row['denies'] = implode(',', $_POST['deny']);
				} else {
					$row['deny'] = implode(';', $select_array);
				}
				$wpdb->insert( $table_name, $row );
				wp_redirect( add_query_arg( array( 'page' => $page ), admin_url( 'admin.php' ) ) );
				exit;
			}
			$options_data = array();
			$currentData = array();
			$row = array('code' => '');
			if ($page == 'etapes-print-select-rule') {
				// get deny_rules_list
				$deny_table = $wpdb->prefix . 'etapes_print_deny_rule';
				$query = "SELECT code FROM $deny_table ORDER BY code ASC";
        		$denyData = $wpdb->get_results( $query, ARRAY_A );
				$denyList = [];
			}
			foreach ( $options_table as $index => $option ) {
				$options_data[$option] = $this->dataset->get_option_table_values($option);
				$currentData[$option] = []; 
			}
			include( plugin_dir_path( __FILE__ ) . 'partials/rule/etapes-print-admin-rule-new-or-edit.php' );
			exit;
		}

		if ($page == 'etapes-print-select-rule') {
			if ( ! class_exists( 'Select_Rule_Table_List' ) ) {
				require_once( plugin_dir_path( __FILE__ ) . 'modules/class-etapes-print-select-rule-table.php' );
			}
			$my_table_list = new Select_Rule_Table_List();
		} else {
			if ( ! class_exists( 'Deny_Rule_Table_List' ) ) {
				require_once( plugin_dir_path( __FILE__ ) . 'modules/class-etapes-print-deny-rule-table.php' );
			}
			$my_table_list = new Deny_Rule_Table_List();
		}
		$my_table_list->prepare_items();
		include( plugin_dir_path( __FILE__ ) . 'partials/rule/etapes-print-admin-rule-list.php' );
	}

	public function displayAdminPageOptions() {
		global $wpdb;
		$page = $_GET['page'];

  		$table_name = $wpdb->prefix . str_replace('-', '_', $page);

		$fields = $this->dataset->get_option_fields($page);

		if (isset($_POST['epexport'])) {
			$date = date("Y-m-d H:i:s");

			header('Content-Type: text/csv; charset=utf-8');
			header("Content-Disposition: attachment; filename=\"" . $page . " " . $date . ".csv\";" );

			// clean out other output buffers
			ob_end_clean();

			$output = fopen("php://output", "w");
			$default_fields = array("id", "code", "name", "position");
			$all_fields = array_merge($default_fields, array_keys($fields));
			fputcsv($output, $all_fields );
			
			$query = "SELECT * FROM $table_name ORDER BY position ASC";
			$result = $wpdb->get_results($query, ARRAY_A);
			if (!empty($result)) {
				foreach($result as $rec) { 
					fputcsv($output, array_values($rec));       
				}
			}
			fclose( $output );
			exit;
		}
		if (isset($_POST['epimport'])) {
			$ep_error = false;
			$default_fields = array("id", "code", "name", "position");
			$all_fields = array_merge($default_fields, array_keys($fields));
			if ($_FILES['csvfile']['name']) {
				$filename = explode(".", $_FILES['csvfile']['name']);
				if ($filename[1] == 'csv') {
					$handle = fopen($_FILES['csvfile']['tmp_name'], "r");
				   	$i = 0;
					while (($getData = fgetcsv($handle)) !== FALSE) {
						if ($i === 0) {
							$csv_headers = array();
							$headers_len = count($getData);
							
							// check headers with fields
							foreach ($all_fields as $field) {
								for ($k = 0; $k < $headers_len; $k++) {
									$csv_header = str_replace("?", "", utf8_decode($getData[$k]));
									if (strcmp($field, $csv_header) === 0) {
										$csv_headers[$field] = $k;
										break;
									}
								}
								if (!array_key_exists($field, $csv_headers)) {
									?>
										<div class="notice notice-error">
											<p><?php _e( "Field <b>$field</b> not found in csv file headers", 'etapes-print' ); ?></p>
											<p><?php echo print_r($getData); ?></p>
										</div>
									<?php
									$ep_error = true;
									break;
								}
							}
						} else {
							$id = $getData[$csv_headers['id']];
							$code = $getData[$csv_headers['code']];
							$name = $getData[$csv_headers['name']];
							$position = $getData[$csv_headers['position']];
							$sql_id = "";
							$sql_id_value = "";
							if ($id) {
								$sql_id = "id,";
								$sql_id_value = "$id,";
							}
							$sql_insert = "INSERT INTO $table_name ($sql_id code, name, position";
							foreach ($fields as $key => $value) {
								$sql_insert = "$sql_insert, $key";
							}
							$sql_insert = "$sql_insert) VALUES ($sql_id_value '$code',\"$name\", $position";
							$sql_update = "code='$code', name=\"$name\", position='$position'";
							foreach ($fields as $key => $value) {
								$index = $csv_headers[$key];
								$val = $getData[$index];
								if ($value == 'number') {
									if (!$val) $val = 0; 
									$sql_insert = "$sql_insert, $val";
									$sql_update = "$sql_update, $key=$val";
								} else {
									if ($key == 'margin') {
										if (!$val) $val = 1;
									}
									$sql_insert = "$sql_insert, '$val'";
									$sql_update = "$sql_update, $key='$val'";
								}
							}
							$sql_insert = "$sql_insert) ON DUPLICATE KEY UPDATE $sql_update";
							// echo "$sql_insert <br>";
							if ( false === $wpdb->query($sql_insert)) {
								?>
									<div class="notice notice-error">
										<p><b><?php _e( "Import has failed while executing the SQL below: ", 'etapes-print' ); ?></b></p>
										<p><?php echo $sql_insert; ?></p>
									</div>
								<?php
								$ep_error = true;
								break;
							}
						}
						$i++;
					}
					if (!$ep_error) {
						$count = $i - 1;
						?>
							<div class="notice updated notice-sucess is-dismissible">
								<p><?php _e( "$count <b>$page</b> items successfully imported", 'etapes-print' ); ?></p>
							</div>
						<?php
					}
					fclose($handle);
				}
			}
		}
		if (isset($_POST['newsubmit'])) {
			$code = $_POST['newcode'];
			$name = $_POST['newname'];
			$position = $_POST['newposition'];

			$sql_insert = "INSERT INTO $table_name(code, name, position";
			foreach ($fields as $key => $value) {
				$sql_insert = "$sql_insert, $key";
			}
			$sql_insert = "$sql_insert) VALUES('$code',\"$name\", $position";
			foreach ($fields as $key => $value) {
				$val = $_POST["new$key"];
				if ($value == 'number') {
					if (!$val) $val = 0; 
					$sql_insert = "$sql_insert, $val";
				} else {
					if ($key == 'margin') {
						if (!$val) $val = 1;
					}
					$sql_insert = "$sql_insert, '$val'";
				}
			}
			$sql_insert = "$sql_insert)";

			$this->dataset->run_query_handle_sql_error($sql_insert, $page);
		}

		if (isset($_POST['uptsubmit'])) {
			$id = $_POST['uptid'];
			$code = $_POST['uptcode'];
			$name = $_POST['uptname'];
			$position = $_POST['uptposition'];
			
			$sql_update = "UPDATE $table_name SET code='$code', name=\"$name\", position=$position";

			foreach ($fields as $key => $value) {
				$val = $_POST["upt$key"];
				if ($value == 'number') {
					if (!$val) $val = 0;
					$sql_update = "$sql_update, $key=$val";
				} else {
					if ($key == 'margin') {
						if (!$val) $val = 1;
					}
					$sql_update = "$sql_update, $key='$val'";
				}
			}

			$sql_update = "$sql_update WHERE id='$id'";

			$this->dataset->run_query_handle_sql_error($sql_update, $page);
		}

		if (isset($_GET['del'])) {
			$del_id = $_GET['del'];
			$wpdb->query("DELETE FROM $table_name WHERE id='$del_id'");
			echo "<script>location.replace('admin.php?page=$page');</script>";
		}
	
		$results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY position ASC");
		include( plugin_dir_path( __FILE__ ) . 'partials/etapes-print-admin-options-display.php' );
	}

	
	public function displayAdminEPOptions() {
		if (isset($_POST['etapes_print_submit'])) {
			update_option('etapes_print_price_debugger', $_POST['price_debugger']);
			update_option('etapes_print_custom_display_limit', $_POST['custom_display_limit']);
			update_option('etapes_print_delivery_price', $_POST['delivery_price']);
			update_option('etapes_print_price_array', $_POST['price_array']);
			update_option('etapes_print_default_quantity', $_POST['default_quantity']);
			update_option('etapes_print_delay_delivery', $_POST['delay_delivery']);
			$customized_option = '';
			foreach ($_POST['customized_option'] as $c_options) {
				$customized_option = $customized_option . $c_options;
			}
			update_option('etapes_print_customized_option', $customized_option);
			echo "<script>location.replace('admin.php?page=etapes-print');</script>";
		}
		$customised_options = get_option('etapes_print_customized_option', '');
		$etape_print_options = $this->dataset::ETAPES_PRINT_CUSTOM_SELECT;
		include( plugin_dir_path( __FILE__ ) . 'partials/etapes-print-admin-display.php' );
	}

	public function save_fields($id, $post) {
		$options = $this->dataset->get_options();
		foreach ($options as $option) {
			if ($option === 'production') {
				update_post_meta( $id, 'etapes_print_' . $option . '_delay', $_POST['etapes_print_' . $option . '_delay'] );
			} else {
				update_post_meta( $id, 'etapes_print_' . $option, $_POST['etapes_print_' . $option] );
			}

			if ($option === 'cover') {
				update_post_meta( $id, 'etapes_print_' . $option . '_value', $_POST['etapes_print_' . $option . '_value'] );
			} else if ($option === 'display' || $option === 'select_rules') {
				update_post_meta( $id, 'etapes_print_' . $option . '_values', $_POST['etapes_print_' . $option . '_values'] );
			} else if ($option === 'quantity') {
				update_post_meta( $id, 'etapes_print_' . $option . '_price_array', $_POST['etapes_print_' . $option . '_price_array'] );
				update_post_meta( $id, 'etapes_print_' . $option . '_default_quantity', $_POST['etapes_print_' . $option . '_default_quantity'] );
				update_post_meta( $id, 'etapes_print_' . $option . '_max', $_POST['etapes_print_' . $option . '_max'] );
				update_post_meta( $id, 'etapes_print_' . $option . '_min', $_POST['etapes_print_' . $option . '_min'] );
			} else if ($option === 'custom_format') {
				update_post_meta( $id, 'etapes_print_' . $option . '_width', $_POST['etapes_print_' . $option . '_width'] );
				update_post_meta( $id, 'etapes_print_' . $option . '_height', $_POST['etapes_print_' . $option . '_height'] );
			} else {
				update_post_meta( $id, 'etapes_print_' . $option . '_values', $_POST['etapes_print_' . $option . '_values'] );
				update_post_meta( $id, 'etapes_print_' . $option . '_default_value', $_POST['etapes_print_' . $option . '_default_value'] );
			}
		}
		update_post_meta($id, '_prix_achat_ht', $_POST['_prix_achat_ht']);
		update_post_meta($id, '_marge_beneficiaire', $_POST['_marge_beneficiaire']);
	}

	public function product_settings_tabs( $tabs ){
		$tabs['etapes_print'] = array(
			'label'    => 'Etapes Print',
			'target'   => 'etapes_print_product_data',
			'priority' => 1,
		);
		return $tabs;
	}

	public function product_panels() {
		$options = $this->dataset->get_options();
		$custom_options = $this->dataset->get_custom_options_data();
		$options_table = $this->dataset->get_options_table();
		$selectRules =$this->dataset->get_select_rules();
		$covers =$this->dataset->get_covers();
		$categories =$this->dataset->get_categories();

		include( plugin_dir_path( __FILE__ ) . 'partials/panel/etapes-print-admin-product-panel.php' );
	}

	/**
   * ROUTE
   */

	public function init_admin_route() {
		register_rest_route( $this->plugin_name . '/v' . $this->version, '/price', array(
			'methods' => 'GET',
			'callback' => array($this, 'calculate'),
			'permission_callback' => '__return_true'
		) );
		register_rest_route( $this->plugin_name . '/v1','gestionMarket/(?P<id>\d+)', array(
			'methods' => 'GET',
			'callback' => array($this, 'gestionMarket'),
			'permission_callback' => '__return_true'
		) );

		$number = 1;
		register_rest_route( $this->plugin_name . '/v1','connectedPlugin/(?P<arg>[a-zA-Z0-9-]+)', array(
			'methods' => 'GET',
			'callback' => array($this, 'connectedPlugin'),
			'permission_callback' => '__return_true'
		) );		
	}

  public function calculate( WP_REST_Request $request ) {
		$debugger_on = str_contains( get_option('etapes_print_price_debugger'), $_SERVER['REMOTE_ADDR'] );

		global $wpdb;
		$options = $this->dataset->get_options();
    	$parameters = $request->get_params();

		$proof_group = 0;
		$production_time = $parameters['etapes_print_delay_delivery'];
		if (!$production_time) {
			$production_time = +get_option('etapes_print_delay_delivery');
		}

		$height = 0;
		$width = 0;
		$format_setup_price = 0;
		$format_p1000 = array();
		if ( isset($parameters['etapes_print_format']) ) {
			// check if format is custom
			if ($parameters['etapes_print_format'] === 'custom_format') {
				$width = $parameters['etapes_print_custom_format_width'];
				$height = $parameters['etapes_print_custom_format_height'];
			} else {
				$format = $this->dataset->get_option_by_code('etapes_print_format', $parameters['etapes_print_format']);
				if ($format) {
					$height = $format->height;
					$width = $format->width;
					$format_setup_price = $format->format_setup_price;
					if ($format->format_p1000) {
						$format_p1000 = $this->dataset->set_matrix($format->format_p1000, $format_p1000);
					}
				}
			}
		}

		
		// COVER FORMAT
		$no_refinement = false;
		$cover_format_setup_price = 0;
		$cover_format_p1000 = array();
		$cover_paper_weight = 0;
		$cover_paper_kg_price = 0;
		$cover_paper_running_price = array();
		$cover_paper_margin = 1;
		if ( isset($parameters['etapes_print_cover_format']) ) {
			$cover_format = $this->dataset->get_option_by_code('etapes_print_format', $parameters['etapes_print_cover_format']);
			if ($cover_format) {
				$cover_height = $cover_format->height;
				$cover_width = $cover_format->width;
				$cover_format_setup_price = $cover_format->format_setup_price;

				if ($cover_format->format_p1000) {
					$cover_format_p1000 = $this->dataset->set_matrix($cover_format->format_p1000, $cover_format_p1000);
				}
			}

			if ( isset($parameters['etapes_print_cover_paper']) && $parameters['etapes_print_cover_format'] !== 'format_sans_couv') {
				$cover_paperList = $this->dataset->get_option_by_code('etapes_print_paper', $parameters['etapes_print_cover_paper']);
				if ($cover_paperList) {
					$cover_paper_weight = $this->dataset->get_paper_weight_by_keyword($cover_paperList->weight);
					$cover_paper_kg_price = floatval($cover_paperList->paper_p100kg);
					if ($cover_paperList->paper_sq_rn) {
						$cover_paper_running_price = $this->dataset->set_matrix($cover_paperList->paper_sq_rn, $cover_paper_running_price);
					}
				} else {
					$cover_paper_weight = $this->dataset->get_paper_weight_by_keyword($parameters['etapes_print_cover_paper']);
				}
				if ($cover_paperList->margin &&  $cover_paperList->margin >= 0) {
					$cover_paper_margin = $cover_paperList->margin;
				}
			} else {
				$no_refinement = true;
			}
		}

		
		
		

		$pages = 2;
		if ( isset($parameters['etapes_print_pages']) ) {
			$pages = $this->dataset->get_paper_weight_by_keyword($parameters['etapes_print_pages']);
		}

		$paper_weight = 0;
		$paper_kg_price = 0;
		$paper_running_price = array();
		$paper_margin = 1;
		if ( isset($parameters['etapes_print_paper']) ) {
			$paperList = $this->dataset->get_option_by_code('etapes_print_paper', $parameters['etapes_print_paper']);
			if ($paperList) {
				$paper_weight = $this->dataset->get_paper_weight_by_keyword($paperList->weight);
				$paper_kg_price = floatval($paperList->paper_p100kg);
				if ($paperList->paper_sq_rn) {
					$paper_running_price = $this->dataset->set_matrix($paperList->paper_sq_rn, $paper_running_price);
				}
			} else {
				$paper_weight = $this->dataset->get_paper_weight_by_keyword($parameters['etapes_print_paper']);
			}
			if ($paperList->margin &&  $paperList->margin >= 0) {
				$paper_margin = $paperList->margin;
			}
		}

		$colors_setup_price = 0;
		$colors_p1000 = array();
		$colors_running_price = array();
		$colors_margin = 1;
		if ( isset($parameters['etapes_print_colors']) ) {
			$colors = $this->dataset->get_option_by_code('etapes_print_colors', $parameters['etapes_print_colors']);
			if ($colors) {
				if ($colors->colors_setup_price) {
					$colors_setup_price = $colors->colors_setup_price;
				}
				if ($colors->colors_p1000) {
					$colors_p1000 = $this->dataset->set_matrix($colors->colors_p1000, $colors_p1000);
				}
				if ($colors->colors_sq_rn) {
					$colors_running_price = $this->dataset->set_matrix($colors->colors_sq_rn, $colors_running_price);
				}
				if ($colors->margin &&  $colors->margin >= 0) {
					$colors_margin = $colors->margin;
				}
			}
		}

		$book_binding_setup_price	= 0;
		$book_binding_p1000 = array();
		$book_binding_running_price = array();
		if ( isset($parameters['etapes_print_book_binding']) ) {
			$book_binding = $this->dataset->get_option_by_code('etapes_print_book_binding', $parameters['etapes_print_book_binding']);
			if ($book_binding) {
				if ($book_binding->book_binding_setup_price) {
					$book_binding_setup_price = $book_binding->book_binding_setup_price;
				}
				if ($book_binding->book_binding_p1000) {
					$book_binding_p1000 = $this->dataset->set_matrix($book_binding->book_binding_p1000, $book_binding_p1000);
				}
				if ($book_binding->book_binding_sq_rn) {
					$book_binding_running_price = $this->dataset->set_matrix($book_binding->book_binding_sq_rn, $book_binding_running_price);
				}
				if ($book_binding->production_time) {
					$production_time += $book_binding->production_time;
				}
			}
		}

		$refinement_setup_price	= 0;
		$refinement_p1000 = array();
		$refinement_running_price = array();
		$refinement_margin = 1;
		if ( isset($parameters['etapes_print_refinement']) ) {
			$refinement = $this->dataset->get_option_by_code('etapes_print_refinement', $parameters['etapes_print_refinement']);
			if ($refinement) {
				if ($refinement->refinement_setup_price) {
					$refinement_setup_price = $refinement->refinement_setup_price;
				}
				if ($refinement->refinement_p1000) {
					$refinement_p1000 = $this->dataset->set_matrix($refinement->refinement_p1000, $refinement_p1000);
				}
				if ($refinement->refinement_sq_rn) {
					$refinement_running_price = $this->dataset->set_matrix($refinement->refinement_sq_rn, $refinement_running_price);
				}
				if ($refinement->production_time) {
					$production_time += $refinement->production_time;
				}
				if ($refinement->margin &&  $refinement->margin >= 0) {
					$refinement_margin = $refinement->margin;
				}
			}
		}

		$finishing_setup_price	= 0;
		$finishing_p1000 = array();
		$finishing_running_price = array();
		if ( isset($parameters['etapes_print_finishing']) ) {
			$finishing = $this->dataset->get_option_by_code('etapes_print_finishing', $parameters['etapes_print_finishing']);
			if ($finishing) {
				if ($finishing->finishing_setup_price) {
					$finishing_setup_price = $finishing->finishing_setup_price;
				}
				if ($finishing->finishing_p1000) {
					$finishing_p1000 = $this->dataset->set_matrix($finishing->finishing_p1000, $finishing_p1000);
				}
				if ($finishing->finishing_sq_rn) {
					$finishing_running_price = $this->dataset->set_matrix($finishing->finishing_sq_rn, $finishing_running_price);
				}
			}
		}

		$modele_setup_price = 0;
		if ( isset($parameters['etapes_print_modele']) ) {
			$modele = $this->dataset->get_option_by_code('etapes_print_modele', $parameters['etapes_print_modele']);
			if ($modele) {
				if ($modele->modele_setup_price) {
					$modele_setup_price = $modele->modele_setup_price;
				}
			}
		}

		$proof_group_setup_price = 0;
		if ( isset($parameters['etapes_print_proof_group'])) {
			$proof_group = $this->dataset->get_option_by_code('etapes_print_proof_group', $parameters['etapes_print_proof_group']);
			if ($proof_group) {
				if ($proof_group->proof_group_setup_price) {
					$proof_group_setup_price = $proof_group->proof_group_setup_price;
				}
			}
		}

		$prices = array();
		$price_keys = array();
		
		if ( isset($parameters['etapes_print_quantity']) ) {
			$quantities = explode(',', $parameters['etapes_print_quantity']);
			foreach ($quantities as $value) {
				array_push($price_keys, $value);
			}
		} else {
			$quantities = explode(',', get_option('etapes_print_price_array'));
			foreach ($quantities as $value) {
				array_push($price_keys, $value);
			}
		}

		// DELIVERY PRICE
		$delivery_price = get_option('etapes_print_delivery_price');

		// DEBUGGER
		$debug_format = null;
		$debug_pages = null;
		$debug_paper = null;
		$debug_color = null;
		$debug_book_binding = null;
		$debug_refinement = null;
		$debug_finishing = null;

		$etapes_print_re = array();
		if ($debugger_on) {
			$etapes_print_re['price_debugger'] = array();
		}

		foreach ($price_keys as $quantity) {
			// COUVERTURE
			$debug_cover_format = $this->dataset->get_format_price($quantity, $cover_format_setup_price, $cover_format_p1000);
			$cover_format_price = $debug_cover_format["format_price"];

			$debug_cover_paper = $this->dataset->get_paper_price($quantity, $pages, $cover_paper_weight, $cover_paper_kg_price, $cover_height, $cover_width, $cover_paper_running_price, $cover_paper_margin);
			$cover_paper_price = $debug_cover_paper["paper_price"];

			// INTERIEUR
			$debug_format = $this->dataset->get_format_price($quantity, $format_setup_price, $format_p1000);
			$format_price = $debug_format["format_price"];

			$debug_pages = $this->dataset->get_pages_price($quantity, $pages, 0, $height, $width);
			$pages_price = $debug_pages["pages_price"];

			$debug_paper = $this->dataset->get_paper_price($quantity, $pages, $paper_weight, $paper_kg_price, $height, $width, $paper_running_price, $paper_margin);
			$paper_price = $debug_paper["paper_price"];

			$debug_color = $this->dataset->get_color_price($quantity, $pages, $colors_setup_price, $height, $width, $colors_p1000, $colors_running_price, null, $colors_margin);
			$color_price = $debug_color["color_price"];

			$debug_book_binding = $this->dataset->get_book_binding_price($quantity, $pages, $book_binding_setup_price, $height, $width, $book_binding_p1000, $book_binding_running_price);
			$book_binding_price = $debug_book_binding["book_binding_price"];

			$debug_refinement = $this->dataset->get_refinement_price($quantity, $pages, $refinement_setup_price, $height, $width, $refinement_p1000, $refinement_running_price, $refinement_margin);
			$refinement_price = $no_refinement ? 0 : $debug_refinement["refinement_price"];

			$debug_finishing = $this->dataset->get_finishing_price($quantity, $pages, $finishing_setup_price, $height, $width, $finishing_p1000, $finishing_running_price);
			$finishing_price = $debug_finishing["finishing_price"];


			$ht_price = $proof_group_setup_price  + ($cover_format_price + $cover_paper_price + $format_price + $pages_price + $paper_price + $color_price + $refinement_price + $finishing_price + $delivery_price + $book_binding_price) * ( 1 + $modele_setup_price );
			$prices[$quantity] = round($ht_price , 2);

			if ($debugger_on) {
				$etapes_print_re['price_debugger'][$quantity] = array();
				$etapes_print_re['price_debugger'][$quantity]['cover_format'] = $debug_cover_format;
				$etapes_print_re['price_debugger'][$quantity]['cover_paper'] = $debug_cover_paper;
				$etapes_print_re['price_debugger'][$quantity]['format'] = $debug_format;
				$etapes_print_re['price_debugger'][$quantity]['pages'] = $debug_pages;
				$etapes_print_re['price_debugger'][$quantity]['paperList'] = $debug_paper;
				$etapes_print_re['price_debugger'][$quantity]['color'] = $debug_color;
				$etapes_print_re['price_debugger'][$quantity]['book_binding'] = $debug_book_binding;
				$etapes_print_re['price_debugger'][$quantity]['refinement'] = $debug_refinement;
				$etapes_print_re['price_debugger'][$quantity]['finishing'] = $debug_finishing;
				$etapes_print_re['price_debugger'][$quantity]['proof_group'] = $proof_group_setup_price;
				$etapes_print_re['price_debugger'][$quantity]['modele_setup_price'] = $modele_setup_price;
				$etapes_print_re['price_debugger'][$quantity]['delivery_price'] = $delivery_price;
	
				$etapes_print_re['price_debugger'][$quantity]['ht_price'] = array(
					"formula" => '$proof_group_setup_price + ($format_price + $pages_price + $paper_price + $color_price + $refinement_price + $finishing_price + $delivery_price + $book_binding_price) * ( 1 + $modele_setup_price )',
					"explanation" => "$proof_group_setup_price + ($format_price + $pages_price + $paper_price + $color_price + $refinement_price + $finishing_price + $delivery_price + $book_binding_price) * ( 1 + $modele_setup_price )",
					"result" => $ht_price
				);
			}
		}
		$etapes_print_re['prices'] = $prices;
		$etapes_print_re['format']['width'] = $width;
		$etapes_print_re['format']['height'] = $height;

		// PRODUCTION CUSTOM DISPLAY
		$productions = $this->dataset::ETAPES_PRINT_PRODUCTIONS;
		$etapes_print_re['productions'] = $productions;
		$etapes_print_re['production_labels'] = $this->dataset->get_delivery_dates($production_time);
		
		return $etapes_print_re;
  }

	/**
	 * PRIVATE
	 */

	function gestionMarket( WP_REST_Request $request ) {

		$parameters = $request->get_params();

		global $wpdb;
		$table_name = $wpdb->prefix . 'etapes_print_gestion_market';
		$idMarket = $parameters['id'];

		$dataMarket = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = $idMarket", ARRAY_A );
		$resultJson =  json_encode($dataMarket);
		$data = json_decode($resultJson, true, JSON_UNESCAPED_SLASHES);

		$responseError = [
			'status' => 0,
			'status_message' =>'Identification non trouvé'
		];
		$responseSuccess = [
			'status' => 1,
			'status_message' =>'Affichage avec succes'
		];

		if($data[0] != null) : array_push($data[0], $responseSuccess ); endif;

		header('Content-Type: application/json');
		$getResults = (!empty($data)) ? $data : json_decode(json_encode($responseError), true, JSON_UNESCAPED_SLASHES);

		return $getResults;

	}

	/**
	 * Connexion Api
	 */
	function connectedPlugin( WP_REST_Request $request ){
		$parameters = $request->get_params();
		$argMarket = $parameters['arg'];
		global $wpdb;
		$table_name = $wpdb->prefix . 'etapes_print_gestion_market';
		$dataCheckItem = $wpdb->get_results("SELECT * FROM $table_name WHERE societe='$argMarket'" );
		if (count($dataCheckItem) === 0) :
			return $responseError = [
				'status' => 0,
				'status_message' =>'Non connecté ou non trouvé'
			];
		else :
			$table_name2 = $wpdb->prefix . 'etapes_print_status_plugin';
			$dataCheckStatus = $wpdb->get_results( "SELECT * FROM $table_name2", ARRAY_A );
			if($dataCheckStatus[0]['status_plugin'] == 'actif'){
				return $responseSuccess = [
					'status' => 'actif',
					'status_message' =>'Plugin connecté'
				];
			}
		endif;
	}	

	/**
	 * Get Api product list
	 */
	public function getproductApi(){
		$request = wp_remote_get('http://main-site.local/wp-json/etapes-print/v1/categoryProduct/list');
		if( is_wp_error( $request ) ) {
			return false;
		}
		$body = wp_remote_retrieve_body( $request );
		$dataJson = json_decode( $body );

		global $wpdb;
		$table_name = $wpdb->prefix . 'etapes_print_product_api_list';
		foreach ($dataJson as $key => $product) :
		 	$data = [
		 		'product_name' => $product->product_name,
				'category_name' => $product->category_name
		 	];
		 	$checkIfElementExist = $wpdb->get_results("SELECT id,product_name FROM $table_name WHERE product_name = '$product->product_name'");
		 	if(count($checkIfElementExist) == 0) :
		 		$wpdb->insert( $table_name, $data );
			endif;
		endforeach;
	}
 
	/**
	 * Panels general
	 */
	public function product_general_panel(){
		global $woocommerce, $post;

		$request = wp_remote_get('http://main-site.local/wp-json/etapes-print/v1/remiseRevendeur/Malagasy');
		if( is_wp_error( $request ) ) {
			return false;
		}
		$body = wp_remote_retrieve_body( $request );
		$dataJson = json_decode( $body );
		$arrayValue = [];
		foreach ($dataJson as $key => $product) :
			$toArray = (array) $product;
			array_push($arrayValue, $toArray);
		endforeach;
		$arrayFiltre = array_filter($arrayValue, function ($var) {
			return ($var['produit'] == 5);
		});
		$prixCustomPercent = '';
		$prixEtapeComprise = '';
		foreach ($arrayFiltre as $key => $value) {
			$prixCustomPercent = $value['prix_custom'];
			$prixEtapeComprise = $value['prix_etape'] * (1 - ($value['prix_custom'] / 100));
		}
	 	include( plugin_dir_path( __FILE__ ) . 'partials/panel/etapes-print-admin-product-panel-general.php' );
 	}


}
