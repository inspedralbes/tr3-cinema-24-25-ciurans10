# Usar una imagen base oficial de Node.js
FROM node:20

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /usr/src/app

# Copiar los archivos del proyecto al contenedor
COPY package*.json ./
COPY . .

# Instalar las dependencias
RUN npm install

# Exponer el puerto donde corre la aplicación (ajusta según sea necesario)
EXPOSE 3000

# Comando para iniciar el servicio Node.js
CMD ["npm", "start"]
