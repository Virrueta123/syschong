<template>
    <div class="card ">
        <div class="card-header">
            <Button class="p-2" label="Activaciones" severity="danger"  />
            <hr>
            <Button class="p-2" label="Cortesias"  />
            <hr>
            <Button class="p-2" label="Inicio Mantenimiento" severity="secondary"  />
            <hr>
            <Button class="p-2" label="Mantenimientos" severity="success"  /> 
        </div>
        <div class="card-body">
            <FullCalendar :options="calendarOptions" />
        </div>
    </div>

</template>

<script>
    import Button from 'primevue/button';
    import FullCalendar from '@fullcalendar/vue3'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import interactionPlugin from '@fullcalendar/interaction'
    import 'moment/locale/es';
    import axios from 'axios';
    export default {
        components: {
            FullCalendar,
            Button // make the <FullCalendar> tag available
        },
        data() {
            return {
                calendarOptions: {
                    locale: 'es',
                    plugins: [dayGridPlugin, interactionPlugin],
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek,dayGridDay' // user can switch between the two
                    },
                    initialView: 'dayGridWeek',
                    navLinks: true
                }
            }
        },
        mounted() {
            const todayButton = document.querySelector('.fc-today-button');
            if (todayButton) {
                todayButton.style.backgroundColor =
                    'red'; // Cambia el color a azul (personaliza según tus necesidades)
                todayButton.style.color =
                    'white'; // Cambia el color del texto a blanco (personaliza según tus necesidades)
            }
            const headers = {
                "Content-Type": "application/json",
            };
            const data = {
                cotizacion_id: 2
            };
            axios
                .post("/calendario_cortesisas", data, {
                    headers,
                })
                .then((response) => {
                    console.log(response.data)
                    this.calendarOptions.events = response.data;


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
        },
        created() {


        }
    }
</script>

<style>

</style>
