import 'gasparesganga-jquery-loading-overlay';

import 'gasparesganga-jquery-loading-overlay';
import axios from 'axios';
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

         limitarCaracteres(cadena, limite) {
            if (cadena.length <= limite) {
              return cadena;
            } else {
              return cadena.substring(0, limite) + '...'; // Agrega puntos suspensivos al final
            }
          },

          send_axios(title_question, question, data, url) {
            return new Promise((resolve, reject) => {
              Swal.fire({
                title: title_question,
                text: "--",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: question,
              }).then((result) => {
                if (result.isConfirmed) {
                  const headers = {
                    "Content-Type": "application/json",
                  };
          
                  axios
                    .post(url, data, {
                      headers,
                    })
                    .then((response) => {
                      console.log(response.data);
                      if (response.data.success) {
                        resolve(true); // Resuelve la promesa con "true" si la solicitud fue exitosa
                      } else {
                        Swal.fire({
                          icon: "error",
                          title: "Error",
                          text: response.data.message,
                          footer: "-------",
                        });
                        console.error(response.data);
                        reject(response.data.message); // Rechaza la promesa con el mensaje de error
                      }
                    })
                    .catch((error) => {
                      Swal.fire({
                        icon: "error",
                        title: "Error 500",
                        text: "Error en el servidor, vuelva a intentar",
                        footer: "-------",
                      });
                      console.error(error);
                      reject("Error en el servidor"); // Rechaza la promesa con un mensaje de error genérico
                    });
                } else {
                  reject("Operación cancelada"); // Rechaza la promesa si el usuario cancela la operación
                }
              });
            });
          },

          send_axios_reponse(title_question, question, data, url) {
            return new Promise((resolve, reject) => {
              Swal.fire({
                title: title_question,
                text: "--",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: question,
              }).then((result) => {
                if (result.isConfirmed) {
                  const headers = {
                    "Content-Type": "application/json",
                  };
          
                  axios
                    .post(url, data, {
                      headers,
                    })
                    .then((response) => { 
                      
                        resolve(response.data); // Rechaza la promesa con el mensaje de error
                     
                    })
                    .catch((error) => {
                      
                      resolve({
                        'message' : 'error del servidor',
                        'error' : 'Codigo Error: 500',
                        'success' : false,
                        'data' : '',
                      });
                       // Rechaza la promesa con un mensaje de error genérico
                    });
                } else {
                  // Rechaza la promesa si el usuario cancela la operación
                }
              });
            });
          },

  currency(name){
    console.log(name)
    $("input[data-type='"+name+"']").on({
        keyup: function() {
          formatCurrency($(this));
        },
        blur: function() { 
          formatCurrency($(this), "blur");
        }
    });
   },

    formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },

      formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.
            
            // get input value
            var input_val = input.val();
            
            // don't validate empty input
            if (input_val === "") { return; }
            
            // original length
            var original_len = input_val.length;
          
            // initial caret position 
            var caret_pos = input.prop("selectionStart");
              
            // check for decimal
            if (input_val.indexOf(".") >= 0) {
          
              // get position of first decimal
              // this prevents multiple decimals from
              // being entered
              var decimal_pos = input_val.indexOf(".");
          
              // split number by decimal point
              var left_side = input_val.substring(0, decimal_pos);
              var right_side = input_val.substring(decimal_pos);
          
              // add commas to left side of number
              left_side = formatNumber(left_side);
          
              // validate right side
              right_side = formatNumber(right_side);
              
              // On blur make sure 2 numbers after decimal
              if (blur === "blur") {
                right_side += "00";
              }
              
              // Limit decimal to only 2 digits
              right_side = right_side.substring(0, 2);
          
              // join number by .
              input_val =  left_side + "." + right_side;
          
            } else {
              // no decimal entered
              // add commas to number
              // remove all non-digits
              input_val = formatNumber(input_val);
              input_val =  input_val;
              
              // final formatting
              if (blur === "blur") {
                input_val += ".00";
              }
            }
            
            // send updated string to input
            input.val(input_val);
          
            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
          },
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