window.onload=function(){
    document.querySelector(".iniciarSesion").addEventListener("click",abrirVentanaSesion);
    document.querySelector(".cerrar").addEventListener("click",cerrarVentanaSesion);
}
 
function abrirVentanaSesion(){

    let modal=document.querySelector(".modalIniciarSesion");
    modal.style.display="flex";
}
function cerrarVentanaSesion(){
    let modal=document.querySelector(".modalIniciarSesion");
    modal.style.display="none";
}

