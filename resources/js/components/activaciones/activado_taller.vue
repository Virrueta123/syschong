<template>

    <div class="form-row">
        
        <div class="form-group col-md-6">
            <label class="form-label">ACTIVADO EN TALLER (SI/NO)</label>
            <div class="selectgroup w-100">
                <label class="selectgroup-item">
                    <input type="radio" v-model="activado_taller" name="activado_taller" value="A" class="selectgroup-input" checked="">
                    <span class="selectgroup-button">Si</span>
                </label>
                <label class="selectgroup-item">
                    <input type="radio" v-model="activado_taller" name="activado_taller" value="D" class="selectgroup-input">
                    <span class="selectgroup-button">No</span>
                </label>
            </div>
        </div>

        <div v-if="activado_taller=='D'" class="form-group col-md-6">
            <label for="start_cortesia">En que cortesia iniciara</label>
            <input type="number" class="form-control" name="start_cortesia" value="1" id="start_cortesia" max="5" min="1">
        </div>
    </div>

</template>

<script>
    import Swal from "sweetalert2";
    import $ from "jquery";
    import "select2";
    import {
        myMixin
    } from "../../mixin.js";

    export default {
        mixins: [myMixin],
        data(){
            return {
                activado_taller:"A"
            }
        },
        mounted() {
            
        },
    };
</script>
