$.validator.setDefaults({
    highlight: function (element) {
        $(element)
            .closest(".form-control")
            .addClass("is-invalid")
    },
    unhighlight: function (element) {
        $(element)
            .closest(".form-control")
            .removeClass("is-invalid")
            .addClass("is-valid")
    }
})
/* -- ******** funcion para buscar en la tabla por columna selecionada ************* -- */

var search_input_by_column = function () {
    this.api()
        .columns()
        .every(function () {
            let column = this;
            let title = column.footer().textContent;

            // Create input element
            let input = document.createElement('input');
            input.setAttribute('class', 'form-control');
            column.footer().replaceChildren(input);

            // Event listener for user input
            input.addEventListener('keyup', () => {
                if (column.search() !== this.value) {
                    column.search(input.value).draw();
                }
            });
        });
}

/* -- *********************** -- */