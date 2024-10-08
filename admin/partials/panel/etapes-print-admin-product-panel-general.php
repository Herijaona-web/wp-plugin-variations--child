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
<div id="product_custom_field_general">
    <div class="is_file">
        <label class="_remise_revendeur_comprise" for="_remise_revendeur_comprise" style="">Remise revendeur comprise : <?php echo $prixCustomPercent; ?>%</label>
        <?php
            woocommerce_wp_text_input(
                array(
                    'id' => '_prix_achat_ht',
                    'placeholder' => "",
                    'label' => __("Prix d'achat HT (€)", 'woocommerce'),
                    'type' => 'number',
                    'desc_tip' => 'true',
                    'value'       =>  $prixEtapeComprise,
                    'disabled' => true
                )
            );
        ?>
    </div>
    <div class="is_file div_beneficiaire">
        <?php
            woocommerce_wp_text_input(
                array(
                    'id' => '_marge_beneficiaire',
                    'placeholder' => "",
                    'label' => __("Marge bénéficiaire", 'woocommerce'),
                    'type' => 'number',
                    'desc_tip' => 'true',
                    'value' => get_post_meta( get_the_ID(), '_marge_beneficiaire', true ),
                )
            );
        ?>
        <div class="btn_beneficiaire">
            <a class="button button-primary button-primary-e tab">€</a>
            <a class="button tab">%</a>
        </div>
    </div>
</div>