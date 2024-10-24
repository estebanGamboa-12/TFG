window.onload=function(){
    //document.querySelector(".iniciarSesion").addEventListener("click",abrirVentanaSesion);
    //document.querySelector(".cerrar").addEventListener("click",cerrarVentanaSesion);
    document.querySelector(".bars").addEventListener("click",mostrarAside);
    document.addEventListener("click",cerrarAsideFuera);
    document.querySelector(".popular").addEventListener("click", mostrarPostAleatorios);
    document.getElementById("editor").addEventListener("input", marked);
        const markdownText = this.value;
        const htmlText = marked(markdownText); // Usa la librería marked.js
        document.getElementById("preview").innerHTML = htmlText;
    
}
function marked(){
    const markdownText = this.value;
    const htmlText = marked(markdownText); // Usa la librería marked.js
    document.getElementById("preview").innerHTML = htmlText;
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
    aside.style.display="flex";
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
function mostrarPostAleatorios() {
    fetch('http://localhost/proyectos/TFG/app/controladores/ControllerPost.php') //ruta 
        .then(response => {
            console.log(response);
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json(); 
        })
        .then(data => {
           mostrarPosts(data);
        })
        .catch(error=>{
            console.error("Error :" ,error);   
        });
}

function mostrarPosts(posts){
    const section=document.querySelector(".section");
    console.log(posts)
    section.innerHTML="";
    posts.forEach(post => {
        const card=`
         <div class="card-section">
                    <div class="encabezado-section">
                        <img src="../../public/img/${post.imagen}" alt="" class="imagenLogo-section">
                        <div class="nombre-section">${post.nombre}</div>
                        <div class="fecha-section">${post.fecha_creacion}</div>
                        <div class="unirseBoton-section">Unirse</div>
                    </div>
                    <div class="section-card">
                        <div class="titulo-section">${post.titulo}</div>
                        <div class="contenido-section"> ${post.contenido}</div>
                        <div class="videos-fotos-section">
                            <img src="../../public/img/${post.imagen}" alt="imagen" class="imagen-section">
                        </div>
                    </div>
                    <div class="pie-section">
                        <div class="votos-seccion">votos</div>
                        <div class="comentarios-section">Comentarios</div>
                        <div class="compartir-section">Compartir</div>
                    </div>
                </div>`;
                section.innerHTML+=card;
    });

}


