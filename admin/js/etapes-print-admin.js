(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(function() {
		$("select#etapes_print_select_multiple").each(function (index) {
			const select = $(this);
			select.change(() => {
				const selectedOptions = select.children("option:selected");
				const classId = select.attr('name').replace('values[]', 'default_value');
				const targetSelect = $(`select#${classId}`).first();
				let defaultValue = targetSelect.children("option:selected").val();
				targetSelect.empty();
				selectedOptions.each(function (index) {
					const option  = $(this).clone();
					if (defaultValue !== option.val()) {
						option.removeAttr("selected");
					}
					targetSelect.append(option);
				});
			});
			select.trigger("change");
		});
	});

	$(function(){
		//product and category list
		$('#etapes_print_category_product').change(function(){
			let a = $('#etapes_print_category_product option:selected').text();
			//location.href = location.href + '&c=' + a;
		});
		$('#etapes_print_category_product2').change(function(e){
			let product = $('#etapes_print_category_product2 option:selected').text();
			$('#title').attr('value',product);
		});
		let searchParams = new URLSearchParams(window.location.search);
			let param = searchParams.get('c');
			$('#etapes_print_category_product option').each(function(){
				if(param == $(this).text()){
					$(this).attr('selected','');
				}
			});
			let titleProduct = $('#title').val();
			$('#etapes_print_category_product2 option').each(function(){
				if(titleProduct == $(this).text()){
					$(this).attr('selected','');
				}
		});
	});

	//Product onglet general
	$(function(){
		$(function(){
			//product and category list
			$('#etapes_print_category_product').change(function(){
				let a = $('#etapes_print_category_product option:selected').text();
				location.href = location.href + '&c=' + a;
			});
			$('#etapes_print_category_product2').change(function(e){
				let product = $('#etapes_print_category_product2 option:selected').text();
				console.log(product);
				$('#title').attr('value',product);
				$('#title-prompt-text').css('opacity','0');
			});
			let searchParams = new URLSearchParams(window.location.search);
				let param = searchParams.get('c');
				$('#etapes_print_category_product option').each(function(){
					if(param == $(this).text()){
						$(this).attr('selected','');
					}
				});
				let titleProduct = $('#title').val();
				$('#etapes_print_category_product2 option').each(function(){
					if(titleProduct == $(this).text()){
						$(this).attr('selected','');
					}
			});

	
			/* General price */
			$('._remise_revendeur_comprise').insertAfter('._prix_achat_ht_field label');
			$('._regular_price_field').parent().appendTo('#product_custom_field_general');
			$('._regular_price_field').parent().addClass('tarif_price');
			setTimeout(() => {
				$('._tax_status_field').parent().insertAfter('.tarif_price');
			}, 500);
	
			$(".tab").click(function (){
				$(this).addClass("button-primary").siblings().removeClass("button-primary");   
			});
	
			let prix_achat = $('#_prix_achat_ht').val();
			let marge_benefice = $('#_marge_beneficiaire').val();
			let devise = $('.button-primary.tab').text();
			if(devise == '€'){
				let total = parseFloat(prix_achat) + parseFloat(marge_benefice);
				// if($('#_marge_beneficiaire').val('')){
				// 	$('#_regular_price').removeAttr('value');
				// }else{
				// 	$('#_regular_price').attr('value', total.toFixed(2));
				// }
			}else{
				let total = (1 + parseFloat(marge_benefice) /100) *  parseFloat(prix_achat);
				// if($('#_marge_beneficiaire').val('')){
				// 	$('#_regular_price').removeAttr('value');
				// }else{
				// 	$('#_regular_price').attr('value', total.toFixed(2));
				// }
			}
			$('.btn_beneficiaire a').eq(0).click(function(){
				let total = parseFloat($('#_prix_achat_ht').val()) + parseFloat($('#_marge_beneficiaire').val());
				$('#_regular_price').attr('value', total.toFixed(2));
			})
			$('.btn_beneficiaire a').eq(1).click(function(){
				let calcul = (1 + parseFloat($('#_marge_beneficiaire').val()) /100) * parseFloat(jQuery('#_prix_achat_ht').val());
				$('#_regular_price').attr('value', calcul.toFixed(2));
			});
	
			$('#_marge_beneficiaire').keyup(function(){
				if($('.btn_beneficiaire a').eq(0).hasClass('button-primary') == true){
				let a = parseFloat($(this).val()) + parseFloat($('#_prix_achat_ht').val());
				$('#_regular_price').attr('value',a.toFixed(2));
				}
			});
			$('#_marge_beneficiaire').keyup(function(){
				if(jQuery('.btn_beneficiaire a').eq(1).hasClass('button-primary') == true){
					let calcul = (1 + parseFloat($(this).val()) /100) * parseFloat(jQuery('#_prix_achat_ht').val());
					$('#_regular_price').attr('value', calcul.toFixed(2));
				}
			});
			$("#_prix_achat_ht").prop('disabled', true);
			$('._regular_price_field label').text('Votre prix de vente (€)');
			$('._sale_price_field label').text('Prix promo (€)');


			/* End General price */

			/* Get categories */

			
			jQuery.ajax({
				type: 'GET',
				url: 'http://main-site.local/wp-json/etapes-print/v1/category/list',
				data: {action:'my_action',param:15557}, 
				beforeSend: function(){
					console.log('happened');
				},
				success: function(data,status,test,n){
					console.log(data, status,test);
				},
				error: function(data,status){
					console.log(data, status);
				}
			});

			$(arr).each(function() {
				$('#etapes_print_category_product').append($("<option>").attr('value',this.val).text(this.text));
			 });
			
			/* End Get categories */

		});
	});

})( jQuery );
