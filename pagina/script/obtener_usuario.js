// Función para obtener una cookie por su nombre
function getCookie(name) {
    const cookieArr = document.cookie.split(";");

    for (let i = 0; i < cookieArr.length; i++) {
        const cookiePair = cookieArr[i].split("=");
        
        if (name === cookiePair[0].trim()) {
            return decodeURIComponent(cookiePair[1]);
        }
    }

    return null;
}

// Función para eliminar una cookie por su nombre
function deleteCookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

// Obtener el nombre de usuario desde la cookie
const usuario = getCookie('usuario');

if (usuario) {
    const nav = document.querySelector('nav ul');
    
    // Crear y agregar el elemento para mostrar el usuario
    const usuarioElement = document.createElement('li');
    usuarioElement.innerHTML = `<a href="#" id="usuario">Usuario: ${usuario}</a>`;
    
    // Crear y agregar el elemento para cerrar sesión
    const logoutElement = document.createElement('li');
    logoutElement.innerHTML = `<a href="#" id="logout">Cerrar Sesión</a>`;
    logoutElement.addEventListener('click', () => {
        deleteCookie('usuario');
        window.location.href = '/pagina/html/login.html';
    });
    
    nav.appendChild(usuarioElement);
    nav.appendChild(logoutElement);
}
