<template>
  <div class="content">
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="inputEmail4">Dni</label>
        <div class="input-group mb-3">
          <input
            type="text"
            class="form-control"
            id="cli_dni"
            placeholder=""
            aria-label=""
          />
          <div class="input-group-append">
            <button class="btn btn-primary" type="button">
              <i class="fa fa-search" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="form-group col-md-4">
        <label for="inputEmail4">Nombre</label>
        <input
          type="email"
          class="form-control"
          name="cli_nombre"
          id="cli_nombre"
          placeholder="Nombre"
        />
      </div>
      <div class="form-group col-md-4">
        <label for="inputPassword4">Apellido</label>
        <input
          type="password"
          class="form-control"
          id="cli_apellido"
          name="cli_apellido"
          placeholder="Apellido"
        />
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="inputEmail4">Direccion</label>
        <input
          type="email"
          class="form-control"
          name="cli_direccion"
          id="cli_direccion"
          placeholder="Direccion"
        />
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="inputEmail4">Departamento</label>
        <input
          type="email"
          class="form-control"
          name="cli_departamento"
          id="cli_departamento"
          placeholder="Departamento"
        />
      </div>
      <div class="form-group col-md-4">
        <label for="inputEmail4">Provincia</label>
        <input
          type="email"
          class="form-control"
          name="cli_provincia"
          id="cli_provincia"
          placeholder="Provincia"
        />
      </div>
      <div class="form-group col-md-4">
        <label for="inputPassword4">Distrito</label>
        <input
          type="password"
          class="form-control"
          name="cli_distrito"
          id="cli_distrito"
          placeholder="Distrito"
        />
      </div>
    </div>
  </div>
</template> 
  
  <script>
export default {
  mounted() {
    console.log("Component mounted.");
  },
};
</script>