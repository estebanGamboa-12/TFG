window.onload=function(){
    window.addEventListener("scroll",moverCaja);
}
function moverCaja(){
    let caja=document.querySelector(".aside2")
    let scrollTop=window.scrollY;//posicion scroll
    console.log(scrollTop);
    caja.style.top = `(${200+scrollTop}px`; // Mueve la caja con el scroll
}