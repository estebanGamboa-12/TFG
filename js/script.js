window.onload=function(){
    window.addEventListener("scroll",moverCaja);
    document.querySelector(".iniciarSesion").addEventListener("click",abrirVentanaSesion);
    document.querySelector(".cerrar").addEventListener("click",cerrarVentanaSesion);
}
function moverCaja(){
    let caja=document.querySelector(".aside2")
    let scrollTop=window.scrollY;//posicion scroll
    console.log(scrollTop);
    caja.style.top = `(${200+scrollTop}px`; // Mueve la caja con el scroll
}
function abrirVentanaSesion(){

    let modal=document.querySelector(".modalIniciarSesion");
    modal.style.display="flex";
}
function cerrarVentanaSesion(){
    let modal=document.querySelector(".modalIniciarSesion");
    modal.style.display="none";
}