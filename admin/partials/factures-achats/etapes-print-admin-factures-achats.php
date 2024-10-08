<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       x
 * @since      4.0.0
 *
 * @package    Etapes_Print_Client
 * @subpackage Etapes_Print/admin/partials
 */

  defined( 'ABSPATH' ) || exit;
?>

<!-- Market management display -->
<div class="wrap">

  <h3>MES ACHATS</h3>

  <?php
$orders = wc_get_orders( array('numberposts' => -1) );

// echo '<pre>';
// print_r($orders);
// echo '</pre>';


// foreach( $orders as $order ){
//     echo $order->get_id() . '<br>'; 
//     echo $order->get_date_completed() . '<br>'; 
// }
  ?>
  <div class="d-flex-column notification_facture">
    <div class="column_one">
        <div class="div_col"> <span class="ic"></span>
        €</div></div>
    <div class="column_two">
        <h4>VOTRE FACTURATION ÉVOLUE.</h4>
        <p>
            Pour chacune de vos commandes vous pourrez 
            désormais éditer à la demande une facture comportant tous les 
            délais nécessaires pour votre gestion. Un relevé mensuel restera disponible en début de mois.
            <span>Plus d'infos ici.</span>
        </p>
    </div>
  </div>

  <?php $my_table_list->display(); ?> 
</div>