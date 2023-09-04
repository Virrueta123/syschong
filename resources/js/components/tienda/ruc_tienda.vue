<template>
    <div class="">
      <h2 class="section-title">Buscando ruc</h2>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputEmail4">Ruc</label>
          <div class="input-group">
            <input
              v-model="tienda_ruc"
              type="text"
              name="tienda_ruc"
              class="form-control"
              id="tienda_ruc"
              placeholder=""
              aria-label=""
            />
            <div class="input-group-append">
              <button
                class="btn btn-danger boton-color"
                type="button"
                v-on:click="buscar_ruc"
              >
                <i class="fa fa-search" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="form-group col-md-6">
          <label for="inputEmail4">Razon social</label>
          <input
            v-model="tienda_razon"
            type="text"
            class="form-control"
            name="tienda_razon"
            id="tienda_razon"
            placeholder="Nombre"
          />
        </div>
      </div>
  
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="inputEmail4">Direccion</label>
          <input
            v-model="tienda_direccion"
            type="text"
            class="form-control"
            name="tienda_direccion"
            id="tienda_direccion"
            placeholder="Direccion"
          />
        </div>
      </div>
  
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="inputEmail4">Departamento</label>
          <input
            v-model="tienda_departamento"
            type="text"
            class="form-control"
            name="tienda_departamento"
            id="tienda_departamento"
            placeholder="Departamento"
          />
        </div>
        <div class="form-group col-md-4">
          <label for="inputEmail4">Provincia</label>
          <input
            v-model="tienda_provincia"
            type="text"
            class="form-control"
            name="tienda_provincia"
            id="tienda_provincia"
            placeholder="Provincia"
          />
        </div>
        <div class="form-group col-md-4">
          <label for="inputPassword4">Distrito</label>
          <input
            v-model="tienda_distrito"
            type="text"
            class="form-control"
            name="tienda_distrito"
            id="tienda_distrito"
            placeholder="Distrito"
          />
        </div>
      </div>
    </div>
  </template> 
    
    <script>
  import axios from "axios";
  import { myMixin } from "../../mixin.js";
  import Swal from "sweetalert2";
  
  export default {
    mixins: [myMixin],
    data() {
      return {
        tienda_ruc: this.$attrs.tienda_ruc,
        tienda_razon: this.$attrs.tienda_razon,
        cli_apellido: this.$attrs.cli_apellido,
        tienda_direccion: this.$attrs.tienda_direccion,
        tienda_departamento: this.$attrs.tienda_departamento,
        tienda_distrito: this.$attrs.tienda_distrito,
        tienda_provincia: this.$attrs.tienda_provincia,
      };
    },
    methods: {
      buscar_ruc() {
        const data = { ruc: this.tienda_ruc };
        console.log(this.tienda_ruc.length);
        if (this.tienda_ruc.length >= 11) {
          this.showLoadingSpinner();
          axios
            .post("/consulta_ruc_api", data)
            .then((response) => {
              console.log(response);
              if (response.data.success) {
                this.tienda_razon = response.data.data.nombre_o_razon_social;
  
                this.tienda_direccion = response.data.data.direccion;
                this.tienda_departamento = response.data.data.departamento;
                this.tienda_distrito = response.data.data.distrito;
                this.tienda_provincia = response.data.data.provincia;
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