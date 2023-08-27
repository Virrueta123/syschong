export const myMixin = {
    data() {
        return {
            loadingSpinner: document.getElementById('loadingSpinner'),
            languajeSelect:{

                noResults: function() { 
                    return "No hay resultado";
                },
                searching: function() {

                    return "Buscando..";
                },

                errorLoading: function() {
                    return "ERROR_LOADING";
                },
                inputTooLong: function(args) {
                    return "INPUT_TOO_LONG";
                    
                },
                inputTooShort: function(args) { 
                    console.log(args);
                    return "Por favor ingrese "+args.minimum+" o más caracteres ";
                },
                loadingMore: function() {
                    return "LOADING_MORE";
                },
                maximumSelected: function(args) {
                    return "MAX_SELECTED";
                },

                couldNotLoad: function() {
                    return "Los resultados no se pudieron cargar.";
                },
            }
        }
    },
    methods: {

        showLoadingSpinner() {
            console.log('showLoadingSpinner');
            this.loadingSpinner.style.display = 'block';
        }, 
        // Función para calcular el precio con descuento
        calcularPrecioConDescuento(precioOriginal, porcentajeDescuento) {
            const descuento = (precioOriginal * porcentajeDescuento) / 100;
            const precioConDescuento = precioOriginal - descuento;
            return precioConDescuento;
        }, 
        calcularPrecioDescontado(precioOriginal, porcentajeDescuento) {
            const descuento = (precioOriginal * porcentajeDescuento) / 100; 
            return descuento;
        }, 
        hideLoadingSpinner() {
            this.loadingSpinner.style.display = 'none';
        }


    }
};