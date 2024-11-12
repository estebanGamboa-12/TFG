window.onload = function () {
    document.querySelector(".opcion-text").addEventListener("click",mostrarText);
    document.querySelector(".opcion-imagen").addEventListener("click",mostrarImagen);
    document.querySelector(".opcion-link").addEventListener("click",mostrarLink);

    document.querySelector(".caja-texto").style.display="block";
    document.querySelector(".caja-imagen").style.display="none";
    document.querySelector(".caja-link").style.display="none";
}
function mostrarImagen(){
    document.querySelector(".caja-texto").style.display="none";
    document.querySelector(".caja-imagen").style.display="block";
    document.querySelector(".caja-link").style.display="none";
}
function mostrarLink(){
    document.querySelector(".caja-texto").style.display="none";
    document.querySelector(".caja-imagen").style.display="none";
    document.querySelector(".caja-link").style.display="block";
}
function mostrarText(){
    document.querySelector(".caja-texto").style.display="block";
    document.querySelector(".caja-imagen").style.display="none";
    document.querySelector(".caja-link").style.display="none";
}


