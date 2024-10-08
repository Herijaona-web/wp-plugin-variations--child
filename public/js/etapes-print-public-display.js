(function( $ ) {
	'use strict';
	$(document).on({
		dragover: function() {
			return false;
		},
		drop: function() {
			return false;
		}
	});
	/**
	 * All of the code for your public-facing JavaScript source
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

  var etapes_print_product_customization = document.querySelector('#etapes_print_product_customization');

  if (etapes_print_product_customization) {
    const { createApp } = Vue;

    createApp({
      data() {
        return {
			recapElement: null,
			parentElement: null, // as known as $(this)
			tableElement: null,

			recapFormat: null,
			customFormat: {
				rules: {
					width: '0:0', // <-- Rules can be setted on php side regex
					height: '0:0'
				},
				width: 0,
				height: 0
			},

          	options: etapes_print_vue_object,
			recapOptions: [],
			variations: {},
			prices: {},
			quantity: 1000,
			production: 'production_standard',
			productions: undefined,
			productionLabels: undefined,
			vat: false,
			customQuantity: null,
			loading: false,
			min: 0,
			max: 0,
			filtered: false,
			priceKeys: [],
			selectRules: [],
			disabledList: [],
			activeRules: [],
			ruleProcessing: false,
			quantityError: false,
			dropZoneLabel: 'Glisser votre fichier',
			file: null,
			pdf: null,
			currentPage: 1,
			pages: 1
        }
      },
			beforeMount() {
				Object.keys(this.options).forEach(key => {
					if (key === 'cover') {
						this.variations[`etapes_print_${key}_format`] = this.options[key].default_format;
						this.variations[`etapes_print_${key}_paper`] = this.options[key].default_paper;
					} else if (key ==='select_rules') {
						this.selectRules = this.options[key];
						this.selectRules.forEach(rule => {
							Object.keys(rule['if']).forEach(key => {
								if (rule['if'][key].length && !this.activeRules.includes(key)) this.activeRules.push(key);
							});
						});
					} else if (key ==='delay_delivery') {
						this.variations[`etapes_print_delay_delivery`] = +this.options[key];
					} else if (key === 'default_quantity') {
						this.quantity = +this.options[key];
					} else if (key === 'price_array') {
						this.priceKeys = this.options[key].split(',');
					} else if (key === 'quantity') {
						this.max = +this.options[key].max;
						this.min = +this.options[key].min;
					} else if (key === 'custom_format') {
						this.customFormat.rules.width = this.options[key].width.split(':');
						this.customFormat.rules.height = this.options[key].height.split(':');
						this.resetCustomFormat();
					} else {
						this.variations[`etapes_print_${key}`] = this.options[key].default_value;
					}
				});
				this.filtered = this.min && this.max && this.min < this.max;
			},
      mounted() {
		// console.log(this.activeRules);
		this.getPrices();
		pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://unpkg.com/pdfjs-dist@2.10.377/build/pdf.worker.js';
		this.recapElement = this.$refs.recap;
		this.tableElement = this.$refs.table;
		this.parentElement = this.recapElement.parentElement;
		window.addEventListener('scroll', this.handleScroll);

		// Initialize table element header
		const labels = this.tableElement.querySelectorAll('.label');
		labels.forEach(label => {
			const key = label.firstChild.htmlFor;
			const title = label.firstChild.textContent;
			const values = JSON.parse(label.parentElement.dataset.etapesPrint);
			this.recapOptions.push({ key, title, values });
		});
		this.recapFormat = this.recapOptions.find(option => option.key === 'etapes_print_format');
      },
			methods: {
				handleScroll(event) {
					const current = this.parentElement.getBoundingClientRect().top;
					const parentHeight = this.parentElement.offsetHeight;
					const recapHeight = this.recapElement.offsetHeight;
					const margin = 200;
					if (current < margin) {
						let marginTop = margin - current;
						marginTop = Math.min(marginTop, parentHeight - recapHeight)
						$(this.recapElement).css('margin-top', marginTop);
					}
				},
				selectProduction(production) {
					this.production = production;
				},
				selectQuantity(quantity) {
					this.quantity = +quantity;
				},
				selectQuantityProduction(quantity, production) {
					this.quantity = +quantity;
					this.production = production;
				},
				selectValue(key, value) {
					this.variations[`etapes_print_${key}`] = value;
					$(`.etapes_print_${key}_custom_field_option.active`).removeClass('active');
					$(`#etapes_print_${key}_custom_option_${value}`).addClass('active');
					if (value === `custom_${key}`) {
						return this.updateCustomFormatLabel();
					}
					this.getPrices();
				},
				checkRules() {
					if (this.ruleProcessing) return;
					this.ruleProcessing = true;
					let disabledList = [];
					this.activeRules.forEach(key => {
						if (['format', 'paper'].includes(key) && this.variations[`etapes_print_cover_${key}`]) {
							const value = this.variations[`etapes_print_cover_${key}`];
							this.selectRules.forEach(rule => {
								if (rule['if'][key].includes(value)) {
									Object.keys(rule['deny']).forEach(k => {
										if (rule['deny'][k].length) {
											disabledList = [...disabledList, ...rule['deny'][k]];
										}
									});
								}
							});
						}
						const value = this.variations[`etapes_print_${key}`];
						this.selectRules.forEach(rule => {
							if (rule['if'][key].includes(value)) {
								Object.keys(rule['deny']).forEach(k => {
									if (rule['deny'][k].length) {
										disabledList = [...disabledList, ...rule['deny'][k]];
									}
								});
							}
						});
					});
					if (!this.disabledList.length) this.disabledList = [disabledList];

					const enable = this.disabledList.filter(val => !disabledList.includes(val));
					const disable = disabledList.filter(val => !this.disabledList.includes(val));

					enable.forEach(val => {
						const div = $( `div[data-value='${val}']` );
						const element = div.length ? div : $( `option[value='${val}']` );
						if (element.length) {
							element.attr('hidden', false);
						}
					});
					const unselectElements = [];
					disable.forEach(val => {
						let element = $( `div[data-value='${val}']` );
						let unselect = false;
						if (element.length) {
							unselect = element.hasClass('active');
						} else {
							element = $( `option[value='${val}']` );
							unselect = element.attr('active') === 'true';
						}

						if (element.length) {
							element.attr('hidden', true);
						}
						if (unselect) {
							unselectElements.push(element);
						}
					})
					this.disabledList = disabledList;
					unselectElements.forEach(el => {
						const val = el.attr('value');
						const sibling = el.siblings("*[hidden!='hidden']").first();
						if (!sibling.length) alert(`Deny Rules ERROR: there is no more available option for ${val}`);
						else {
							console.log('from', val, 'to', sibling.attr('value'));
							if (sibling.prop("tagName") === "DIV") {
								sibling.trigger('click');
							} else {
								const model = sibling.parent().attr('name');
								this.variations[model] = sibling.attr('value');
							}								
						}
					});
					this.ruleProcessing = false;
				},
				async getPrices() {
					this.checkRules();
					let url = new URL(`${window.location.origin}/wp-json/etapes-print/v4.0.0/price`);
					Object.keys(this.variations).forEach(key => url.searchParams.append(key, this.variations[key]));
					if (this.priceKeys.length) url.searchParams.append('etapes_print_quantity', this.priceKeys.join(','));
					
					// Send custom format if needed
					if (this.variations['etapes_print_format'] === 'custom_format') {
						url.searchParams.append('etapes_print_custom_format_width', this.customFormat.width);
						url.searchParams.append('etapes_print_custom_format_height', this.customFormat.height);
					}
					const res = await fetch(url);
					const val = await res.json();
					this.prices = val.prices;
					if (val.price_debugger) {
						console.log({ price_debugger: val.price_debugger });
					}
					this.updatePriceKeys();
					this.productionLabels = val.production_labels;
					if (!this.productions) this.productions = val.productions;
				},
				printPrice(price, production_price) {
					const rate = this.vat ? 1.2 : 1;
					return (price * production_price * rate).toFixed(2)
				},
				formatPrice(price) {
					if (!price) price = 0;
					const scale = this.productions ? this.productions[this.production].production_price : 1;
					return (price * scale).toFixed(2) + ' €';
				},
				// CUSTOM QUANTITY
				async fetchPrice($event) {
					this.quantityError = false;
					$event.preventDefault();
					if (!this.customQuantity || this.loading) return;
					if (this.filtered && (this.customQuantity < this.min
						|| this.customQuantity > this.max)) {
							this.quantityError = true;
							return;
						}
					if (!this.prices[this.customQuantity]) {
						this.loading = true;
						let url = new URL(`${window.location.origin}/wp-json/etapes-print/v4.0.0/price`);
						Object.keys(this.variations).forEach(key => url.searchParams.append(key, this.variations[key]));
						url.searchParams.append('etapes_print_quantity', this.customQuantity);
						const res = await fetch(url);
						const val = await res.json();
						this.prices[this.customQuantity] = val.prices[this.customQuantity];
						this.updatePriceKeys();
						this.loading = false;
					}
					this.quantity = this.customQuantity;
					this.customQuantity = null;
				},
				updatePriceKeys() {
					if (!this.filtered) {
						this.priceKeys =  Object.keys(this.prices);
					} else {
						this.priceKeys =  Object.keys(this.prices).filter(price => {
							return this.min <= price && price <= this.max;
						});
					}
				},

				// CUSTOM FORMAT
				updateCustomFormatLabel() {
					if (this.variations['etapes_print_format'] !== 'custom_format') return;
					if (!this.checkCustomFormat()) {
						// setup user friendly error about input rules
						return;
					}
					this.recapFormat.values['custom_format'] = `Personnalisée (${this.customFormat.width}cm x ${this.customFormat.height}cm)`;
					this.getPrices();
				},
				resetCustomFormat() {
					// SET MINIMAL VALUES
					this.customFormat.width = +this.customFormat.rules.width[0];
					this.customFormat.height = +this.customFormat.rules.height[0];
				},
				checkCustomFormat() {
					const widthOk = this.customFormat.rules.width[0] <= this.customFormat.width && this.customFormat.width <= this.customFormat.rules.width[1];
					const heightOk =  this.customFormat.rules.height[0] <= this.customFormat.height && this.customFormat.height <= this.customFormat.rules.height[1];
					return widthOk && heightOk;
				},

				// UPLOAD FEATURE
				uploadFromEvent(event) {
					const files = event.target.files;
					if (!files.length) return;
					const fileCheck = this.uploadFile(files[0]);
					this.dragOutHandler(event, fileCheck);
				},
				uploadFile(file) {
					const mimeType = file.type;
					if (mimeType !== 'application/pdf') return false;
					if (file.size > 128 * 1024 * 1024) {
						return false;
					}
					this.file = file;
					return true;
				},
				visualizeFile() {
					const fileReader = new FileReader();
					const $this = this;
					fileReader.onload = function () {
						const typedarray = new Uint8Array(this.result);
						const loadingTask = pdfjsLib.getDocument(typedarray);
						loadingTask.promise.then(pdf => {
							const modal = $('.etapes-print-modal').last();
							const fusionHeader = $('.fusion-tb-header');
							const height = fusionHeader.height();
							modal.addClass('open');
							modal.css({
								top: height + 'px',
								height: `calc(100vh - ${height}px)`
							});
							$('html, body').css({
								overflow: 'hidden',
								height: '100%'
							});
							$this.pages = pdf.numPages;
							$this.pdf = pdf;
							$this.currentPage = 1;
							pdf.getPage(1).then($this.handlePages);
						});
					}
					fileReader.readAsArrayBuffer(this.file);
				},
				handlePages(page) {
					const viewport = page.getViewport({ scale: 1 });
					//We'll create a canvas for each page to draw it on
					const canvas = document.getElementById("visualizer_canvas");
					const context = canvas.getContext('2d');
					canvas.height = viewport.height;
					canvas.width = viewport.width;
					//Draw it on the canvas
					page.render({canvasContext: context, viewport: viewport});
				},
				sideTo(numPage) {
					if (this.currentPage === numPage) return;
					this.currentPage = numPage;
					this.pdf.getPage(numPage).then(this.handlePages);
				},
				closeVisualizer() {
					$('.etapes-print-modal').last().removeClass('open');
					$('html, body').css({
						overflow: 'auto',
						height: 'auto'
					});
				},
				deleteFile() {
					this.dropZoneLabel = 'Déposez votre fichier';
					this.file = null;
					const inputFile = $('input[name="etapes_print_file"]');
					if (!inputFile.length) return;
    				inputFile[0].files = null;
				},
				open() {
					$('#etapes_print_file').trigger('click');
				},
				dropHandler(event) {
						event.preventDefault();
						const files = event.dataTransfer.files || event.target.files;
						const file = files[0];
						const mimeType = file.type;
						if (mimeType !== 'application/pdf') return;
						
						const inputFile = $('input[name="etapes_print_file"]');
						if (!inputFile.length) return;
						const dataTransfer = new DataTransfer();
						dataTransfer.items.add(file);
						inputFile[0].files = dataTransfer.files;
						const fileCheck = this.uploadFile(file);
						this.dragOutHandler(event, fileCheck);
				},
				dragInHandler(event) {
					event.preventDefault();
					const files = event.dataTransfer.items;
					if (!files.length) return;
					const file = files[0];
					if (file.type !== 'application/pdf') {
						$('.etapes_print_upload_drop').last().addClass('error');
						this.dropZoneLabel = 'Le fichier n\'est pas un document PDF';
						return;
					}
					$('.etapes_print_upload_drop').last().addClass('active');
					this.dropZoneLabel = 'Déposez votre fichier';
				},
				dragOutHandler(event, fileCheck = true) {
					event.preventDefault();
					$('.etapes_print_upload_drop').last().removeClass('active error');
					if (fileCheck) {
						this.dropZoneLabel = 'Glissez votre fichier';
					} else {
						$('.etapes_print_upload_drop').last().addClass('error');
						this.dropZoneLabel = 'Fichier trop volumineux (128Mo max.)';
					}
				}
			}
    }).mount('#etapes_print_product_customization');


  }

})( jQuery );