//require('./bootstrap');   


import { createApp } from 'vue';

const app = createApp({});

app.component('input-money', require('./components/implementaciones/input_currency.vue').default);



app.component('example-component', require('./components/ExampleComponent.vue').default);

app.component('dni', require('./components/cliente/dni.vue').default);
app.component('ruc', require('./components/cliente/ruc.vue').default);

app.component('add-factura', require('./components/taller/add_factura_tienda.vue').default)

app.component('fecha-fabricacion', require('./components/complementos/fecha_fabricacion.vue').default)


/* -- ********  componentes tienda ************* -- */
app.component('ruc-tienda', require('./components/tienda/ruc_tienda.vue').default);
app.component('agregar-precios', require('./components/tienda/agregar_precio.vue').default);
app.component('search-tienda', require('./components/tienda/search_tienda.vue').default);
app.component('search-tienda-cobrar', require('./components/tienda/cobrar_tienda.vue').default);

/* -- *********************** -- */

app.component('search-cliente', require('./components/search_cliente.vue').default);
app.component('crear-cliente', require('./components/crear_cliente.vue').default)

app.component('asignar-cliente', require('./components/cliente/asignar_cliente_activacion.vue').default)
app.component('editar-cliente', require('./components/cliente/editar-cliente.vue').default)
app.component('editar-cliente-cortesia', require('./components/cliente/editar-cliente-cortesia.vue').default)

app.component('taller-show', require('./components/taller/taller_show.vue').default)



app.component('add-cortesia', require('./components/cortesia/add_cortesia.vue').default)

app.component('search-cliente_pos', require('./components/search_cliente_pos.vue').default);
app.component('crear-cliente_pos', require('./components/crear_cliente_pos.vue').default);


app.component('caja-show', require('./components/caja/show_caja.vue').default);


/* -- ******** cotizacion ************* -- */
app.component('cotizacion-cliente-show',require('./components/cotizacion/cotizacion_cliente_show.vue').default);
app.component('cotizacion-mantenimiento', require('./components/cotizacion/cotizacion_mantenimiento.vue').default);
app.component('cotizacion-table', require('./components/cotizacion/cotizacion_table.vue').default);
/* -- *********************** -- */

/* -- ******** cotizacion ************* -- */
app.component('calendar-view', require('./components/calendar/calendar_view.vue').default);
/* -- *********************** -- */

/* -- ******** maraca de las marca ************* -- */
app.component('search-marca', require('./components/marca/search_marca.vue').default);
app.component('crear-marca', require('./components/marca/crear_marca.vue').default);
app.component('seleccionar-marcas', require('./components/marca/seleccionar_marcas.vue').default);
/* -- *********************** -- */

/* -- ******** componetes para los proveedores ************* -- */
app.component('search-proveedor', require('./components/proveedores/search_proveedor.vue').default);
app.component('tipo-documento', require('./components/proveedores/tipo_documento.vue').default);
app.component('importar-proveedores', require('./components/proveedores/importar_proveedores.vue').default);
/* -- *********************** -- */


/* -- ******** componentes de los modelos ************* -- */
app.component('seleccionar-modelos', require('./components/modelo/seleccionar_modelos.vue').default);
/* -- *********************** -- */

/* -- ******** componentes del pos ************* -- */
app.component('pos-create', require('./components/pos/pos_create.vue').default);
/* -- *********************** -- */


/* -- ******** marca del producto ************* -- */
app.component('search-marca-producto', require('./components/marca_producto/search_marca_producto.vue').default);
app.component('crear-marca-producto', require('./components/marca_producto/crear-marca-producto.vue').default);
/* -- *********************** -- */

/* -- ********   vendedor ************* -- */
app.component('search-vendedor', require('./components/vendedor/search_vendedor.vue').default);
app.component('crear-vendedor', require('./components/vendedor/crear_vendedor.vue').default);
/* -- *********************** -- */


/* -- ******** componentes zona ************* -- */
app.component('search-zona', require('./components/zona/search_zona.vue').default);
app.component('crear-zona', require('./components/zona/crear-zona.vue').default);
/* -- *********************** -- */


/* -- ******** componentes unidades ************* -- */
app.component('search-unidades', require('./components/unidades/search_unidades.vue').default);
app.component('crear-unidades', require('./components/unidades/crear-unidades.vue').default);
/* -- *********************** -- */

/* -- ******** componentes productos ************* -- */
app.component('image-producto', require('./components/producto/image_producto.vue').default);
app.component('editar-producto', require('./components/producto/editar_producto.vue').default);
app.component('importar-productos', require('./components/producto/importar_productos.vue').default);
/* -- *********************** -- */

/* -- ******** componentes activaciones ************* -- */
app.component('activado-taller', require('./components/activaciones/activado_taller.vue').default);
app.component('importar-activaciones', require('./components/activaciones/importar_activaciones.vue').default);
/* -- *********************** -- */


/* -- ******** componentes servicios ************* -- */
app.component('servicios-add', require('./components/servicios/servicios_add.vue').default);
app.component('importar-servicios', require('./components/servicios/importar_servicios.vue').default);
app.component('servicios-seleccionados', require('./components/servicios/servicios_seleccionados.vue').default);
/* -- *********************** -- */

/* -- ******** componentes servicios ************* -- */

/* -- *********************** -- */

/* -- ******** componentes categoria producto ************* -- */
app.component('search-categoria-producto', require('./components/categoria_producto/search_categoria_producto.vue').default);
app.component('crear-categoria-producto', require('./components/categoria_producto/crear-categoria_producto.vue').default);
app.component('productos-seleccionados', require('./components/producto/productos_seleccionados.vue').default);
/* -- *********************** -- */

/* -- ******** mantenimiento ************* -- */
app.component('mantenimiento-add-sub', require('./components/mantenimiento/mantenimiento_add_sub.vue').default);
app.component('mantenimiento-add', require('./components/mantenimiento/mantenimiento_add.vue').default);
app.component('mantenimiento-accesorios', require('./components/mantenimiento/mantenimiento_accesorios.vue').default);
app.component('mantenimiento-autorizaciones', require('./components/mantenimiento/mantenimientoAutorizaciones.vue').default);

app.component('mantenimiento-autorizaciones-edit', require('./components/mantenimiento/autorizaciones_edit.vue').default);
app.component('mantenimiento-accesorios-edit', require('./components/mantenimiento/mantenimiento_accesorios_edit.vue').default);
/* -- ******** componentes mecanicos ************* -- */
app.component('search-mecanicos', require('./components/mecanicos/search_mecanicos.vue').default);
/* -- *********************** -- */

/* -- ******** crear gastos ************* -- */
app.component('crear-gastos', require('./components/gastos/crear_gastos.vue').default);
/* -- *********************** -- */


/* -- ******** modulos para comprar ************* -- */
app.component('create-compra', require('./components/compra/create_compra.vue').default);
app.component('editar-compra', require('./components/compra/editar_compra.vue').default);
app.component('search-respuestos', require('./components/compra/search_respuestos.vue').default);
/* -- *********************** -- */



app.component('search-moto', require('./components/moto/search_moto.vue').default);
app.component('search-moto-modelo', require('./components/moto/search_moto_modelo.vue').default);

//seleccionar aceites
app.component('seleccionar-aceites', require('./components/moto/seleccionar_aceites.vue').default);


app.component('add-aceites', require('./components/inventario_moto/aceite.vue').default);
app.component('accesorios_inventario', require('./components/inventario_moto/agregar_accesorios.vue').default);
app.component('gasolina_inventario', require('./components/inventario_moto/gasolina.vue').default);

app.component('autorizaciones', require('./components/inventario_moto/autorizaciones.vue').default);


/* -- ******** repuestos componentes ************* -- */

app.component('repuestos_add', require('./components/repuestos/add_repuesto.vue').default);
app.component('repuestos-edit', require('./components/repuestos/edit_repuestos.vue').default);

/* -- *********************** -- */

/* -- ******** todas las tablas ************* -- */
app.component('tablas-activaciones-anterior-por-tienda', require('./components/tablas/tablas_activaciones_anterior_por_tienda.vue').default);
app.component('tablas-activaciones-actual-por-tienda', require('./components/tablas/tablas_activaciones_actual_por_tienda.vue').default);
app.component('tablas-cortesias-actual-por-tienda', require('./components/tablas/tablas_cortesias_actual_por_tienda.vue').default);
app.component('tablas-factura-tienda', require('./components/tablas/tablas_factura_tienda.vue').default);
/* -- *********************** -- */

app.component('is-dias', require('./components/complementos/is_dias.vue').default);

/* -- ******** pdfs  ************* -- */

app.component('pdf-orden-servicio', require('./components/pdf/pdf-orden-servicio.vue').default);
/* -- *********************** -- */

/* -- ******** imagen ************* -- */
app.component('imagen-orden-de-servicio', require('./components/imagenes/imagen_orden_de_servicio.vue').default);
/* -- *********************** -- */
app.component('dashboard', require('./components/home/dashboard.vue').default);

app.mount('#app');

// Export the Vue app if necessary
export default app;




