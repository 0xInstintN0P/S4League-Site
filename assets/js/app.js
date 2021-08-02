const register = document.querySelector("#register");
const formRegistrar = document.querySelector(".registrar-usuario");

document.addEventListener("DOMContentLoaded", () => {
    init();
});

function init() {
    validateSuccessCreate();
    validateCreate();
}

function validateSuccessCreate() {
    if(register) {
        localStorage.removeItem("register");
        mostrarAlerta("The user has been created successfully.");
    }
}

function validateCreate() {
    const inpHidden = document.querySelector("#change");
    if(inpHidden) {
        mostrarAlerta("The password has been changed successfully.");
    }
}

function mostrarAlerta(mensage) {
    const mensajeDiv = document.createElement("div");
    mensajeDiv.textContent = mensage;
    mensajeDiv.classList.add("alerta", "success");

    document.querySelector("body").appendChild(mensajeDiv);

    setTimeout(() => {
        mensajeDiv.classList.add("hide-alert");
        setTimeout(() => mensajeDiv.remove(), 1000);
    }, 3000);
}