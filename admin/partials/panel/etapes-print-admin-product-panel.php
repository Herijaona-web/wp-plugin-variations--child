<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       x
 * @since      4.0.0
 *
 * @package    Etapes_Print
 * @subpackage Etapes_Print/admin/partials
 */

  defined( 'ABSPATH' ) || exit;
?>
<div id="etapes_print_product_data" class="panel woocommerce_options_panel hidden">
	<div class="options_group">
	 	<?php
			 $cat_params = array(
				 'orderby'    => 'name',
				 'order'      => 'asc',
				 'hide_empty' => false,
			 );
			// $product_categories = get_terms( 'product_cat', $cat_params ); 
			// $categorys[''] = __( 'Selectionner un nom de categorie', 'woocommerce');;
			// foreach ($product_categories as $key => $category) {
			// 	$categorys[$category->name] =  $category->name;
			//  }
			 woocommerce_wp_select( array(
				 'id'          => 'etapes_print_category_product',
				 'name' => 'etapes_print_category_product',
				 'value'       => get_post_meta( get_the_ID(), 'etapes_print_cover_value', true ),
				 'label'       => 'Type de produit :'
			 ) );
			$products_change[''] = __( 'Selectionner un nom de produit', 'woocommerce');
			foreach ($this->dataset->get_products($_GET['c']) as $key => $value) {
				$products_change[] =  $value['product_name'];
			}
			woocommerce_wp_select( array(
				'id'          => 'etapes_print_category_product2',
				'value'       => get_post_meta( get_the_ID(), 'etapes_print_cover_value', true ),
				'label'       => 'Nom de produit :',
				'options'     => $products_change,
			) );
		?>
	</div>
	 <?php
		foreach ( $options as $option ) {
			if (array_key_exists($option, $custom_options)) {
				if (in_array($option, $options_table)) {
					$etape_print_data = $this->dataset->get_option_table_values($option);
				} else {
					$etape_print_data = array();
					foreach ($custom_options[$option] as $key) {
						$etape_print_data[$key] = $this->dataset->get_label_by_key($key);
					}
				}
				asort($etape_print_data);
				$data = get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_values', true ); ?>
				<div class="options_group">
					<?php woocommerce_wp_checkbox( array(
						'id'          => 'etapes_print_' . $option,
						'value'       => get_post_meta( get_the_ID(), 'etapes_print_' . $option, true ),
						'label'       => $this->dataset->get_label_by_key($option),
						'desc_tip'    => true,
						'description' => 'Afficher cette option',
					) ); ?>

					<p class="form-field <?php echo 'etapes_print_' . $option .'_values' ?> ">
						<label for="etapes_print_select_multiple">Sélectionner : </label>
						<select id="etapes_print_select_multiple" name="<?php echo 'etapes_print_' . $option . '_values[]' ?>" multiple="multiple">
							<?php foreach ($etape_print_data as $key => $value) { ?>
								<option value="<?php echo $key ?>" <?php echo ( in_array( $key, $data ? $data : array() ) ? 'selected="selected"' : '' ) ?>><?php echo esc_html($value) ?></option>
							<?php } ?>
						</select>
					</p>

					<?php woocommerce_wp_select( array(
						'id'          => 'etapes_print_' . $option . '_default_value',
						'value'       => get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_default_value', true ),
						'label'       => 'Valeur par défaut',
						'options'     => $etape_print_data,
					) ); ?>
				</div>
		<?php } else { ?>
			<div class="options_group">
			<?php
			if ($option === 'cover') {
				$coverList = get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_values', true );
				woocommerce_wp_checkbox( array(
					'id'          => 'etapes_print_' . $option,
					'value'       => get_post_meta( get_the_ID(), 'etapes_print_' . $option, true ),
					'label'       => 'Couverture',
					'desc_tip'    => true,
					'description' => 'Activer cet option pour séparer la couverture et l\'intérieur',
				) );
				woocommerce_wp_select( array(
					'id'          => 'etapes_print_cover_value',
					'value'       => get_post_meta( get_the_ID(), 'etapes_print_cover_value', true ),
					'label'       => 'Sélectionner :',
					'options'     => $covers,
				) ); ?>
			<a style="margin-left: 160px;line-height: 24px;" href="<?php echo admin_url('admin.php?page=etapes-print-cover'); ?>" target='_blank'>Gérer les couvertures</a>
			<?php } else if ($option === 'select_rules') {
				$selectRulesList = get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_values', true ); ?>
				<?php woocommerce_wp_checkbox( array(
					'id'          => 'etapes_print_' . $option,
					'value'       => get_post_meta( get_the_ID(), 'etapes_print_' . $option, true ),
					'label'       => 'Appliquer les règles',
					'desc_tip'    => true,
					'description' => 'Activer cet option',
				) ); ?>

				<p class="form-field <?php echo 'etapes_print_display' ?> ">
					<label for="etapes_print_select_multiple">Sélectionner les règles : </label>
					<select id="etapes_print_select_multiple" name="<?php echo 'etapes_print_' . $option . '_values[]' ?>" multiple="multiple">
					<?php foreach ($selectRules as $value) { ?>
						<option value="<?php echo $value['code'] ?>" <?php echo ( in_array( $value['code'], $selectRulesList ? $selectRulesList : [] ) ? 'selected="selected"' : '' ) ?>><?php echo esc_html($value['code']) ?></option>
					<?php } ?>
					</select>
				</p>

				<?php
			} else if ($option === 'display') {
				$etape_print_options = $this->dataset::ETAPES_PRINT_CUSTOM_SELECT;
				$data = get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_values', true ); ?>
				<?php woocommerce_wp_checkbox( array(
					'id'          => 'etapes_print_' . $option,
					'value'       => get_post_meta( get_the_ID(), 'etapes_print_' . $option, true ),
					'label'       => 'Customiser l\'affichage',
					'desc_tip'    => true,
					'description' => 'Activer cet option',
				) ); ?>

				<p class="form-field <?php echo 'etapes_print_display' ?> ">
					<label for="etapes_print_select_multiple">Afficher en image : </label>
					<select id="etapes_print_select_multiple" name="<?php echo 'etapes_print_' . $option . '_values[]' ?>" multiple="multiple">
						<?php foreach ($etape_print_options as $value) { ?>
							<option value="<?php echo $value ?>" <?php echo ( in_array( $value, $data ? $data : array() ) ? 'selected="selected"' : '' ) ?>><?php echo $this->dataset->get_label_by_key($value) ?></option>
						<?php } ?>
					</select>
				</p>

				<?php
			} else if ($option === 'file_type') {
				woocommerce_wp_checkbox( array(
					'id'          => 'etapes_print_' . $option,
					'value'       => get_post_meta( get_the_ID(), 'etapes_print_' . $option, true ),
					'label'       => 'Fichier fourni',
					'desc_tip'    => true,
					'description' => 'Activer cet option',
				) );
			} else if ($option === 'production') {
				$production_delay = get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_delay', true );
				if (!$production_delay) {
					$production_delay = get_option('etapes_print_delay_delivery');
				}
				woocommerce_wp_text_input(
					array( 
						'id'          => 'etapes_print_' . $option . '_delay', 
						'label'       => 'Délai de production',
						'desc_tip'    => 'true',
						'description' => __( 'Par défaut : ' . get_option('etapes_print_delay_delivery') . ' jour(s)', 'etapes-print' ),
						'value'       => $production_delay,
						'custom_attributes' => array(
							'min'	=> '0'
						) 
					)
				);
			} else if ($option === 'quantity') {
				woocommerce_wp_checkbox( array(
					'id'          => 'etapes_print_' . $option,
					'value'       => get_post_meta( get_the_ID(), 'etapes_print_' . $option, true ),
					'label'       => $this->dataset->get_label_by_key($option),
					'desc_tip'    => true,
					'description' => 'Activer cette option',
				) );
				$product_price_array = get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_price_array', true );
				if (!$product_price_array) {
					$product_price_array = get_option('etapes_print_price_array');
				}
				woocommerce_wp_text_input(
					array( 
						'id'          => 'etapes_print_' . $option . '_price_array', 
						'label'       => 'Nombre d\'exemplaire à afficher',
						'desc_tip'    => 'true',
						'description' => __( 'Par défaut : ' . get_option('etapes_print_price_array'), 'etapes-print' ),
						'value'       => $product_price_array,
						'custom_attributes' => array(
							'pattern' => '[0-9]+(,[0-9]+)*'
						)
					)
				);

				$product_default_quantity = get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_default_quantity', true );
				if (!$product_default_quantity) {
					$product_default_quantity = get_option('etapes_print_default_quantity');
				}
				woocommerce_wp_text_input(
					array( 
						'id'          => 'etapes_print_' . $option . '_default_quantity', 
						'label'       => 'Quantité par défaut',
						'desc_tip'    => 'true',
						'description' => __( 'Par défaut : ' . get_option('etapes_print_default_quantity'), 'etapes-print' ),
						'value'       => $product_default_quantity,
						'custom_attributes' => array(
							'min'	=> '0'
						) 
					)
				);

				woocommerce_wp_text_input(
					array( 
						'id'          => 'etapes_print_' . $option . '_min', 
						'label'       => 'Valeur minimum',
						'desc_tip'    => 'true',
						'description' => __( 'Entrer la quantité minimale autorisée', 'etapes-print' ),
						'value'       => get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_min', true ),
						'custom_attributes' => array(
							'min'	=> '0'
						) 
					)
				);

				woocommerce_wp_text_input(
					array( 
						'id'          => 'etapes_print_' . $option . '_max', 
						'label'       => 'Valeur maximum',
						'desc_tip'    => 'true',
						'description' => __( 'Entrer la quantité maximale autorisée', 'etapes-print' ),
						'value'       => get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_max', true ),
						'custom_attributes' => array(
							'step' 	=> '50',
							'min'	=> '0'
						) 
					)
				);
			} else if ($option === 'custom_format') {
				woocommerce_wp_checkbox( array(
					'id'          => 'etapes_print_' . $option,
					'value'       => get_post_meta( get_the_ID(), 'etapes_print_' . $option, true ),
					'label'       => $this->dataset->get_label_by_key($option),
					'desc_tip'    => true,
					'description' => 'Activer cette option',
				) );
				woocommerce_wp_text_input(
					array( 
						'id'          => 'etapes_print_' . $option . '_width', 
						'label'       => 'Largeur en cm (min:max)',
						'desc_tip'    => 'true',
						'description' => __( 'Entrer la largeur minimale et maximum autorisée (séparée par un deux points). Exemple : 100:200', 'etapes-print' ),
						'value'       => get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_width', true ),
						'custom_attributes' => array(
							'pattern' => '[0-9]+:[0-9]+'
						) 
					)
				);
				woocommerce_wp_text_input(
					array( 
						'id'          => 'etapes_print_' . $option . '_height', 
						'label'       => 'Hauteur en cm (min:max)',
						'desc_tip'    => 'true',
						'description' => __( 'Entrer la hauteur minimale et maximum autorisée (séparée par une virgule, exemple : 100:200)', 'etapes-print' ),
						'value'       => get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_height', true ),
						'custom_attributes' => array(
							'pattern' => '[0-9]+:[0-9]+'
						) 
					)
				);
			} ?>
			</div>
		<?php } } ?>
</div>