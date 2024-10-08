<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       x
 * @since      4.0.0
 *
 * @package    Etapes_Print
 * @subpackage Etapes_Print/public/partials
 */
?>
<div id="etapes_print_product_customization" class="etapes_print_wrapper" v-cloak>
  <div id="etapes_print_product_variation_panel">
    <table ref="table" class="etapes_print_variations" cellspacing="0">
      <tbody>
        <?php
        $force_display = false;
        if (get_post_meta( get_the_ID(), 'etapes_print_display', true ) &&
          get_post_meta( get_the_ID(), 'etapes_print_display_values', true )) {
            $product_display = get_post_meta( get_the_ID(), 'etapes_print_display_values', true );
            $custom_options = implode('', $product_display);
            $force_display = true;
        }

        if ($etapes_print_cover) {
          include( plugin_dir_path( __FILE__ ) . 'cover/etapes-print-public-cover-display.php' );
        }

        foreach ($options as $option) { 
          if(get_post_meta( get_the_ID(), 'etapes_print_' . $option, true ) &&
            get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_values', true ) &&
            get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_default_value', true )) {

              $etape_print_values = get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_values', true );
              if (!$etape_print_values) {
                $etape_print_values = array();
              }

              // customized option (format implemented for now)
              $custom_option = get_post_meta( get_the_ID(), 'etapes_print_custom_' . $option, true );
              if ($custom_option) {
                array_push($etape_print_values, 'custom_' . $option);
              }

              $etape_print_default_value = get_post_meta( get_the_ID(), 'etapes_print_' . $option . '_default_value', true );
              // $etape_print_has_custom_data = $this->dataset->is_custom_select($option);
              $etape_print_has_custom_data = str_contains($custom_options, $option);
              $etapes_print_labels_option = $this->dataset->get_results_by_options($option, $etape_print_values);
              $etapes_print_single_option = count($etape_print_values) === 1;
              $custom_display_limit = get_option('etapes_print_custom_display_limit');
              if (null === $custom_display_limit || $custom_display_limit === '') {
                $custom_display_limit = 5;
              }
              $etapes_print_multiple_options = count($etape_print_values) > $custom_display_limit;
            ?>
            <tr data-etapes-print="<?php echo htmlspecialchars(json_encode($etapes_print_labels_option), ENT_QUOTES, 'UTF-8'); ?>"  <?php echo $etapes_print_single_option ? 'style="display: none;"' : '' ; ?> <?php echo $etapes_print_cover && $option === 'refinement' ? 'v-if="variations.etapes_print_cover_format !== \'format_sans_couv\'"' : '' ; ?>>
              <th class="label">
                <label for="etapes_print_<?php echo $option ?>"><?php echo $this->dataset->get_label_by_key($option) ?> : </label>
              </th>
              <td class="value">
                <select class="etapes_print_select" name="etapes_print_<?php echo $option ?>" v-model="variations.etapes_print_<?php echo $option ?>" <?php echo ($etape_print_has_custom_data && ($force_display || !$etapes_print_multiple_options)) ? 'style="display: none;"' : '' ; ?> v-on:change="getPrices()">
                  <?php foreach ($etape_print_values  as $val) { ?>
                    <option value="<?php echo $val ?>" <?php echo ( ( $etape_print_default_value == $val ) ? 'selected="selected"' : '' ) ?> :active="variations.etapes_print_<?php echo $option ?> === '<?php echo $val ?>'"><?php echo esc_html($this->dataset->get_label_by_key($val, $etapes_print_labels_option)) ?></option>
                  <?php } ?>
                </select>
                <?php if($etape_print_has_custom_data && ($force_display || !$etapes_print_multiple_options)) { 
                  /*  onerror="this.src=`<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/' . $val . '.png'; ?>`;this.onerror='';" */
                  ?>
                  <div id="etapes_print_<?php echo $option ?>_custom_field" class="etapes_print_custom_field etapes_print_<?php echo $option ?>_custom_field">
                    <?php foreach ($etape_print_values as $val) { ?>
                      <div id="etapes_print_<?php echo $option ?>_custom_option_<?php echo $val ?>" class="etapes_print_custom_field_option etapes_print_<?php echo $option ?>_custom_field_option img-select <?php echo ( $etape_print_default_value == $val ) ? 'active' : ''; ?>" v-on:click="selectValue('<?php echo $option ?>', '<?php echo $val ?>')" data-key="<?php echo $option ?>" data-value="<?php echo $val ?>">
                        <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/' . trim($val) . '.svg'; ?>" alt="<?php echo trim($val) . '.svg'; ?>"
                          onerror="this.src=`<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/old/' . $val . '.png'; ?>`;this.onerror='';">
                        <p><?php echo $this->dataset->get_label_by_key($val, $etapes_print_labels_option) ?></p>
                      </div>
                    <?php } ?>
                </div>
              </td>
            </tr>
            <?php } if ($custom_option) { ?>
              <tr v-if="variations['etapes_print_format'] === 'custom_format'">
                <th class="custom_label"><label for="custom_width">Largeur (cm) :</label></th>
                <td class="value"><input id="custom_width" type="number" name="etapes_print_custom_format_width" v-model="customFormat.width" :min="customFormat.rules.width[0]" :max="customFormat.rules.height[1]" step="0.1" v-on:blur="updateCustomFormatLabel()"/></td>
              </tr>
              <tr v-if="variations['etapes_print_format'] === 'custom_format'">
                <th class="custom_label"><label for="custom_height">Hauteur (cm) :</label></th>
                <td class="value"><input id="custom_height" type="number" name="etapes_print_custom_format_height"  v-model="customFormat.height" :min="customFormat.rules.height[0]" :max="customFormat.rules.height[1]" step="0.1" v-on:blur="updateCustomFormatLabel()"/></td>
              </tr>
            <?php } 
            
            if ($etapes_print_cover && $option === 'refinement') {
              echo '<tr>
                      <th class="title_section">
                        <label for="etapes_print_<?php echo $option ?>">Intérieur</label>
                      </th>
                    </tr>';
            } ?>
            
          <?php } } ?>
      </tbody>
    </table>
    <?php if(get_post_meta( get_the_ID(), 'etapes_print_quantity', true )) { ?>
    <div class="fusion-separator fusion-full-width-sep" style="align-self: center;margin-left: auto;margin-right: auto;margin-top:48px;margin-bottom:12px;width:100%;"><div class="fusion-separator-border sep-single sep-solid" style="border-color:hsla(var(--awb-color8-h),var(--awb-color8-s),var(--awb-color8-l),calc( var(--awb-color8-a) - 70% ));border-top-width:1px;"></div></div>  <input type="number" name="etapes_print_quantity" v-model="quantity" style="display: none;"/>
    <input type="text" name="etapes_print_production" v-model="production" style="display: none;"/>
    <div class="etapes_print_vat_switch">
      <span class="etapes_print_vat_switch_label">HT </span>
      <input id="etapes_print_vat_switch" type="checkbox" v-model="vat" hidden="hidden" style="display: none;">
      <label class="switch" for="etapes_print_vat_switch"></label>
      <span class="etapes_print_vat_switch_label"> TTC</span>
    </div>
    <div class="etape_print_price_grid">
      <div class="etape_print_price_grid_quantity">
        <div class="etapes_print_grid_quantity_item etapes_print_grid_quantity_header">
          <?php echo __('Quantité', 'etapes_print') ?>
        </div>
        <div class="etapes_print_grid_quantity_item" v-for="key in priceKeys" v-bind:class="{ active: +key === quantity }" v-on:click="selectQuantity(key)">
          {{ key }}
        </div>
        <div class="etapes_print_grid_quantity_item">
          <input class="etapes_print_quantity_input" :class="{ invalid: quantityError }" v-model="customQuantity" type="number" v-on:keydown.enter="fetchPrice($event)" />
        </div>
      </div>
      <div class="etape_print_price_grid_devilery_price">
        <div class="etapes_print_grid_devilery_price_row etapes_print_grid_devilery_price_header">
          <div v-if="productions" class="etapes_print_grid_delivery_price_item" v-for="prod in Object.keys(productions)" v-bind:class="{ active: prod === production }"  v-on:click="selectProduction(prod)">
            {{ productionLabels[prod] }}
          </div>
        </div>
        <div class="etapes_print_grid_devilery_price_row" v-for="key in priceKeys">
          <div v-if="productions" class="etapes_print_grid_delivery_price_item" v-for="prod in Object.keys(productions)" v-bind:class="{ active: +key === quantity && prod === production }"  v-on:click="selectQuantityProduction(key, prod)">
            {{ printPrice(prices[key], productions[prod].production_price) }} €
          </div>
        </div>
          <span class="etapes_print_quantity_input_label">
            <button class="etapes_print_button" type="button" v-on:click="fetchPrice($event)" :disabled="loading">+ Ajouter une quantité personnalisée</button>
          </span>
          <span class="color_red etapes_print_button_label" >* <?php //echo __('Ajouter une quantité personnalisée', 'etapes-print'); ?></span>
          <span class="color_red" v-if="filtered"> &nbsp;(entre {{ min }} et {{ max }} Ex.) </span>
      </div>
    </div>
    <?php } ?>
    <?php if(get_post_meta( get_the_ID(), 'etapes_print_file_type', true )) { ?>
      <div class="fusion-separator fusion-full-width-sep" style="align-self: center;margin-left: auto;margin-right: auto;margin-top:48px;margin-bottom:12px;width:100%;"><div class="fusion-separator-border sep-single sep-solid" style="border-color:hsla(var(--awb-color8-h),var(--awb-color8-s),var(--awb-color8-l),calc( var(--awb-color8-a) - 70% ));border-top-width:1px;"></div></div>    <div id="file_upload_container">
        <div class="etapes_print_upload_title"><?php echo __('Téléchargez votre fichier', 'etapes_print'); ?></div>
        <div v-if="!file">
          <span class="etapes_print_upload_info">
            Veuillez envoyer un seul document PDF page à page (recto/verso et multi-modèles compris)
          </span>
          
          <div class="etapes_print_upload_drop"
              v-on:drop="dropHandler"
              v-on:dragleave="dragOutHandler"
              v-on:dragenter="dragInHandler"
              v-on:click="open()">
              
            <img class="default" src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/upload/pdf-outline.png'; ?>" alt="pdf">
            <img class="outline" src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/upload/pdf-active.png'; ?>" alt="pdf">
            <img class="error" src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/upload/pdf-error.png'; ?>" alt="pdf">
            <label for="etapes_print_file">{{dropZoneLabel}}</label>
            <input v-on:change="uploadFromEvent" style="display: none;" type="file" name="etapes_print_file" id="etapes_print_file" accept="application/pdf" class="etapes_print_file" required/>
          </div>
        </div>
        <div v-else class="etapes_print_upload_preview">
          <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/upload/pdf.png'; ?>" alt="pdf">
          <span>{{file.name}}</span>
          <button type="button" class="visualize" v-on:click="visualizeFile">Visualiser</button>
          <button type="button" class="delete" v-on:click="deleteFile">Supprimer</button>
        </div>
        <div class="etapes-print-modal" id="etapes-print-modal-one">
          <div class="etapes-print-modal-bg etapes-print-modal-exit"></div>
          <div v-if="file" class="etapes-print-modal-container">
            <div class="etapes-print-wrapper">
              <canvas id="visualizer_canvas"></canvas>
              <div class="page_selector">
                <div class="side" v-on:click="sideTo(1)"  :class="{ active: currentPage === 1 }">Recto</div>
                <div  v-if="pages > 1"class="side" v-on:click="sideTo(2)"  :class="{ active: currentPage === 2 }">Verso</div>
              </div>
            </div>
            <button v-on:click="closeVisualizer" type="button" class="etapes-print-modal-close etapes-print-modal-exit">X</button>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
  <div id="etapes_print_product_variation_recap">
    <div ref="recap" class="recap-container">
      <div class="order-recap">
        <div class="head">Récapitulatif de votre commande</div>
        <div class="order-recap-item" v-for="option in recapOptions" <?php echo $etapes_print_cover ? 'v-show="(option.key !== \'etapes_print_cover_paper\' && option.key !== \'etapes_print_refinement\') || variations.etapes_print_cover_format !== \'format_sans_couv\'"' : '' ; ?>>
          <div class="title">{{ option.title }}</div>
          <div class="value">{{ option.values[variations[option.key]].replace('Couverture ', '') }}</div>
        </div>
        <div class="order-recap-item" v-if="quantity">
          <div class="title">Exemplaires</div>
          <div class="value">{{ quantity }}</div>
        </div>
        <div class="order-recap-item">
          <div class="title">Date de livraison</div>
          <div class="value" v-if="productionLabels">{{ productionLabels[production] }}</div>
        </div>
        <div class="order-recap-item" v-if="prices">
          <div class="title">Prix</div>
          <div class="value">{{ formatPrice(prices[quantity]) }}</div>
        </div>
        <div class="order-recap-item" v-if="prices">
          <div class="title">TVA</div>
          <div class="value">{{ formatPrice(prices[quantity] * 0.2) }}</div>
        </div>
        <hr style="border-color: #978367; margin: 3px 0">
        <div class="order-recap-item total" v-if="prices">
          <div class="title">TOTAL TTC</div>
          <div class="value">{{ formatPrice(prices[quantity] * 1.2) }}</div>
        </div>
        <?php
          $id = get_the_ID();
          echo '<button type="submit" name="add-to-cart" value="' . $id . '" class="single_add_to_cart_button">Ajouter au panier</button>'
        ?>
      </div>
      <div class="product-recap"></div>
    </div>
  </div>
</div>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->