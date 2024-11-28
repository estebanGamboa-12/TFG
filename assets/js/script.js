window.onload = function () {
    // Verificar si el elemento existe antes de añadir el evento
    const iniciarSesion = document.querySelector(".iniciarSesion");
    if (iniciarSesion) {
        iniciarSesion.addEventListener("click", abrirVentanaSesion);
    }

    const cerrar = document.querySelector(".cerrar");
    if (cerrar) {
        cerrar.addEventListener("click", cerrarVentanasModal1);
        cerrar.addEventListener("click", cerrarVentanaModal2);
    }

    const bars = document.querySelector(".bars");
    if (bars) {
        bars.addEventListener("click", mostrarAside);
    }

    document.addEventListener("click", cerrarAsideFuera);

    const botonRegistrarse = document.querySelector(".botonRegistrarse");
    if (botonRegistrarse) {
        botonRegistrarse.addEventListener("click", mostrarVentanaRegistrar);
    }

    document.querySelector('.section').addEventListener('click', function (event) {
        // ------------------UNIRSE-------------------------------
        if (event.target && event.target.classList.contains('unirse')) { // ------------------UNIRSE---------------------------------- 
            let token = event.target.getAttribute('data-token-unirse'); // Obtener token

            const url = `${parametersBaseUrl}Membresias/unirseComunidad`;

            if (token) {
                actualizarCamposGenericos(url, token);
            } else {
                alert('¡Algo salió mal! No se pudo procesar la solicitud.');
            }
            // ------------------VOTAR---------------------------------- 
        } else if (event.target && event.target.classList.contains('votar')) {  // ------------------VOTAR---------------------------------- 
            let token = event.target.getAttribute('data-token-votar'); // Obtener token

            const url = `${parametersBaseUrl}Votos/votar`;

            if (token) {
                actualizarCamposGenericos(url, token);
            } else {
                alert('¡Algo salió mal! No se pudo procesar la solicitud.');
            }
        };
    });
    const sectionElement = document.querySelector('section');
    sectionElement.addEventListener('scroll', function () {

        if (sectionElement.scrollTop + sectionElement.clientHeight >= sectionElement.scrollHeight - 100) {
            if (!loading) {
                loading = true;
                document.getElementById('loading').style.display = 'block'; // Mostrar el cargador
                loadMorePosts(pagina);
                pagina++;
            }
        }
    });

}
let loading = false;
let pagina = 2;
const parametersBaseUrl="http://localhost/proyectos/TFG/";
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

// ---------------------------------------------------------------------------------VISTA ALL

function actualizarCamposGenericos(url, token) {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            token: token,
        })
    })
        .then(response => response.text()) // Cambiar a .text() para ver lo que llega como respuesta
        .then(data => {
            try {
                console.log(data);

                let jsonData = JSON.parse(data); // Intentamos parsear la respuesta
                console.log(jsonData);
                document.querySelector('.contenidoMensajes').style.display = "flex";
                // Comprobamos la respuesta completa
                if (jsonData.success === true) {
                    let numeroVotos = document.querySelector(`[data-token-votar='${encodeURIComponent(token)}']`);//por los caracteres especiales del token
                    console.log(numeroVotos);
                    if (numeroVotos) {
                        numeroVotos.innerHTML = `votos(${jsonData.votos}) `;
                    } else {
                        console.error("no se encontro el boton numero de votos ");
                    }
                    //success
                    document.querySelector('.contenidoMensajes').innerHTML = jsonData.message;
                    document.querySelector('.contenidoMensajes').classList.add("verde");
                    setTimeout(() => {
                        document.querySelector('.contenidoMensajes').classList.remove("verde");
                        document.querySelector('.contenidoMensajes').style.display = "none";
                    }, 2000);
                } else {
                    //error
                    document.querySelector('.contenidoMensajes').innerHTML = jsonData.message;
                    document.querySelector('.contenidoMensajes').classList.add("rojo");
                    setTimeout(() => {
                        document.querySelector('.contenidoMensajes').classList.remove("rojo");
                        document.querySelector('.contenidoMensajes').style.display = "none";
                    }, 2000);

                }
            } catch (error) {
                alert('Error al procesar la respuesta del servidor.' + error);
            }
        })
        .catch(error => {
            console.error('Error en la solicitud fetch:', error);
        });
}


// Función para cargar más posts
function loadMorePosts(page) {

    fetch(`${parametersBaseUrl}Post/loadMorePostsAll`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            pagina: page
        })
    })
        .then(response => {
            // Verificar si la respuesta tiene el formato correcto
            if (!response.ok) {
                throw new Error('Respuesta del servidor no es exitosa. Estado: ' + response.status);
            }

            // Obtener la respuesta como texto para inspeccionarla
            return response.text(); // Usamos text en lugar de json para inspeccionar el contenido
        })
        .then(responseText => {
            try {
                //console.log('Respuesta del servidor:', responseText);
                const data = JSON.parse(responseText);
                if (data.success) {
                    appendPosts(data.posts, data.token);
                    loading = false; // Restablecer el estado de carga
                    document.getElementById('loading').style.display = 'none'; // Ocultar el cargador

                } else {
                    console.warn('No se encontraron más posts');
                    loading = false; // Restablecer el estado de carga incluso si no hay más posts
                    let loadingCaja = document.getElementById('loading');
                    loadingCaja.style.display = 'block';
                    loadingCaja.innerHTML = "NO SE ENCONTRARON MAS POSTS"


                }

            } catch (error) {
                console.error('Error al cargar los posts:', error);

                // Crear un mensaje detallado de error
                let errorMessage = 'Error al procesar la solicitud del servidor.';

                // Verificar si el error es una instancia de Error (se proporciona información adicional)
                if (error instanceof Error) {
                    errorMessage += '\nMensaje de Error: ' + error.message;
                    errorMessage += '\nStack Trace: ' + error.stack;
                } else {
                    // Si no es una instancia de Error (por ejemplo, el error no es un objeto de JavaScript)
                    errorMessage += '\nDetalles: ' + JSON.stringify(error, null, 2);
                }

                // Mostrar el error detallado en un alert
                alert(errorMessage);
            }

        })
        .catch(error => {
            console.error('Error al cargar los posts:', error);
            loading = false; // Restablecer el estado de carga en caso de error
            document.getElementById('loading').style.display = 'none'; // Ocultar el cargador
        });
}

function appendPosts(posts, tokens) {
    const Parameters = {
        BASE_URL: parametersBaseUrl
    };
    const container = document.querySelector('.section');
    posts.forEach(post => {
        const postElement = document.createElement('div');
        postElement.classList.add('card-section');
        postElement.innerHTML = `
<div class="encabezado-section">
    <img src="${post.tipo_post === 'normal' ? Parameters.BASE_URL + 'assets/img/' + post.imagen_logo_usuario : Parameters.BASE_URL + 'assets/img/' + post.image_comunidad}" 
        alt="imagen" class="imagenLogo-section">
    <div class="nombre-section">
        ${post.tipo_post === 'normal' ? 'n/' : 'c/'}${post.nombre}
    </div>
    <div class="fecha-section">${post.fecha_creacion}</div>
    ${post.esta_unido === 0 && post.tipo_post === 'comunidad' ? `
        <div class="unirseBoton-section unirse"
            data-token-unirse="${tokens[post.id_post]}">
            Unirse
        </div>
    ` : ''}
</div>
<div class="section-card">
    <div class="titulo-section">${post.titulo}</div>
    <div class="contenido-section">${post.contenido}</div>
    
    ${post.video ? `
        <div class="videos-fotos-section">
            <video class="video-section" controls>
                <source src="${Parameters.BASE_URL}assets/videos/${post.video}" type="video/mp4">
                Tu navegador no soporta la etiqueta de video.
            </video>
        </div>
    ` : ''}
    
    ${post.imagen ? `
        <div class="videos-fotos-section">
            <img src="${Parameters.BASE_URL}assets/img/${post.imagen}" alt="imagen" class="imagen-section">
        </div>
    ` : ''}
</div>
<div class="pie-section">
    <div class="votos-seccion votar" "
        data-token-votar="${tokens[post.id_post]}">
        Votos(${post.votos})
    </div>
    <div class="comentarios-section">Comentarios</div>
    <div class="compartir-section">Compartir</div>
</div>
`;
        container.appendChild(postElement);
    });
}


