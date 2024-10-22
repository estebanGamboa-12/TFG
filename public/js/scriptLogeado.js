window.onload=function(){
    document.querySelector(".bars").addEventListener("click",mostrarAside);
    document.addEventListener("click", cerrarAsideFuera);
    document.querySelector(".home").addEventListener("click",mostrarPostAleatorios);
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
function mostrarPostAleatorios(){
    fetch('http://localhost/proyectos/TFG/app/controladores/ControllerPost.php/mostrarPostAleatorios') //ruta para la funcion
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.text(); // Cambia a text() primero para verificar el contenido
    })
    .then(data => {
        if (!data) {
            console.error('Received empty response');
            return;
        }
        
        try {
            const jsonData = JSON.parse(data);
            console.log(jsonData);
            // Maneja los datos recibidos
        } catch (error) {
            console.error('JSON parsing error:', error);
            console.error('Received data:', data);
        }
    })

}
