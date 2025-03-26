
class CommunicationManager {
    constructor(baseUrl = 'http://localhost:8000/api') {
      this.baseUrl = baseUrl;
    }
  
    async get(url, options = {}) {
      try {
        const response = await fetch(`${this.baseUrl}${url}`, {
          ...options,
          method: 'GET',
          headers: this._getHeaders(options.headers)
        });
        return this._handleResponse(response);
      } catch (error) {
        this._handleError(error);
        throw error;
      }
    }
  
    async post(url, data, options = {}) {
      try {
        const response = await fetch(`${this.baseUrl}${url}`, {
          ...options,
          method: 'POST',
          headers: this._getHeaders(options.headers),
          body: JSON.stringify(data)
        });
        return this._handleResponse(response);
      } catch (error) {
        this._handleError(error);
        throw error;
      }
    }
  
    _getHeaders(customHeaders = {}) {
      const token = localStorage.getItem('token');
      const defaultHeaders = {
        'Content-Type': 'application/json',
        ...(token && { 'Authorization': `Bearer ${token}` })
      };
      
      return { ...defaultHeaders, ...customHeaders };
    }
  
    async _handleResponse(response) {
      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(errorData.message || 'Error en la respuesta del servidor');
      }
      return response.json();
    }

    _handleError(error) {
      console.error('Error en la comunicación:', error);
      
    }
  
    async getButacasOcupadas() {
      return this.get('/butacas-ocupadas');
    }
  
    async verificarCompra(peliculaId, sessionTime) {
      return this.post('/verificar-compra', { peliculaId, sessionTime });
    }
  
    async guardarEntrada(entradaData) {
      return this.post('/entradas', entradaData);
    }
  
    async enviarCorreo(correoData) {
      
      try {
        const response = await fetch('http://localhost:3000/enviar-correo', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(correoData)
        });
        return this._handleResponse(response);
      } catch (error) {
        this._handleError(error);
        throw error;
      }
    }

    async getButacasOcupadasPorFecha(fecha) {
        return this.get(`/butacas-ocupadas?fecha=${fecha}`);
    }
    
    async getResumenRecaudacion(fecha) {
        return this.get(`/resumen-recaudacion?fecha=${fecha}`);
    }

    async getPeliculas() {
        return this.get('/peliculas');
    }

    async getPelicula(id) {
        return this.get(`/pelicula/${id}`);
    }

    async getUserInfo() {
        return this.get('/user');
    }
    
      async getUserTickets() {
        return this.get('/entradas');
    }
    
      async logoutUser() {
        return this.post('/logout', {});
    }
  }
  
  export const communicationManager = new CommunicationManager();