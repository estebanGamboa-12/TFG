window.onload=function(){
    document.querySelector(".iniciarSesion").addEventListener("click",abrirVentanaSesion);
    document.querySelector(".cerrar").addEventListener("click",cerrarVentanaSesion);
    document.querySelector(".bars").addEventListener("click",mostrarAside);
    document.addEventListener("click",cerrarAsideFuera);
}
 
function abrirVentanaSesion(){

    let modal=document.querySelector(".modalIniciarSesion");
    modal.style.display="flex";
}
function cerrarVentanaSesion(){
    let modal=document.querySelector(".modalIniciarSesion");
    modal.style.display="none";
}
function mostrarAside(){
    let aside=document.querySelector('.contenido-aside');
    let section=document.querySelector("section");
    section.classList.add("fondo");
    aside.style.display="block";
}
function cerrarAsideFuera(event){
    let aside=document.querySelector('.contenido-aside');
    let bars=document.querySelector(".bars");
    let section=document.querySelector("section");

    if(!aside.contains(event.target) && !bars.contains(event.target)){
        aside.style.display="none";
        section.classList.remove("fondo");
    }
}

