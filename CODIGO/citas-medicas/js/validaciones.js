function validarFormulario() {
    const email = document.querySelector("input[name='email']");
    const password = document.querySelector("input[name='password']");
    if (email.value === "" || password.value === "") {
        alert("Todos los campos son obligatorios");
        return false;
    }
    return true;
}
