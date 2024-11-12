window.onload = function () {
    document.querySelector(".iniciarSesion").addEventListener("click", abrirVentanaSesion);
    document.querySelector(".cerrar").addEventListener("click", cerrarVentanasModal1);
    document.querySelector(".cerrar").addEventListener("click", cerrarVentanaModal2);
    document.querySelector(".bars").addEventListener("click", mostrarAside);
    document.addEventListener("click", cerrarAsideFuera);
    document.querySelector(".botonRegistrarse").addEventListener("click", mostrarVentanaRegistrar);
    //document.querySelector(".popular").addEventListener("click", mostrarPostAleatorios);

}
function mostrarVentanaRegistrar() {
    let modalIniciarSesion = document.querySelector(".modalIniciarSesion");
    let modalRegistrar = document.querySelector(".modalRegistrar");
    modalIniciarSesion.style.display = "none";
    modalRegistrar.style.display = "flex";
}
function abrirVentanaSesion() {

    let modal = document.querySelector(".modalIniciarSesion");
    modal.style.display = "flex";
}
function cerrarVentanasModal1() {
    let modal = document.querySelector(".modalIniciarSesion");
    modal.style.display = "none";
}
function cerrarVentanaModal2() {
    let modal1 = document.querySelector(".modalRegistrar");
    modal1.style.display = "none";
}
function mostrarAside() {
    let aside = document.querySelector('.contenido-aside');
    let section = document.querySelector("section");
    section.classList.add("fondo");
    aside.style.display = "flex";
}
function cerrarAsideFuera(event) {
    let aside = document.querySelector('.contenido-aside');
    let bars = document.querySelector(".bars");
    let section = document.querySelector("section");

    if (!aside.contains(event.target) && !bars.contains(event.target)) {
        aside.style.display = "none";
        section.classList.remove("fondo");
    }
}



