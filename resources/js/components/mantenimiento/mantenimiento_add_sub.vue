<template>


    <div class="section-body">
        <div class="card">
            <form id="form_crear_mantenimiento" method="POST" action="#">

                <div class="card-header">
                    <h2 class="section-title">Formulario para crear un mantenimiento</h2>
                </div>
                <div class="card-body">

                    <div class="form-group col-md-12 p-0">
                        <label for="prod_codigo">Buscar la moto</label>
                        <div class="input-group">
                            <search-moto-modelo name="mtx_id"></search-moto-modelo>
                        </div>
                    </div>

                    <div class="form-group col-md-12 p-0">
                        <label for="prod_codigo">Buscar Mecanico</label>
                        <div class="input-group">
                            <search-mecanicos name="mecanico_id"></search-mecanicos>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="prod_codigo">Precio Mantenimiento</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        S/.
                                    </div>
                                </div>
                                <input-money name="precio" name_precio="precio"></input-money>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="prod_codigo">Precio Mantenimiento</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        Km
                                    </div>
                                </div>
                                <input name="km" type="number" class="form-control">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="prod_codigo">Aviso</label>
                            <div class="input-group-prepend">

                            </div>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <Checkbox name="is_aviso" v-on:click="is_aviso_change" id="is_aviso"
                                            v-model="is_aviso" :binary="true" />
                                    </span>
                                </div>
                                <p-inputnumber name="dias" :disabled="isDisabledDias" id="dias" v-model="dias"
                                    inputId="minmax-buttons" :useGrouping="false" showButtons :min="0"
                                    :max="1000" />
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Dias</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-header">
                        <h1>Inventario</h1>
                    </div>

                    <div class="form-row">
                        <mantenimientoAccesorios :accesorios="accesorios" @childEvent="add_accesorios">
                        </mantenimientoAccesorios>
                    </div>

                    <h2 class="section-title">Mas datos de la moto</h2>
                    <div class="form-row">
                        <gasolina_inventario></gasolina_inventario>
                    </div>

                    <h2 class="section-title">Condiciones</h2>
                    <div class="form-row">
                        <mantenimientoAutorizaciones @childAutorizacion="add_Autorizacion"
                            :autorizaciones="autorizaciones"></mantenimientoAutorizaciones>
                    </div>


                    <add-aceites></add-aceites>

                    <h2 class="section-title">Observaciones del cliente</h2>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="aut_nombre">(Fallas,Ruidos extraños, Etc.)</label>
                            <textarea class="form-control" name="inventario_moto_obs_cliente" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" id="crear_cliente" class="btn btn-danger boton-color">Crear
                        Mantenimiento</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import '@uppy/image-editor/dist/style.min.css';
    import Swal from "sweetalert2";
    import axios from "axios";
    import $ from "jquery";
    import "jquery-validation";
    import "jquery-validation/dist/localization/messages_es"

    import 'primevue/resources/themes/saga-blue/theme.css';

    import "primeicons/primeicons.css"
    import InputNumber from "primevue/inputnumber";
    import Checkbox from 'primevue/checkbox';

    import ChildComponent from '../mantenimiento/prueba.vue';
    import mantenimientoAccesorios from '../mantenimiento/mantenimiento_accesorios.vue';

    import mantenimientoAutorizaciones from './mantenimientoAutorizaciones.vue';

    export default {
        components: {
            "p-inputnumber": InputNumber,
            "Checkbox": Checkbox,
            ChildComponent,
            mantenimientoAccesorios,
            mantenimientoAutorizaciones
        },
        data() {
            return {
                is_aviso: false,
                disabled: 0,
                isDisabledDias: true,
                dias: 0,
                autorizaciones: this.$attrs.autorizaciones,
                accesorios: this.$attrs.accesorios,
                dataFromParent: 'Datos desde el padre',
                select_acesorios: [],
                select_autorizacion: []
            }
        },
        methods: {
            add_accesorios(data) {
                console.log(data)
                this.select_acesorios = data;
                console.log(this.select_acesorios)
            },
            add_Autorizacion(data) {
                this.select_autorizacion = data;
            },
            handleChildEvent(data) {
                // Manejar datos enviados desde el hijo
                console.log('Datos del hijo:', data);
            },

            is_aviso_change() {

                if (this.is_aviso) {
                    this.isDisabledDias = true;
                } else {
                    this.isDisabledDias = false;
                }
            }
        },
        mounted() {


            $("#form_crear_mantenimiento").validate({
                rules: {
                    mtx_id: {
                        required: true,
                    },
                    mecanico_id: {
                        required: true,
                    },
                    precio: {
                        required: true,
                    },
                    km: {
                        required: true,
                    },
                    inventario_moto_obs_cliente: {
                        required: true,
                    } 
                },
                submitHandler: function(form) {
                    var aceite_id = $("#aceite_id").val();

                    if (typeof aceite_id === 'undefined') {
                        Swal.fire("Inserte un aceite para continuar")
                    } else {
                        try {
                            const fileUploadForm = document.getElementById('form_crear_mantenimiento');
                            const formData = new FormData(fileUploadForm);

                            console.log(this.select_acesorios)

                            formData.append('is_aviso', this.is_aviso);
                            formData.append('dias', this.dias);
                            formData.append('aceite_id', $("#aceite_id").val());
                            formData.append('select_acesorios', JSON.stringify(this.select_acesorios));
                            formData.append('select_autorizacion', JSON.stringify(this
                            .select_autorizacion));

                            const headers = {
                                "Content-Type": "application/json",
                            };
                            const data = formData;
                            axios
                                .post("/create_vue_mantenimiento", data, {
                                    headers,
                                })
                                .then((response) => {


                                    if (response.data.success) {

                                        window.location.href = response.data.data;

                                    } else {
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'error',
                                            title: 'Error al registrar el mantenimiento, intentelo otra vez',
                                            showConfirmButton: false,
                                            timer: 3000
                                        })
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
                                });


                        } catch (error) {
                            console.log(error)
                        }
                    }



                    return false;
                }.bind(this)
            });
        }

    };
</script>
