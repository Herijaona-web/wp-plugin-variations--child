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

 /**
  * The admin-specific functionality of the plugin.
  *
  * Defines the plugin name, version, and two examples hooks for how to
  * enqueue the admin-specific stylesheet and JavaScript.
  *
  * @package    Etapes_Print
  * @subpackage Etapes_Print/admin/modules
  * @author     Njakasoa Rasolohery <ras.njaka@gmail.com>
  */
class Select_Rule_Table_List extends WP_List_Table {
 
    // Définir les colonnes de la table
    public function get_columns() {
        $columns = array(
            'id'      => 'ID',
            'code'    => 'Code',
            'select'    => 'Select',
            'denies'    => 'Denies',
            'actions' => 'Actions'
        );
 
        return $columns;
    }
 
    // Récupérer les données de la table
    public function prepare_items() {
        
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $primary  = 'code';
        $this->_column_headers = array($columns, $hidden, $sortable, $primary);


        global $wpdb;
        $table_name = $wpdb->prefix."etapes_print_select_rule";
        // Définir le nombre d'éléments par page
        $per_page = 20;
    
        // Récupérer le numéro de la page courante
        $current_page = $this->get_pagenum();
    
        // Calculer le nombre total d'enregistrements dans la table
        $total_items = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
    
        // Définir le nombre total de pages
        $total_pages = ceil( $total_items / $per_page );
    
        // Limiter les enregistrements à ceux qui sont affichés sur la page courante
        $offset = ( $current_page - 1 ) * $per_page;
        $query = "SELECT * FROM $table_name ORDER BY id DESC LIMIT $offset, $per_page";
        $data = $wpdb->get_results( $query, ARRAY_A );

        // Ajout des actions "Modifier" et "Supprimer" aux données de la table
        foreach ( $data as &$item ) {
            $edit_link = add_query_arg( array(
                'page'   => 'etapes-print-select-rule',
                'action' => 'edit',
                'id'     => $item['id']
            ), admin_url( 'admin.php' ) );
            $delete_link = add_query_arg( array(
                'page'   => 'etapes-print-select-rule',
                'action' => 'delete',
                'id'     => $item['id']
            ), admin_url( 'admin.php' ) );
            $item['actions'] = '<a href="' . $edit_link . '">Modifier</a> | <a href="' . $delete_link . '">Supprimer</a>';
        }
    
        // Envoyer les données à la classe parente
        $this->items = $data;
    
        // Définir les pagination_args pour la pagination
        $this->set_pagination_args( array(
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => $total_pages
        ) );
    }

    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'id':
            case 'code':
            case 'select':
            case 'denies':
            default:
                return $item[$column_name];
        }
    }
}

?>