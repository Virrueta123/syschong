<template>
  <div class="">
    <h2 class="section-title">Buscando ruc</h2>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4">Ruc</label>
        <div class="input-group">
          <input
            v-model="cli_ruc"
            type="text"
            name="cli_ruc"
            class="form-control"
            id="cli_ruc"
            placeholder=""
            aria-label=""
          />
          <div class="input-group-append">
            <button
              class="btn btn-danger boton-color"
              type="button"
              v-on:click="buscar_dni"
            >
              <i class="fa fa-search" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="form-group col-md-6">
        <label for="inputEmail4">Razon social</label>
        <input
          v-model="cli_razon_social"
          type="text"
          class="form-control"
          name="cli_razon_social"
          id="cli_razon_social"
          placeholder="Nombre"
        />
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="inputEmail4">Direccion</label>
        <input
          v-model="cli_direccion_ruc"
          type="text"
          class="form-control"
          name="cli_direccion_ruc"
          id="cli_direccion_ruc"
          placeholder="Direccion"
        />
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="inputEmail4">Departamento</label>
        <input
          v-model="cli_departamento_ruc"
          type="text"
          class="form-control"
          name="cli_departamento_ruc"
          id="cli_departamento_ruc"
          placeholder="Departamento"
        />
      </div>
      <div class="form-group col-md-4">
        <label for="inputEmail4">Provincia</label>
        <input
          v-model="cli_provincia_ruc"
          type="text"
          class="form-control"
          name="cli_provincia_ruc"
          id="cli_provincia_ruc"
          placeholder="Provincia"
        />
      </div>
      <div class="form-group col-md-4">
        <label for="inputPassword4">Distrito</label>
        <input
          v-model="cli_distrito_ruc"
          type="text"
          class="form-control"
          name="cli_distrito_ruc"
          id="cli_distrito_ruc"
          placeholder="Distrito"
        />
      </div>
    </div>
  </div>
</template> 
  
  <script>
import axios from "axios";
import { myMixin } from "../mixin.js";
import Swal from "sweetalert2";

export default {
  mixins: [myMixin],
  data() {
    return {
      cli_ruc: this.$attrs.cli_ruc,
      cli_razon_social: this.$attrs.cli_razon_social,
      cli_apellido: this.$attrs.cli_apellido,
      cli_direccion_ruc: this.$attrs.cli_direccion_ruc,
      cli_departamento_ruc: this.$attrs.cli_departamento_ruc,
      cli_distrito_ruc: this.$attrs.cli_distrito_ruc,
      cli_provincia_ruc: this.$attrs.cli_provincia_ruc,
    };
  },
  methods: {
    buscar_dni() {
      const data = { ruc: this.cli_ruc };
      console.log(this.cli_ruc.length);
      if (this.cli_ruc.length >= 11) {
        this.showLoadingSpinner();
        axios
          .post("/consulta_ruc_api", data)
          .then((response) => {
            console.log(response);
            if (response.data.success) {
              this.cli_razon_social = response.data.data.nombre_o_razon_social;

              this.cli_direccion_ruc = response.data.data.direccion;
              this.cli_departamento_ruc = response.data.data.departamento;
              this.cli_distrito_ruc = response.data.data.distrito;
              this.cli_provincia_ruc = response.data.data.provincia;
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Ruc valido",
                showConfirmButton: false,
                timer: 1500,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: response.data.message,
                text: "verifique el Ruc porfavor!",
              });
            }
            this.hideLoadingSpinner();
          })
          .catch((error) => {
            Swal.fire({
              icon: "error",
              title: "error del servidor",
              text: "por favor recargue la pagina",
            });
          });
      } else {
        Swal.fire({
          icon: "error",
          title: "Datos incompletos",
          text: "El Ruc tiene que tener 11 digitos",
        });
      }
    },
  },
  mounted() {},
};
</script>