const baseUrl = 'http://localhost:8000/api';
const nodeBaseUrl = 'http://localhost:3000';

// === FUNCIONES BASE ====================================
function getHeaders() {
  const token = localStorage.getItem('token');
  return {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    ...(token && { 'Authorization': `Bearer ${token}` })
  };
}


async function handleResponse(response) {
  if (!response.ok) {
    const errorData = await response.json().catch(() => ({}));
    throw new Error(errorData.message || 'Error en la respuesta del servidor');
  }
  return response.json();
}


export async function get(url, options = {}) {
  try {
    const response = await fetch(url.startsWith('http') ? url : `${baseUrl}${url}`, {
      ...options,
      method: 'GET',
      headers: getHeaders()
    });
    return await handleResponse(response);
  } catch (error) {
    console.error('Error en la petición GET:', error);
    throw error;
  }
}


// === FUNCIONES DEL CINE ================================
export async function getButacasOcupadas() {
  try {
    const response = await fetch(`${baseUrl}/butacas-ocupadas`, {
      method: 'GET',
      headers: getHeaders()
    });
    return await handleResponse(response);
  } catch (error) {
    console.error('Error en getButacasOcupadas:', error);
    throw error;
  }
}


export async function loginUser(credentials) {
  try {
    const response = await fetch(`${baseUrl}/login`, {
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify(credentials)
    });
    const data = await handleResponse(response);
    if (data.token) {
      localStorage.setItem('token', data.token);
    }
    return data;
  } catch (error) {
    console.error('Error en loginUser:', error);
    throw error;
  }
}


export async function registerUser(userData) {
  try {
    const response = await fetch(`${baseUrl}/register`, {
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify(userData)
    });
    return await handleResponse(response);
  } catch (error) {
    console.error('Error en registerUser:', error);
    throw error;
  }
}


export async function verificarCompra(peliculaId, sessionTime) {
  try {
    const response = await fetch(`${baseUrl}/verificar-compra`, {
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify({ peliculaId, sessionTime })
    });
    return await handleResponse(response);
  } catch (error) {
    console.error('Error en verificarCompra:', error);
    throw error;
  }
}


export async function guardarEntrada(entradaData) {
  try {
    const response = await fetch(`${baseUrl}/entradas`, {
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify(entradaData)
    });
    return await handleResponse(response);
  } catch (error) {
    console.error('Error en guardarEntrada:', error);
    throw error;
  }
}


export async function enviarCorreo(correoData) {
  try {
    const response = await fetch(`${nodeBaseUrl}/api/enviar-correo`, { // Usa nodeBaseUrl
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify(correoData)
    });
    return await handleResponse(response);
  } catch (error) {
    console.error('Error en enviarCorreo:', error);
    throw error;
  }
}

export async function getButacasOcupadasPorFecha(fecha) {
  try {
    const response = await fetch(`${baseUrl}/butacas-ocupadas?fecha=${fecha}`, {
      method: 'GET',
      headers: getHeaders()
    });
    return await handleResponse(response);
  } catch (error) {
    console.error('Error en getButacasOcupadasPorFecha:', error);
    throw error;
  }
}


export async function getResumenRecaudacion(fecha) {
  try {
    const response = await fetch(`${baseUrl}/resumen-recaudacion?fecha=${fecha}`, {
      method: 'GET',
      headers: getHeaders()
    });
    return await handleResponse(response);
  } catch (error) {
    console.error('Error en getResumenRecaudacion:', error);
    throw error;
  }
}


export async function getPeliculas() {
  try {
    const response = await fetch(`${baseUrl}/peliculas`, {
      method: 'GET',
      headers: getHeaders()
    });
    return await handleResponse(response);
  } catch (error) {
    console.error('Error en getPeliculas:', error);
    throw error;
  }
}


export async function getPelicula(id) {
  try {
    const response = await fetch(`${baseUrl}/pelicula/${id}`, {
      method: 'GET',
      headers: getHeaders()
    });
    return await handleResponse(response);
  } catch (error) {
    console.error('Error en getPelicula:', error);
    throw error;
  }
}


export async function getUserInfo() {
  try {
    const response = await fetch(`${baseUrl}/user`, {
      method: 'GET',
      headers: getHeaders()
    });
    return await handleResponse(response);
  } catch (error) {
    console.error('Error en getUserInfo:', error);
    throw error;
  }
}


export async function getUserTickets() {
  try {
    const response = await fetch(`${baseUrl}/entradas`, {
      method: 'GET',
      headers: getHeaders()
    });
    return await handleResponse(response);
  } catch (error) {
    console.error('Error en getUserTickets:', error);
    throw error;
  }
}


export async function logoutUser() {
  try {
    const response = await fetch(`${baseUrl}/logout`, {
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify({})
    });
    return await handleResponse(response);
  } catch (error) {
    console.error('Error en logoutUser:', error);
    throw error;
  }
}
