<div class="border-pep">
    <table class="form-table">
        <tr>
            <th scope="row">Sociéte :</th>
            <td><?php echo esc_html($result->societe) ; ?> </td>
        </tr>
        <tr>
            <th scope="row">Adresse postale :</th>
            <td><?php echo esc_html($result->adresse_postale) ; ?> </td>
        </tr>
        <tr>
            <th scope="row">Télephone ou contact :</th>
            <td><?php echo esc_html($result->contact) ; ?> </td>
        </tr>
        <tr>
            <th scope="row">Email de contact :</th>
            <td><?php echo esc_html($result->email_contact) ; ?> </td>
        </tr>
        <tr>
            <th scope="row">Votre remise revendeur :</th>
            <td><?php echo esc_html($result->remise_revendeur.'%') ; ?> </td>
        </tr>      
    </table>
</div>

<a href="<?php echo admin_url("admin.php?page=etapes-print-produits-etapes-print&facture_achat=$result->societe"); ?>" class="btn-facture-achat">Mes factures d'achats</a>




