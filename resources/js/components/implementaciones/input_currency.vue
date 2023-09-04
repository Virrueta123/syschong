  
 <template>
    
      <input ref="input" :name="name_precio" v-model="inputValue" @keyup="formatCurrency" class="form-control currency" @blur="formatCurrency('blur')" placeholder="Ingrese el monto" />
    
  </template>
  
  <script>
  export default {
    name: 'CurrencyInput',
    data() {
      return {
        inputValue: this.$attrs.valor || '', // Variable para almacenar el valor del campo de entrada
        name_precio: this.$attrs.name_precio
      };
    },
    methods: {
       
      formatNumber(n) {
        // Formatea el número 1000000 a 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      },
      formatCurrency(blur) {
        // Agrega el símbolo "$" al valor, valida el lado decimal
        // y coloca el cursor en la posición correcta.
        
        // Obtiene el valor del input
        var input_val = this.inputValue;
        
        // No valida un input vacío
        if (input_val === "") { return; }
        
        // Longitud original
        var original_len = input_val.length;
      
        // Posición inicial del cursor
        var caret_pos = this.$refs.input.selectionStart;
          
        // Verifica si hay un decimal
        if (input_val.indexOf(".") >= 0) {
      
          // Obtiene la posición del primer decimal
          // esto evita que se ingresen múltiples decimales
          var decimal_pos = input_val.indexOf(".");
      
          // Divide el número por el punto decimal
          var left_side = input_val.substring(0, decimal_pos);
          var right_side = input_val.substring(decimal_pos);
      
          // Agrega comas al lado izquierdo del número
          left_side = this.formatNumber(left_side);
      
          // Valida el lado derecho
          right_side = this.formatNumber(right_side);
          
          // Al salir, asegura 2 números después del decimal
          if (blur === "blur") {
            right_side += "00";
          }
          
          // Limita el decimal a solo 2 dígitos
          right_side = right_side.substring(0, 2);
      
          // Une el número por el punto
          input_val =  left_side + "." + right_side;
      
        } else {
          // No se ha ingresado un decimal
          // Agrega comas al número
          // Elimina todos los caracteres no numéricos
          input_val = this.formatNumber(input_val);
          
          // Formateo final
          if (blur === "blur") {
            input_val += ".00";
          }
        }
        
        // Actualiza el valor del input
        this.inputValue = input_val;
        
        
        // Coloca el cursor en la posición correcta
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        this.$refs.input.setSelectionRange(caret_pos, caret_pos);
      },
    },
    mounted(){
         console.log(this.name_precio);
    }
  };
  </script>