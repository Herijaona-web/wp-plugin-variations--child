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


<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
  <h2>Etapes Print Options</h2>
  <form action="" method="post">
    <h2>Price debugger (IP whitelist)</h2>
    <input type="text" class="etapes_print_input price_debugger" name="price_debugger" value="<?php echo get_option('etapes_print_price_debugger') ?>"/>
    <br>

    <h2>Ajuster le frais d'envoi</h2>
    <input type="number" class="etapes_print_input delivery_price" name="delivery_price" value="<?php echo get_option('etapes_print_delivery_price') ?>"/> € HT
    <br>

    <h2>Nombre d'exemplaire à afficher</h2>
    <input type="text" class="etapes_print_input price_array" name="price_array" value="<?php echo get_option('etapes_print_price_array') ?>"/>
    <br>

    <h2>Quantité par défaut</h2>
    <input type="number" class="etapes_print_input default_quantity" name="default_quantity" value="<?php echo get_option('etapes_print_default_quantity') ?>"/> Ex.
    <br>

    <h2>Délai de production par défaut</h2>
    <input type="number" class="etapes_print_input delay_delivery" name="delay_delivery" value="<?php echo get_option('etapes_print_delay_delivery') ?>"/> Jour(s)
    <br>

    <h2>Sélectionner les options à afficher en liste d'images :</h2>
    <select id="etapes_print_select_multiple" name="customized_option[]" multiple="multiple">
      <?php foreach ($etape_print_options as $value) { ?>
        <option value="<?php echo $value ?>" <?php echo ( str_contains( $customised_options, $value ) ? 'selected="selected"' : '' ) ?>><?php echo $this->dataset->get_label_by_key($value) ?></option>
      <?php } ?>
    </select>
    <br>

    <h2>Afficher les sous-options sous forme de liste au-delà de :</h2>
    <input required type="number" class="etapes_print_input custom_display_limit" name="custom_display_limit" value="<?php echo get_option('etapes_print_custom_display_limit') ?>"/> éléments
    <br>

    <button class="button button-primary button-large" style="margin-top:3em;" type="submit" name="etapes_print_submit" value="ok">Enregistrer</button>
  </form>
</div>