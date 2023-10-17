<template>


    <div class="section-body">
        <div class="card">
            <form id="form_importar_proveedores" method="POST" action="#" enctype="multipart/form-data">

                <div id="app">

                    <div class="card text-left">
                        <div class="card-body">
                            <div class="section-header">
                                <h1>Importar los Proveedores</h1>
                            </div>
                           
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="prod_precio_venta">Seleccione un archivo excel</label>
                                    <div>
                                        <input type="file" name="images[]" style="display: none;" id="images"
                                            ref="fileInput" @change="handleFileChange" multiple />
                                        <div ref="uppyContainer"></div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" id="crear_cliente" class="btn btn-danger boton-color">Importar excel</button>
                    </div>

                </div>

            </form>
        </div>
    </div>
</template>

<script>
    import Uppy from '@uppy/core';
    import Webcam from '@uppy/webcam';
    import Dashboard from '@uppy/dashboard';
    import es from '@uppy/locales/src/es_ES';
    import ImageEditor from '@uppy/image-editor';
    import '@uppy/image-editor/dist/style.min.css';
    import XHRUpload from '@uppy/xhr-upload'; 
    import $ from "jquery";
    import "jquery-validation";
    import "jquery-validation/dist/localization/messages_es"
   


    export default {
        data() {
            return { 
            }
        },
        mounted() {

            // Initialize Uppy with desired options
            this.uppy = new Uppy({
                    debug: true,
                    locale: es,
                    autoProceed: false,

                    restrictions: {
                        allowedFileTypes: ['.xlsx', '.xls'],
                        maxFileSize: 5242880,
                        maxNumberOfFiles: 1
                    },
                })
                .use(Dashboard, {
                    target: this.$refs.uppyContainer,
                    inline: true,
                    width: '100%',
                    proudlyDisplayPoweredByUppy: false,
                    hideUploadButton: true,
                }).use(Webcam, {
                    target: Dashboard
                })
                .use(ImageEditor, {
                    target: Dashboard
                })
                .use(XHRUpload, {
                    endpoint: '/importar_proveedores', // Ruta de la API en Laravel que manejará la carga de archivos
                    formData: true,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content') // from <meta name="csrf-token" content="{{ csrf_token() }}">
                    } // Habilitar el envío de datos adicionales como FormData
                });


            // Handle file upload completion
            this.uppy.on('complete', (result) => {
                console.log('Upload complete:', result.successful);
            });
            uppy.on('error', (error) => {
                console.error('Error de Uppy:', error);
                // Puedes realizar acciones específicas en respuesta al error aquí
            });
            this.uppy.on('file-added', (file) => {
                console.log(this.uppy)
            });

            uppy.on('complete', (result) => {
                console.log(result)
                console.log('Todas las cargas han finalizado:');
                console.log('Archivos cargados con éxito:', result.successful);
                console.log('Archivos con errores:', result.failed);
            });

            uppy.on('upload-success', (file, response) => {
                console.log('Carga exitosa de:', file.name);
                console.log('Respuesta del servidor:', response);
            });


            $("#form_importar_proveedores").validate({
                rules: {
                    images: {
                        required: true,
                    }
                },
                submitHandler: function(form) {
 
                    uppy.upload();

                    return false;
                }
            });
        },
        methods: {
            handleFileChange() {
                const files = this.$refs.fileInput.files; 
                this.uppy.addFile({
                    source: 'file input',
                    name: files[0].name,
                    type: files[0].type,
                    data: files[0],
                });
            },
        },
    };
</script>
