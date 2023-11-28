<template>


    <div class="section-body">
        <div class="card">
            <form id="form_crear_producto" method="POST" action="#" enctype="multipart/form-data">

                <div id="app">

                    <div class="card text-left">
                        <div class="card-body">
                            <div class="section-header">
                                <h1>Crear Producto</h1>
                            </div>
                            <h2 class="section-title">Informacion</h2>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="prod_nombre">Nombre Producto</label>
                                    <input type="text" class="form-control" name="prod_nombre" id="prod_nombre">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="prod_nombre_secundario">Nombre Secundario</label>
                                    <input type="text" class="form-control" name="prod_nombre_secundario"
                                        id="prod_nombre_secundario">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="prod_codigo">Codigo</label>
                                    <input type="text" class="form-control" name="prod_codigo" id="prod_codigo">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="prod_descripcion">Descripcion Producto</label>
                                    <input type="text" class="form-control" name="prod_descripcion"
                                        id="prod_descripcion">
                                </div>
                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label for="prod_codigo">Marca de producto</label>
                                    <div class="input-group">
                                        <search-marca-producto></search-marca-producto>

                                        <crear-marca-producto
                                            select_element="#marca_select_producto"></crear-marca-producto>

                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="prod_codigo">Zona</label>
                                    <div class="input-group">
                                        <search-zona></search-zona>

                                        <crear-zona select_element="#select_zona"></crear-zona>

                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="prod_codigo">Unidades</label>
                                    <div class="input-group">
                                        <search-unidades></search-unidades>

                                        <crear-unidades select_element="#select_unidades"></crear-unidades>

                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="prod_codigo">Categoria</label>
                                    <div class="input-group">

                                        <search-categoria-producto></search-categoria-producto>
                                        <crear-categoria-producto
                                            select_element="#select_categoria_producto"></crear-categoria-producto>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-12">
                                    <label>Seleccionar modelos de motos</label>
                                    <p>Selecciona los modelos en donde el producto funciona</p>

                                    <seleccionar-marcas :modelos="modelos"></seleccionar-marcas>
                                </div>



                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="prod_precio_venta">Precio unitario</label>
                                    <input type="number" class="form-control" name="prod_precio_venta"
                                        id="prod_precio_venta">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="prod_stock_inicial">Stock Inicial </label>
                                    <input type="number" class="form-control" name="prod_stock_inicial"
                                        id="prod_stock_inicial">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="prod_minimo">Stock Minimo </label>
                                    <input type="number" class="form-control" name="prod_minimo" id="prod_minimo">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="form-label">Calidad</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="prod_calidad" value="O"
                                                class="selectgroup-input" checked="">
                                            <span class="selectgroup-button">Original</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="prod_calidad" value="A"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">Alternativo</span>
                                        </label>

                                    </div>
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="prod_precio_venta">Imagen para el producto</label>
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
                        <button type="submit" id="crear_cliente" class="btn btn-danger boton-color">Crear
                            Producto</button>
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
    import Swal from "sweetalert2";
    import axios from "axios";
    import $ from "jquery";
    import "jquery-validation";
    import "jquery-validation/dist/localization/messages_es"



    export default {
        data() {
            return {
                modelos: JSON.parse(this.$attrs.modelos),
            }
        },
        mounted() {
         
            // Initialize Uppy with desired options
            this.uppy = new Uppy({
                    debug: true,
                    locale: es,
                    autoProceed: false, 
                    restrictions: {
                        allowedFileTypes: ['image/*'],
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
                    endpoint: '/crear_producto', // Ruta de la API en Laravel que manejará la carga de archivos
                    formData: true,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content') // from <meta name="csrf-token" content="{{ csrf_token() }}">
                    } // Habilitar el envío de datos adicionales como FormData
                });


            // Handle file upload completion
            this.uppy.on('complete', (result) => {
                console.log(result.successful[0].response.body);

                if (result.successful[0].response.body.success) {
                    window.location.href = result.successful[0].response.body.data;
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Error al registrar el producto, intentelo otra vez',
                        showConfirmButton: false,
                        timer: 3000
                    })
                }

            });
            uppy.on('error', (error) => {
                console.error('Error de Uppy:', error);
                // Puedes realizar acciones específicas en respuesta al error aquí
            });
            this.uppy.on('file-added', (file) => {
                console.log(this.uppy)
            });

            uppy.on('complete', (result) => {
                console.log('Todas las cargas han finalizado:');
                console.log('Archivos cargados con éxito:', result.successful);
                console.log('Archivos con errores:', result.failed);
            });

            uppy.on('upload-success', (file, response) => {
                console.log('Carga exitosa de:', file.name);
                console.log('Respuesta del servidor:', response);
            });


            $("#form_crear_producto").validate({
                rules: {
                    unidades_id: {
                        required: true,
                    },
                    prod_nombre:{
                        required: true,
                        maxlength: 249
                    },marca_prod_id: {
                        required: true,
                    },
                    zona_id: {
                        required: true,
                    },
                    unidades_id: {
                        required: true,
                    },
                    categoria_id: {
                        required: true,
                    },
                    prod_precio_venta:{
                        required:true
                    },
                    prod_stock_inicial:{
                        required:true
                    },
                    prod_minimo:{
                        required:true
                    }
                    
                },
                submitHandler: function(form) {

                    try {
                         
                         const fileUploadForm = document.getElementById('form_crear_producto');
                         const formData = new FormData(fileUploadForm);
                         uppy.getFiles().forEach((file) => {
                             formData.append('files[]', file.data);
                         });
 
                         const headers = {
                             "Content-Type": "application/json",
                         };
                         const data = formData;
                         axios
                             .post("/crear_producto", data,{
                                 headers,
                             })
                             .then((response) => {
                                 console.log(response.data);
                                 console.log(response.data)
                                 if (response.data.success) {
 
                                     window.location.href = response.data.data;
 
                                 } else {
                                     Swal.fire({
                                         position: 'center',
                                         icon: 'error',
                                         title: 'Error al registrar el producto, intentelo otra vez',
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
