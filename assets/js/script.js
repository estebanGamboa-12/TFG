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
    const section = document.querySelector('.section');
    if (section) {
        section.addEventListener('click', function (event) {
            //----------------------------------------UNIRSE BOTON---------------------------------------------------------------------------------
            if (event.target && event.target.classList.contains('unirse')) {
                let token = event.target.getAttribute('data-token-unirse'); // Obtener token

                const url = `${parametersBaseUrl}Membresias/unirseComunidad`;

                if (token) {
                    actualizarCamposGenericos(url, token);
                } else {
                    // alert('¡Algo salió mal! No se pudo procesar la solicitud.');
                }
                //--------------------------------------------BOTON VOTAR-----------------------------------------------------------------------------
            } else if (event.target && event.target.classList.contains('votar')) {
                let token = event.target.getAttribute('data-token-votar'); // Obtener token

                const url = `${parametersBaseUrl}Votos/votar`;
                console.log("dio a votar");

                if (token) {
                    actualizarCamposGenericos(url, token);
                } else {
                    // alert('¡Algo salió mal! No se pudo procesar la solicitud.');
                }
                //--------------------------------------------click encima de una carta -----------------------------------------------------------------------------
            } else if (event.target.closest('.card-section')) {
                let card = event.target.closest(".card-section");
                let token = card.getAttribute("data-token-comentar");
                if (token) {
                    mostrarComentarios(token);
                } else {
                    // alert('¡Algo salió mal! No se pudo procesar la solicitud.');
                }
            }
        });
    }

    //---------------------------------------------------------- vista All---------------------------------------------------------------
    const sectionElementAll = document.querySelector('#sectionAll');
    if (sectionElementAll) {
        sectionElementAll.addEventListener('scroll', function () {

            if (sectionElementAll.scrollTop + sectionElementAll.clientHeight >= sectionElementAll.scrollHeight - 10) {
                if (!loading) {
                    loading = true;
                    let url = `${parametersBaseUrl}Post/loadMorePosts`;
                    document.getElementById('loading').style.display = 'flex'; // Mostrar el cargador
                    document.getElementById('loading').innerHTML = `
                    <div class="spinner"></div> 
                    CARGANDO...
                `;
                    setTimeout(function () {
                        loadMorePosts(url, pagina, "all");
                        pagina++;
                    }, 1000); // 2000 milisegundos = 2 segundos
                }
            }
        });
    }
    //-------------------------------------------------------------VISTA HOME------------------------------------------------------------
    const sectionElementHome = document.querySelector('#sectionHome');
    if (sectionElementHome) {
        sectionElementHome.addEventListener('scroll', function () {

            if (sectionElementHome.scrollTop + sectionElementHome.clientHeight >= sectionElementHome.scrollHeight - 10) {
                if (!loading) {
                    loading = true;
                    let url = `${parametersBaseUrl}Post/loadMorePosts`;
                    document.getElementById('loading').style.display = 'flex'; // Mostrar el cargador
                    document.getElementById('loading').innerHTML = `
    <div class="spinner"></div> 
    CARGANDO...
`;
                    setTimeout(function () {
                        loadMorePosts(url, pagina, "home");
                        pagina++;
                    }, 1000); // 2000 milisegundos = 2 segundos
                }
            }
        });
    }
    //-------------------------------------------------------------VISTA POPULAR------------------------------------------------------------
    const sectionElementPopular = document.querySelector('#sectionPopular');
    if (sectionElementPopular) {
        sectionElementPopular.addEventListener('scroll', function () {

            if (sectionElementPopular.scrollTop + sectionElementPopular.clientHeight >= sectionElementPopular.scrollHeight - 10) {
                if (!loading) {
                    loading = true;
                    let url = `${parametersBaseUrl}Post/loadMorePosts`;
                    document.getElementById('loading').style.display = 'flex'; // Mostrar el cargador
                    document.getElementById('loading').innerHTML = `
    <div class="spinner"></div> 
    CARGANDO...
`;
                    setTimeout(function () {
                        loadMorePosts(url, pagina, "popular");
                        pagina++; // Incrementar la página después de la carga
                    }, 1000); // 2000 milisegundos = 2 segundos
                }
            }
        });
    }
    //boton de votar en verPost
    const votar = document.querySelector(".votar");
    if (votar) {
        votar.addEventListener("click", (e) => {
            const token = e.target.getAttribute('data-token-votar');
            const url = `${parametersBaseUrl}Votos/votar`;
            console.log("dio a votar");
            if (token) {
                actualizarCamposGenericos(url, token);
            } else {
                alert('¡Algo salió mal! No se pudo procesar la solicitud.');
            }
        });
    }
}
let loading = false;
let pagina = 2;
const parametersBaseUrl = "http://192.168.3.210/proyectos/TFG/";

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

// ---------------------------------------------------------------------------------VISTAs

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
                //  console.log(data);
                let jsonData = JSON.parse(data); // Intentamos parsear la respuesta
                //console.log(jsonData);
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
                console.log(error);
                alert('Error al procesar la respuesta del servidor.' + error);
            }
        })
        .catch(error => {
            console.error('Error en la solicitud fetch:', error);
        });
}


// Función para cargar más posts
function loadMorePosts(url, page, campo) {

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            pagina: page,
            vista: campo
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
        postElement.setAttribute("data-token-comentar", tokens[post.id_post]);
        postElement.innerHTML = `
<div class="encabezado-section">
      <a href="${post.tipo_post === 'normal'
                ? Parameters.BASE_URL + 'Usuario/verUsuario?nombre=' + post.nombre
                : Parameters.BASE_URL + 'Comunidades/verComunidad?idComunidad=' + post.id_comunidad}">
        <img src="${post.tipo_post === 'normal'
                ? Parameters.BASE_URL + 'assets/img/' + post.imagen_logo_usuario
                : Parameters.BASE_URL + 'assets/img/' + post.image_comunidad}" 
            alt="imagen" class="imagenLogo-section">
    </a>
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

// -------------------------------------------------------Vervista comentarios
function mostrarComentarios(token) {
    fetch(parametersBaseUrl + "Post/verPostPorId", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ token: token })
    })
        .then(response => {
            if (!response.ok) { // Si el código de respuesta HTTP no es 200 (OK)
                return response.text().then(err => {
                    console.error("Error:", err);
                    throw new Error("Error al obtener los datos del servidor");
                });
            }
            return response.json(); // Solo parsear como JSON si la respuesta es correcta
        })
        .then(data => {
            console.log(data.post);
            if (data.success) {
                window.location.href = parametersBaseUrl + 'Post/verPostPorId?titulo=' + data.post.id_post;
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });

}




