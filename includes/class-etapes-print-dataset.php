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
 * Fired during plugin activation. https://regex101.com/r/TvKR9I/1
 *
 * This class defines all code necessary to run during the plugin"s activation.
 *
 * @since      4.0.0
 * @package    Etapes_Print
 * @subpackage Etapes_Print/includes
 * @author     Njakasoa Rasolohery <ras.njaka@gmail.com>
 */
class Etapes_Print_Dataset {

	const ETAPES_PRINT_LABELS = array(
    "paper" => "Papier",
    "format" => "Format",
    "pages" => "Nombre de pages",
    "colors" => "Impression",
    "book_binding" => "Reliure et Pli",
    "refinement" => "Pelliculage",
    "finishing" => "Finition",
    "options" => "Options",
    "file_type" => "Fichier fourni",
    "production" => "Production",
    "quantity" => "Quantité",
    "proof_group" => "Vérification",
    "modele" => "Nombre de modèle",
    "theme" => "Thème",

    // PAGE ADMIN
    "etapes-print-deny-rule" => "Deny Rules",
    "etapes-print-select-rule" => "Select Rules",
    "etapes-print-cover" => "Couverture",

    // CUSTOM
    "custom_format" => "Format personnalisée",
    
    // START PAGE

    "page_1" => "1 page",
    "page_2" => "2 pages",
    "page_4" => "4 pages",
    "page_6" => "6 pages",
    "pages_8" => "8 pages",
    "pages_10" => "10 pages",
    "pages_12" => "12 pages",
    "pages_16" => "16 pages",
    "pages_20" => "20 pages",
    "pages_24" => "24 pages",
    "pages_28" => "28 pages",
    "pages_32" => "32 pages",
    "pages_36" => "36 pages",
    "pages_40" => "40 pages",
    "pages_44" => "44 pages",
    "pages_48" => "48 pages",
    "pages_52" => "52 pages",
    "pages_56" => "56 pages",
    "pages_60" => "60 pages",
    "pages_64" => "64 pages",
    "pages_68" => "68 pages",
    "pages_72" => "72 pages",
    "pages_76" => "76 pages",
    "pages_80" => "80 pages",
    "pages_84" => "84 pages",
    "pages_88" => "88 pages",
    "pages_92" => "92 pages",
    "pages_96" => "96 pages",
    "pages_100" => "100 pages",
    "pages_104" => "104 pages",
    "pages_108" => "108 pages",
    "pages_112" => "112 pages",
    "pages_116" => "116 pages",
    "pages_120" => "120 pages",
    "pages_124" => "124 pages",
    "pages_128" => "128 pages",
    "pages_132" => "132 pages",
    "pages_136" => "136 pages",
    "pages_140" => "140 pages",
    "pages_144" => "144 pages",
    "pages_148" => "148 pages",
    "pages_152" => "152 pages",
    "pages_156" => "156 pages",
    "pages_160" => "160 pages",
    "pages_164" => "164 pages",
    "pages_168" => "168 pages",
    "pages_172" => "172 pages",
    "pages_176" => "176 pages",
    "pages_180" => "180 pages",
    "pages_184" => "184 pages",
    "pages_188" => "188 pages",
    "pages_192" => "192 pages",
    "pages_196" => "196 pages",
    "pages_200" => "200 pages",
    "pages_204" => "204 pages",
    "pages_208" => "208 pages",
    "pages_212" => "212 pages",
    "pages_216" => "216 pages",
    "pages_220" => "220 pages",
    "pages_224" => "224 pages",
    "pages_228" => "228 pages",
    "pages_232" => "232 pages",
    "pages_236" => "236 pages",
    "pages_240" => "240 pages",
    "pages_244" => "244 pages",
    "pages_248" => "248 pages",
    "page_3" => "3 pages",
    "page_5" => "5 pages",
    "page_7" => "7 pages",
    "page_9" => "9 pages",
    "page_14" => "14 pages",
    "page_18" => "18 pages",
    "pages_13" => "13 pages",
    "pages_24_carnet" => "24 pages",
    "pages_48_carnet" => "48 pages",
    "page_264" => "264 pages",

    // END PAGE

    // START THEME

    "rouge_japan" => "Rouge Japan",
    "blue_navy" => "Blue Navy",
    "vert_aquarelle" => "Vert Aquarelle",
    "vert_jungle" => "Vert Jungle",
    "beige_palmier" => "Beige Palmier",

    // END THEME

    // START PRODUCTION

    "production_standard" => "Standard",
    "production_express" => "Express",
    "production_overnight" => "Rush",

    // END PRODUCTION

    // OTHER
    "weight" => "Poids",
    "width" => "Largeur",
    "height" => "Hauteur",
  );

  const ETAPES_PRINT_OPTION_VALUES = array(
    "format" => null,
    "pages" => array(
      "page_1",
      "page_2",
      "page_4",
      "page_6",
      "pages_8",
      "pages_10",
      "pages_12",
      "pages_16",
      "pages_20",
      "pages_24",
      "pages_28",
      "pages_32",
      "pages_36",
      "pages_40",
      "pages_44",
      "pages_48",
      "pages_52",
      "pages_56",
      "pages_60",
      "pages_64",
      "pages_68",
      "pages_72",
      "pages_76",
      "pages_80",
      "pages_84",
      "pages_88",
      "pages_92",
      "pages_96",
      "pages_100",
      "pages_104",
      "pages_108",
      "pages_112",
      "pages_116",
      "pages_120",
      "pages_124",
      "pages_128",
      "pages_132",
      "pages_136",
      "pages_140",
      "pages_144",
      "pages_148",
      "pages_152",
      "pages_156",
      "pages_160",
      "pages_164",
      "pages_168",
      "pages_172",
      "pages_176",
      "pages_180",
      "pages_184",
      "pages_188",
      "pages_192",
      "pages_196",
      "pages_200",
      "pages_204",
      "pages_208",
      "pages_212",
      "pages_216",
      "pages_220",
      "pages_224",
      "pages_228",
      "pages_232",
      "pages_236",
      "pages_240",
      "pages_244",
      "pages_248",
      "page_3",
      "page_5",
      "page_7",
      "page_9",
      "page_14",
      "page_18",
      "pages_13",
      "pages_24_carnet",
      "pages_48_carnet",
      "page_264",
    ),
    "colors" => null,
    "finishing" => null,
    "paper" => null,
    "book_binding" => null,
    "refinement" => null,
    "modele" => null,
    "theme" => array(
      "rouge_japan",
      "blue_navy",
      "vert_aquarelle",
      "vert_jungle",
      "beige_palmier",
    ),
    "proof_group" => null,
    /*
    "production" => array(
      "production_standard",
      "production_express",
      "production_overnight"
    ),
    */
  );

  const ETAPES_PRINT_PROOFS = array(
    "proof_group_without" => 0,
    "proof_group_digital" => 7,
    "proof_group_standplott" => 15
  );

  const ETAPES_PRINT_PRODUCTIONS = array(
    "production_overnight" => array(
      "production_time" => 0,
      "production_price" => 1.5
    ),
    "production_express" => array(
      "production_time" => 2,
      "production_price" => 1.3
    ),
    "production_standard" => array(
      "production_time" => 4,
      "production_price" => 1
    ),
  );

  // all options
  const ETAPES_PRINT_OPTIONS = array(
    "cover",
    "paper",
    "format",
    "custom_format",
    "pages",
    "colors",
    "book_binding",
    "refinement",
    "finishing",
    "file_type",
    "quantity",
    "proof_group",
    "modele",
    "production",
    "display",
    "select_rules"
    // "theme",
  );

  // tables sql
  const ETAPES_PRINT_OPTIONS_TABLE = array(
    "paper",
    "format",
    "colors",
    "book_binding",
    "refinement",
    "finishing",
    "modele",
    "proof_group"
  );

  // customized <select>
  const ETAPES_PRINT_CUSTOM_SELECT = array(
    "paper",
    "format",
    "colors",
    "book_binding",
    "refinement",
    "finishing",
    "modele",
    "proof_group"
  );

  const ETAPES_PRINT_OPTION_FIELDS = array(
    "etapes-print-paper" => array("weight" => "string", "paper_p100kg" => "decimal", "paper_sq_rn" => "string", "margin" => "decimal"),
    "etapes-print-format" => array("height" => "decimal", "width" => "decimal", "format_setup_price" => "string", "format_p1000" => "string"),
    "etapes-print-colors" => array("colors_front" => "number", "colors_back" => "number", "colors_setup_price" => "string", "colors_p1000" => "string", "colors_sq_rn" => "string", "margin" => "decimal"),
    "etapes-print-book_binding" => array("production_time" => "number", "book_binding_setup_price" => "string", "book_binding_p1000" => "string", "book_binding_sq_rn" => "string"),
    "etapes-print-refinement" => array("production_time" => "number", "refinement_setup_price" => "string", "refinement_p1000" => "string", "refinement_sq_rn" => "string", "margin" => "decimal"),
    "etapes-print-finishing" => array("finishing_setup_price" => "string", "finishing_p1000" => "string", "finishing_sq_rn" => "string"),
    "etapes-print-modele" => array("modele_setup_price" => "string"),
    "etapes-print-proof_group" => array("proof_group_setup_price" => "string"),
  );

  public function get_option_fields($key) {
    return array_key_exists($key, $this::ETAPES_PRINT_OPTION_FIELDS) ? $this::ETAPES_PRINT_OPTION_FIELDS[$key] : $key;
  }

  public function get_label_by_key($key, $labels_option = array()) {
    if (array_key_exists($key, $labels_option)) {
      return $labels_option[$key];
    }
		$labels = $this->get_all_labels();
		return array_key_exists($key, $labels) ? $labels[$key] : $key;
	}

  /*
	public function get_labels_by_keys($keys) {
		$labels = $this->get_all_labels();
		$data = array();
		foreach ($keys as $key) {
			if( array_key_exists($key, $labels) ) {
				$data[$key] = $labels[$key];
			} else {
				$data[$key] = $key;
			}
		}
		return $data;
	}
  */

  public function get_options() {
		return $this::ETAPES_PRINT_OPTIONS;
	}

  public function get_options_table() {
		return $this::ETAPES_PRINT_OPTIONS_TABLE;
	}

  public function get_select_rules() {
    global $wpdb;
    $select_table = $wpdb->prefix . 'etapes_print_select_rule';
		$query = "SELECT code FROM $select_table ORDER BY code ASC";
		return $wpdb->get_results( $query, ARRAY_A );
  }

  public function get_covers() {
    global $wpdb;
    $cover_table = $wpdb->prefix . 'etapes_print_cover';
		$query = "SELECT code FROM $cover_table";
		$covers = $wpdb->get_col( $query );
    $results = array();
    foreach ($covers as $cover) {
      $results[$cover] = $cover;
    }
    return $results;
  }

  public function get_cover_by_code($cover_code) {
    global $wpdb;
    $cover_table = $wpdb->prefix . 'etapes_print_cover';
		$query = "SELECT * FROM $cover_table where code='$cover_code'";
		return $wpdb->get_row( $query, ARRAY_A );
  }

  public function get_select_rules_by_codes($select_rule_codes) {
    if (count($select_rule_codes) == 0) return [];
    global $wpdb;
    $select_table = $wpdb->prefix . 'etapes_print_select_rule';
    $query = "SELECT * FROM $select_table WHERE code IN ('" . implode("', '", $select_rule_codes) . "')";
    $select_rules = $wpdb->get_results( $query, ARRAY_A );
    $result = array();
    // map rules to an readable object
    $options_table = $this->get_options_table();
    foreach ($select_rules as $rule) {
      $select_data = array();
      $select_array = explode(';', $rule['select']);
			foreach ( $options_table as $index => $option ) {
				$select_data[$option] = array_filter(explode(',', $select_array[$index])); 
			}

      $deny_rule_codes = explode(',', $rule['denies']);
      $deny_data = $this->get_deny_rules_by_codes($deny_rule_codes);
      // get denies and map
      $result[] = array(
        "if" => $select_data,
        "deny" => $deny_data
      );
    }
    return $result;
  }

  public function get_deny_rules_by_codes($deny_rule_codes) {
    if (count($deny_rule_codes) == 0) return [];
    global $wpdb;
    $deny_table = $wpdb->prefix . 'etapes_print_deny_rule';
    $query = "SELECT * FROM $deny_table WHERE code IN ('" . implode("', '", $deny_rule_codes) . "')";
    $deny_rules = $wpdb->get_results( $query, ARRAY_A );
    $result = array();
    // map rules to an readable object
    $options_table = $this->get_options_table();
    foreach ($deny_rules as $rule) {
      $deny_array = explode(';', $rule['deny']);
			foreach ( $options_table as $index => $option ) {
				$result[$option] = array_merge($result[$option] ? $result[$option] : [], array_filter(explode(',', $deny_array[$index]))); 
			}
    }
    return $result;
  }

  public function get_option_table_values($option) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'etapes_print_' . $option;
    $sql = "SELECT code, name, position FROM $table_name ORDER BY position ASC";
    $results = $wpdb->get_results($sql);
    $option_values = array();
    foreach ($results as $result) {
      $option_values[$result->code] = $result->name;
    }
    return $option_values;
  }

  public function get_paper($code) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'etapes_print_paper';
    $sql = "SELECT * FROM $table_name where code='$code'";
    return $wpdb->get_row($sql);
  }

  public function get_option_by_code($option, $code) {
    global $wpdb;
    $table_name = $wpdb->prefix . str_replace('-', '_', $option);
    $sql = "SELECT * FROM $table_name where code='$code'";
    return $wpdb->get_row($sql);
  }

  public function get_results_by_options($option, $option_values) {
    $data = array();
    if (in_array($option, $this::ETAPES_PRINT_OPTIONS_TABLE)) {
      global $wpdb;
      $table_name = $wpdb->prefix . 'etapes_print_' . $option;
      $sql = "SELECT code, name, position FROM $table_name WHERE code in ('";
      $sql .= join("', '", $option_values);
      $sql .= "') ORDER BY position ASC";
  
      $results = $wpdb->get_results($sql);
      
      foreach ($results as $result) {
        $data[$result->code] = $result->name;
      }
    } else {
      foreach($option_values as $code) {
        $data[$code] = array_key_exists($code, $this::ETAPES_PRINT_LABELS) ? $this::ETAPES_PRINT_LABELS[$code] : $code;
      }
    }

    if (in_array('custom_format', $option_values) && !$data['custom_format']) {
      $data['custom_format'] = 'Personnalisée';
    }
    
    return $data;
  }

  public function set_matrix($data_string, $array_target) {
    $ranges = explode(';', $data_string);
    foreach ($ranges as $range) {
      $parts = explode(',', $range);
      if (count($parts) == 2) {
        array_push($array_target, array(
          floatval($parts[0]), floatval($parts[1])
        ));
      } else {
        if (count($array_target) == 0) {
          array_push($array_target, array(
            0, floatval($parts[0])
          ));
        }
        break;
      }
    }
    array_push($array_target, array(0, 0));
    return $array_target;
  }

  public function get_custom_options_data() {
		return $this::ETAPES_PRINT_OPTION_VALUES;
	}

  public function get_paper_weight_by_keyword($paper) {
    $etapes_print_pattern = '/\d+/';
    preg_match($etapes_print_pattern, $paper, $matches);
    if (count($matches)){
      return floatval($matches[0]);
    }
    return 0;
  }

  public function calculate_from_request() {
		$production_time = 0;

		$height = 0;
		$width = 0;
		$format_setup_price = 0;
		$format_p1000 = array();
		if ( isset($_REQUEST['etapes_print_format']) ) {
      // check if format is custom
			if ($_REQUEST['etapes_print_format'] === 'custom_format') {
				$width = $_REQUEST['etapes_print_custom_format_width'];
				$height = $_REQUEST['etapes_print_custom_format_height'];
			} else {
        $format = $this->get_option_by_code('etapes_print_format', $_REQUEST['etapes_print_format']);
        if ($format) {
          $height = $format->height;
          $width = $format->width;
          $format_setup_price = $format->format_setup_price;

          if ($format->format_p1000) {
            $format_p1000 = $this->set_matrix($format->format_p1000, $format_p1000);
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

		if ( isset($_REQUEST['etapes_print_cover_format'])) {
      $cover_format = $this->get_option_by_code('etapes_print_format', $_REQUEST['etapes_print_cover_format']);
      if ($cover_format) {
        $cover_height = $cover_format->height;
        $cover_width = $cover_format->width;
        $cover_format_setup_price = $cover_format->format_setup_price;

        if ($cover_format->format_p1000) {
          $cover_format_p1000 = $this->set_matrix($cover_format->format_p1000, $cover_format_p1000);
        }
      }

      if ( isset($_REQUEST['etapes_print_cover_paper'])  && $_REQUEST['etapes_print_cover_format'] !== 'format_sans_couv' ) {
        $cover_paper = $this->get_option_by_code('etapes_print_paper', $_REQUEST['etapes_print_cover_paper']);
        if ($cover_paper) {
          $cover_paper_weight = $this->get_paper_weight_by_keyword($cover_paper->weight);
          $cover_paper_kg_price = floatval($cover_paper->paper_p100kg);
          if ($cover_paper->paper_sq_rn) {
            $cover_paper_running_price = $this->set_matrix($cover_paper->paper_sq_rn, $cover_paper_running_price);
          }
        } else {
          $cover_paper_weight = $this->get_paper_weight_by_keyword($_REQUEST['etapes_print_cover_paper']);
        }
        if ($cover_paper->margin &&  $cover_paper->margin >= 0) {
          $cover_paper_margin = $cover_paper->margin;
        }
      } else {
				$no_refinement = true;
      }
		}
		

		$pages = 2;
		if ( isset($_REQUEST['etapes_print_pages']) ) {
			$pages = $this->get_paper_weight_by_keyword($_REQUEST['etapes_print_pages']);
		}

		$paper_weight = 0;
		$paper_kg_price = 0;
		$paper_running_price = array();
		$paper_margin = 1;
		if ( isset($_REQUEST['etapes_print_paper']) ) {
			$paper = $this->get_option_by_code('etapes_print_paper', $_REQUEST['etapes_print_paper']);
			if ($paper) {
				$paper_weight = $this->get_paper_weight_by_keyword($paper->weight);
				$paper_kg_price = floatval($paper->paper_p100kg);
				if ($paper->paper_sq_rn) {
					$paper_running_price = $this->set_matrix($paper->paper_sq_rn, $paper_running_price);
				}
			} else {
				$paper_weight = $this->get_paper_weight_by_keyword($_REQUEST['etapes_print_paper']);
			}
			if ($paper->margin &&  $paper->margin >= 0) {
				$paper_margin = $paper->margin;
			}
		}

		$colors_setup_price = 0;
		$colors_p1000 = array();
		$colors_running_price = array();
		$colors_margin = 1;
		if ( isset($_REQUEST['etapes_print_colors']) ) {
			$colors = $this->get_option_by_code('etapes_print_colors', $_REQUEST['etapes_print_colors']);
			if ($colors) {
				if ($colors->colors_setup_price) {
					$colors_setup_price = $colors->colors_setup_price;
				}
				if ($colors->colors_p1000) {
					$colors_p1000 = $this->set_matrix($colors->colors_p1000, $colors_p1000);
				}
				if ($colors->colors_sq_rn) {
					$colors_running_price = $this->set_matrix($colors->colors_sq_rn, $colors_running_price);
				}
				if ($colors->margin &&  $colors->margin >= 0) {
					$colors_margin = $colors->margin;
				}
			}
		}

		$book_binding_setup_price	= 0;
		$book_binding_p1000 = array();
		$book_binding_running_price = array();
		if ( isset($_REQUEST['etapes_print_book_binding']) ) {
			$book_binding = $this->get_option_by_code('etapes_print_book_binding', $_REQUEST['etapes_print_book_binding']);
			if ($book_binding) {
				if ($book_binding->book_binding_setup_price) {
					$book_binding_setup_price = $book_binding->book_binding_setup_price;
				}
				if ($book_binding->book_binding_p1000) {
					$book_binding_p1000 = $this->set_matrix($book_binding->book_binding_p1000, $book_binding_p1000);
				}
				if ($book_binding->book_binding_sq_rn) {
					$book_binding_running_price = $this->set_matrix($book_binding->book_binding_sq_rn, $book_binding_running_price);
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
		if ( isset($_REQUEST['etapes_print_refinement']) ) {
			$refinement = $this->get_option_by_code('etapes_print_refinement', $_REQUEST['etapes_print_refinement']);
			if ($refinement) {
				if ($refinement->refinement_setup_price) {
					$refinement_setup_price = $refinement->refinement_setup_price;
				}
				if ($refinement->refinement_p1000) {
					$refinement_p1000 = $this->set_matrix($refinement->refinement_p1000, $refinement_p1000);
				}
				if ($refinement->refinement_sq_rn) {
					$refinement_running_price = $this->set_matrix($refinement->refinement_sq_rn, $refinement_running_price);
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
		if ( isset($_REQUEST['etapes_print_finishing']) ) {
			$finishing = $this->get_option_by_code('etapes_print_finishing', $_REQUEST['etapes_print_finishing']);
			if ($finishing) {
				if ($finishing->finishing_setup_price) {
					$finishing_setup_price = $finishing->finishing_setup_price;
				}
				if ($finishing->finishing_p1000) {
					$finishing_p1000 = $this->set_matrix($finishing->finishing_p1000, $finishing_p1000);
				}
				if ($finishing->finishing_sq_rn) {
					$finishing_running_price = $this->set_matrix($finishing->finishing_sq_rn, $finishing_running_price);
				}
			}
		}

		$modele_setup_price = 0;
		if ( isset($_REQUEST['etapes_print_modele']) ) {
			$modele = $this->get_option_by_code('etapes_print_modele', $_REQUEST['etapes_print_modele']);
			if ($modele) {
				if ($modele->modele_setup_price) {
					$modele_setup_price = $modele->modele_setup_price;
				}
			}
		}

    $proof_group_setup_price = 0;
		if ( isset($_REQUEST['etapes_print_proof_group'])) {
			$proof_group = $this->get_option_by_code('etapes_print_proof_group', $_REQUEST['etapes_print_proof_group']);
			if ($proof_group) {
				if ($proof_group->proof_group_setup_price) {
					$proof_group_setup_price = $proof_group->proof_group_setup_price;
				}
			}
		}

    $quantity = 250;
    if ( isset($_REQUEST['etapes_print_quantity']) ) {
			$quantity = $_REQUEST['etapes_print_quantity'];
		}

    $production = 'production_standard';
    if ( isset($_REQUEST['etapes_print_production']) ) {
			$production = $_REQUEST['etapes_print_production'];
		}

    $delivery_price = get_option('etapes_print_delivery_price');

    $cover_format_price = $this->get_format_price($quantity, $cover_format_setup_price, $cover_format_p1000)["format_price"];
    $cover_paper_price = $this->get_paper_price($quantity, $pages, $cover_paper_weight, $cover_paper_kg_price, $cover_height, $cover_width, $cover_paper_running_price, $cover_paper_margin)["paper_price"];

    $format_price = $this->get_format_price($quantity, $format_setup_price, $format_p1000)["format_price"];
    $pages_price = $this->get_pages_price($quantity, $pages, 0, $height, $width)["pages_price"];
    $paper_price = $this->get_paper_price($quantity, $pages, $paper_weight, $paper_kg_price, $height, $width, $paper_running_price, $paper_margin)["paper_price"];
    $color_price = $this->get_color_price($quantity, $pages, $colors_setup_price, $height, $width, $colors_p1000, $colors_running_price, null, $colors_margin)["color_price"];
    $book_binding_price = $this->get_book_binding_price($quantity, $pages, $book_binding_setup_price, $height, $width, $book_binding_p1000, $book_binding_running_price)["book_binding_price"];
    $refinement_price = $no_refinement ? 0 : $this->get_refinement_price($quantity, $pages, $refinement_setup_price, $height, $width, $refinement_p1000, $refinement_running_price, $refinement_margin)["refinement_price"];
    $finishing_price = $this->get_finishing_price($quantity, $pages, $finishing_setup_price, $height, $width, $finishing_p1000, $finishing_running_price)["finishing_price"];

    $ht_price = ($cover_format_price + $cover_paper_price + $format_price + $pages_price + $paper_price + $color_price + $refinement_price + $finishing_price + $delivery_price + $book_binding_price) * ( 1 + $modele_setup_price );
    $etapes_print_price = ($proof_group_setup_price + $ht_price) * $this::ETAPES_PRINT_PRODUCTIONS[$production]['production_price'];

    return round($etapes_print_price, 2);
  }

  /**
	 * PRIVATES FUNCTIONS
	 */
	private function get_all_labels() {
		return $this::ETAPES_PRINT_LABELS;
	}

  private function get_setup_price($quantity, $setup_price) {
    if (is_numeric($setup_price)) return 0 + $setup_price;
    $custom_price = $this->set_matrix($setup_price, array(array(0, 0)));
    return $this->get_custom_price($quantity, $custom_price, $quantity);
  }


  public function get_format_price($quantity, $setup_price, $custom_price = array()) {
		$price_per_pieces = $this->get_custom_price($quantity, $custom_price);
    $setup_price = $this->get_setup_price($quantity, $setup_price);
		return array(
      "setup_price" => $setup_price,
      "price_p1000" => $price_per_pieces,
      "format_price" => $setup_price + $price_per_pieces
    );
	}

	public function get_pages_price(
		$quantity,
		$pages,
		$setup_price,
		$height,
		$width,
		$custom_price = array(
			array(1, 0),
			array(0, 0),
			array(0, 0),
			array(0, 0),
			array(0, 0)
		),
		$running_price = array(
			array(0, 0),
			array(0, 0),
			array(0, 0),
			array(0, 0),
			array(0, 0)
		),
		$installation_price = 0
	) {
		$m_square = $height * $width / 10000; // height and width are in cm
		$m_square_per_piece = $m_square * $pages;

		// custom_price
		$price_per_pieces = $this->get_custom_price($quantity, $custom_price);

		// running_price
		$quadrameter = $m_square_per_piece * $quantity / 2;
		$price_per_quadrameter = $this->get_running_price($quadrameter, $running_price);

    $setup_price = $this->get_setup_price($quantity, $setup_price);
    $pages_price = $setup_price + ($installation_price * $m_square_per_piece) + $price_per_pieces + $price_per_quadrameter;
		return array(
      "setup_price" => $setup_price,
      "installation_price" => $installation_price * $m_square_per_piece,
      "price_p1000" => $price_per_pieces,
      "running_price" => $price_per_quadrameter,
      "pages_price" => $pages_price,
      "pages" => $pages
    );
	}

	public function get_paper_price(
		$quantity,
		$pages,
		$paper_weight,
		$paper_price,
		$height,
		$width,
		$running_price = array(),
    $margin = 1
	) {

		$m_square = $height * $width / 10000; // height and width are in cm
		$m_square_per_piece = $m_square * $pages;

		// running_price
		$quadrameter = $m_square_per_piece * $quantity / 2;
		$price_per_quadrameter = $this->get_running_price($quadrameter, $running_price);

		$paper_price_kg = $paper_weight / 1000 * $paper_price / 100 * $quadrameter;
    $price_kg_with_margin = $paper_price_kg * $margin;

    $paper_price = $price_per_quadrameter + $price_kg_with_margin;
		return array(
      "margin" => $margin,
      "paper_price" => $paper_price,
      "running_price" => $price_per_quadrameter,
      "paper_sq_rn" => $running_price,
      "price_kg_with_margin" => $price_kg_with_margin,
      "cost_price" => $price_kg_with_margin - $paper_price_kg,
      "price_p100kg" => $paper_price_kg,
      "paper_weight" => $paper_weight
    );
	}

	public function get_color_price(
		$quantity,
		$pages,
		$setup_price,
		$height,
		$width,
		$custom_price = array(),
		$running_price = array(),
		$installation_price = 0,
    $margin = 1
	) {
		$m_square = $height * $width / 10000; // height and width are in cm
		$m_square_per_piece = $m_square * $pages;

		// custom_price
		$price_per_pieces = $this->get_custom_price($quantity, $custom_price);

		// running_price
		$quadrameter = $m_square_per_piece * $quantity / 2;
		$price_per_quadrameter = $this->get_running_price($quadrameter, $running_price);
    $price_with_margin = ($price_per_quadrameter + $price_per_pieces) * $margin;
    $setup_price = $this->get_setup_price($quantity, $setup_price);

    $color_price = $setup_price + ($installation_price * $m_square_per_piece) + $price_with_margin;
    return array(
      "margin" => $margin,
      "color_price" => $color_price,
      "setup_price" => $setup_price,
      "installation_price" => $installation_price * $m_square_per_piece,
      "price_p1000" => $price_per_pieces,
      "running_price" => $price_per_quadrameter,
      "colors_sq_rn" => $running_price,
      "price_with_margin" => $price_with_margin,
      "cost_price" => $price_with_margin - $price_per_quadrameter
    );
	}

	public function get_book_binding_price(
		$quantity,
		$pages,
		$setup_price,
		$height,
		$width,
		$custom_price = array(),
		$running_price = array()
	) {
		$m_square = $height * $width / 10000; // height and width are in cm
		$m_square_per_piece = $m_square * $pages;

		// custom_price
		$price_per_pieces = $this->get_custom_price($quantity, $custom_price);

		// running_price
		$quadrameter = $m_square_per_piece * $quantity / 2;
		$price_per_quadrameter = $this->get_running_price($quadrameter, $running_price);
    $setup_price = $this->get_setup_price($quantity, $setup_price);

    $book_binding_price = $setup_price + $price_per_pieces + $price_per_quadrameter;
		return array(
      "book_binding_price" => $book_binding_price,
      "setup_price" => $setup_price,
      "price_p1000" => $price_per_pieces,
      "running_price" => $price_per_quadrameter,
      "book_binding_sq_rn" => $running_price
    );
	}

	public function get_refinement_price(
		$quantity,
		$pages,
		$setup_price,
		$height,
		$width,
		$custom_price = array(),
		$running_price = array(),
    $margin = 1
	) {
		$m_square = $height * $width / 10000; // height and width are in cm
		$m_square_per_piece = $m_square * $pages;

		// custom_price
		$price_per_pieces = $this->get_custom_price($quantity, $custom_price);

		// running_price
		$quadrameter = $m_square_per_piece * $quantity / 2;
		$price_per_quadrameter = $this->get_running_price($quadrameter, $running_price);
    $price_with_margin = $price_per_quadrameter * $margin;
    $setup_price = $this->get_setup_price($quantity, $setup_price);

    $refinement_price = $setup_price + $price_per_pieces + $price_with_margin;
		return array(
      "margin" => $margin,
      "refinement_price" => $refinement_price,
      "setup_price" => $setup_price,
      "price_p1000" => $price_per_pieces,
      "running_price" => $price_per_quadrameter,
      "refinement_sq_rn" => $running_price,
      "price_with_margin" => $price_with_margin,
      "cost_price" => $price_with_margin - $price_per_quadrameter
    );
	}

	public function get_finishing_price(
		$quantity,
		$pages,
		$setup_price,
		$height,
		$width,
		$custom_price = array(),
		$running_price = array()
	) {
		$m_square = $height * $width / 10000; // height and width are in cm
		$m_square_per_piece = $m_square * $pages;

		// custom_price
		$price_per_pieces = $this->get_custom_price($quantity, $custom_price);

		// running_price
		$quadrameter = $m_square_per_piece * $quantity / 2;
		$price_per_quadrameter = $this->get_running_price($quadrameter, $running_price);
    $setup_price = $this->get_setup_price($quantity, $setup_price);

    $finishing_price = $setup_price + $price_per_pieces + $price_per_quadrameter;
    return array(
      "finishing_price" => $finishing_price,
      "setup_price" => $setup_price,
      "price_p1000" => $price_per_pieces,
      "running_price" => $price_per_quadrameter,
      "finishing_sq_rn" => $running_price
    );
	}

  public function run_query_handle_sql_error($sql, $redirection_page) {
    global $wpdb;
    if ( false === $wpdb->query($sql)) {
      // DO NOTHING
    } else {
      echo "<script>location.replace('admin.php?page=$redirection_page');</script>";
    }
  }

  public function get_delivery_dates($production_time) {
    $dates = array();
    foreach ($this::ETAPES_PRINT_PRODUCTIONS as $key => $value) {
      $dates[$key] = $this->addDays($value["production_time"] + $production_time, "l d/m");
    }
    return $dates;
  }

  function addDays($days, $format="Y-m-d"){
    for($i = 0; $i < $days; $i++){
      $day = date('N', strtotime("+" . ($i + 1) . "day"));
      if ($day>5) $days++;
    }
    return date_i18n($format, strtotime("+$i day"));
  }

	// PRIVATE UTIL FUNCTION

	private function get_custom_price($quantity, $custom_price, $per_item = 1000) {
		$price_per_pieces = 0;
		$custom_price_length = count($custom_price);
    if ($custom_price_length == 1) {
      $price_per_pieces = $custom_price[0][1] / $per_item * $quantity;
    }
		for ($i = 0; $i < $custom_price_length - 1; $i++) {
      $price_per_pieces = $custom_price[$i][1] / $per_item * $quantity;
			if ( $custom_price[$i][0] == $quantity ) {
				break;
			} else if ( $custom_price[$i][0] < $quantity && $quantity <= $custom_price[$i + 1][0] ) {
				$floor_unit_price = $custom_price[$i][1] / $per_item * $custom_price[$i][0];
				$ceil_unit_price = $custom_price[$i + 1][1] / $per_item * $custom_price[$i + 1][0];

				$numerator = (($quantity - $custom_price[$i][0]) * $ceil_unit_price) + (($custom_price[$i + 1][0] - $quantity) * $floor_unit_price);
				$denominator = ($quantity - $custom_price[$i][0]) + ($custom_price[$i + 1][0] - $quantity);

				$price_per_pieces = $numerator / $denominator;
				break;
			}
		}
		return $price_per_pieces;
	}

	private function get_running_price($quadrameter, $running_price) {
		$price_per_quadrameter = 0;
		$running_price_length = count($running_price);
    if ($running_price_length == 1) {
      $price_per_quadrameter = $running_price[0][1] * $quadrameter;
    }
		for ($i = 0; $i < $running_price_length - 1; $i++) {
			if ( $running_price[$i][0] == $quadrameter ) {
				$price_per_quadrameter = $running_price[$i][1] * $quadrameter;
				break;
			} else if ( ($running_price[$i][0] < $quadrameter && $quadrameter <= $running_price[$i + 1][0]) ||
				($running_price[$i + 1][0] < $running_price[$i][0]) ) {
				$floor_unit_price = $running_price[$i][1] * $running_price[$i][0];
				$ceil_unit_price = $running_price[$i + 1][1] * $running_price[$i + 1][0];

				$numerator = (($quadrameter - $running_price[$i][0]) * $ceil_unit_price) + (($running_price[$i + 1][0] - $quadrameter) * $floor_unit_price);
				$denominator = ($quadrameter - $running_price[$i][0]) + ($running_price[$i + 1][0] - $quadrameter);

				$price_per_quadrameter = $numerator / $denominator;
				break;
			}
		}
		return $price_per_quadrameter;
	}

  public function get_products($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'etapes_print_product_api_list';
    $query = "SELECT * FROM $table_name WHERE category_name = '$params'";
		$result = $wpdb->get_results($query, ARRAY_A);
    return $result;
  }

  public function get_categories(){
		$request1 = wp_remote_get('http://main-site.local/wp-json/etapes-print/v1/category/list');
		if( is_wp_error( $request1 ) ) {
			return false;
		}
		$body1 = wp_remote_retrieve_body( $request1 );
		$dataJson1 = json_decode( $body1 );
		$categroies = [];
		foreach ($dataJson1 as $key => $category) :
			array_push($categroies, $category);
		endforeach;
		return $categroies;
  }



}
