window.onload=function(){
    document.querySelector(".iniciarSesion").addEventListener("click",abrirVentanaSesion);
    document.querySelector(".cerrar").addEventListener("click",cerrarVentanaSesion);
    document.querySelector(".botonIniciarSesion").addEventListener("click",ventanaLogin);
}
 
function abrirVentanaSesion(){

    let modal=document.querySelector(".modalIniciarSesion");
    modal.style.display="flex";
}
function cerrarVentanaSesion(){
    let modal=document.querySelector(".modalIniciarSesion");
    modal.style.display="none";
}

function ventanaLogin(){

}