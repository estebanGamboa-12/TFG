window.onload=function(){
    document.querySelector(".bars").addEventListener("click",mostrarAside);
    document.addEventListener("click", cerrarAsideFuera);
}
function mostrarAside(){
    
    let aside= document.querySelector("aside");
    let section=document.querySelector("section");
    section.classList.add("fondo");
    aside.classList.add("mostrar");

}
function cerrarAsideFuera(event){

    let aside= document.querySelector("aside");
    let bars= document.querySelector(".bars");
    let section=document.querySelector("section");

    if(!aside.contains(event.target) && !bars.contains(event.target)){
        aside.classList.remove("mostrar");
        section.classList.remove("fondo");
    }

}