<template>
    <div class="form-group col-sm-6">

        <div class="row">
            <div class="col-sm-4 d-flex justify-content-center align-items-center">

                <button v-on:click="mitad()" type="button" name="" id="" class="btn btn-primary boton-color">
                    50%
                </button>

            </div>
            <div class="col-sm-4 ">
                <h4 class="mt-2 text-center">{{ gasolina }}%</h4>

            </div>

            <div class="col-sm-4 d-flex justify-content-center align-items-center">
                <button  v-on:click="lleno()" type="button"  id="" class="btn btn-primary boton-color">
                    100%
                </button>
            </div>
        </div>
        <hr>
        <div class="d-flex">
            <div class="p-1">
                E
            </div>
            <div class="p-1 range"><input v-on:change="change_gasolina($event)" ref="gasolina" id="gasolina"
                    type="range" name="inventario_moto_nivel_gasolina" min="0" max="100" :value="gasolina" step="10"> </div>
            <div class="p-1">
                F
            </div>
        </div>

    </div>

</template>

<script>
    import rangesliderJs from 'rangeslider-js'
    export default {

        data() {
            return {
                gasolina: 0
            }
        },
        methods: {
            change_gasolina(event) {
                this.gasolina = event.target.value;
            },
            mitad() {
                this.gasolina = 50;
            },
            lleno() {
                this.gasolina = 100;
            }
        },
        mounted() {

        }
    }
</script>
