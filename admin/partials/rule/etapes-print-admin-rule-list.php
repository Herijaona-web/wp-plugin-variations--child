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
  <h2><?php echo $my_table_name; ?></h2>
  <a href="<?php echo admin_url( "admin.php?page=$page&action=add" ); ?>" class="button button-primary">Ajouter une ligne</a>
  <?php $my_table_list->display(); ?> 
</div>