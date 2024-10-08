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
<tr>
  <th class="title_section">
    <label for="etapes_print_<?php echo $option ?>">Couverture</label>
  </th>
</tr>
<?php
foreach (['format', 'paper'] as $option) {
  $etape_print_values = $cover[$option];

  $etape_print_default_value = $etapes_print_cover["default_$option"];
  $etape_print_has_custom_data = str_contains($custom_options, $option);
  $etapes_print_labels_option = $this->dataset->get_results_by_options($option, $etape_print_values);
  $etapes_print_single_option = count($etape_print_values) === 1;
  $custom_display_limit = get_option('etapes_print_custom_display_limit');
  if (null === $custom_display_limit || $custom_display_limit === '') {
    $custom_display_limit = 5;
  }
  $etapes_print_multiple_options = count($etape_print_values) > $custom_display_limit;
?>
  <tr data-etapes-print="<?php echo htmlspecialchars(json_encode($etapes_print_labels_option), ENT_QUOTES, 'UTF-8'); ?>"  <?php echo $option === 'paper' ? 'v-show="variations.etapes_print_cover_format !== \'format_sans_couv\'"' : '' ; ?>>
    <th class="label">
      <label for="etapes_print_cover_<?php echo $option ?>"><?php echo $this->dataset->get_label_by_key($option) ?> de la couverture : </label>
    </th>
    <td class="value">
      <select class="etapes_print_select" name="etapes_print_cover_<?php echo $option ?>" v-model="variations.etapes_print_cover_<?php echo $option ?>" <?php echo ($etape_print_has_custom_data && ($force_display || !$etapes_print_multiple_options)) ? 'style="display: none;"' : '' ; ?> v-on:change="getPrices()">
        <?php foreach ($etape_print_values  as $val) { ?>
          <option value="<?php echo $val ?>" <?php echo ( ( $etape_print_default_value == $val ) ? 'selected="selected"' : '' ) ?> :active="variations.etapes_print_cover_<?php echo $option ?> === '<?php echo $val ?>'"><?php echo esc_html($this->dataset->get_label_by_key($val, $etapes_print_labels_option)) ?></option>
        <?php } ?>
      </select>
      <?php if($etape_print_has_custom_data && ($force_display || !$etapes_print_multiple_options)) { ?>
        <div id="etapes_print_cover_<?php echo $option ?>_custom_field" class="etapes_print_custom_field etapes_print_cover_<?php echo $option ?>_custom_field">
          <?php foreach ($etape_print_values as $val) { ?>
            <div id="etapes_print_cover_<?php echo $option ?>_custom_option_<?php echo $val ?>" class="etapes_print_custom_field_option etapes_print_cover_<?php echo $option ?>_custom_field_option img-select <?php echo ( $etape_print_default_value == $val ) ? 'active' : ''; ?>" v-on:click="selectValue('cover_<?php echo $option ?>', '<?php echo $val ?>')" data-key="cover_<?php echo $option ?>" data-value="<?php echo $val ?>">
              <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/' . trim($val) . '.svg'; ?>" alt="<?php echo trim($val) . '.svg'; ?>"
                onerror="this.src=`<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/old/' . $val . '.png'; ?>`;this.onerror='';">
              <p><?php echo $this->dataset->get_label_by_key($val, $etapes_print_labels_option) ?></p>
            </div>
          <?php } ?>
      </div>
    </td>
  </tr>
<?php } } ?>