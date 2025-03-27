# Usar una imagen base oficial de Node.js
FROM node:20 as build

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /usr/src/app

# Copiar los archivos del proyecto al contenedor
COPY package*.json ./

# Instalar las dependencias
RUN npm install

# Copiar el resto de los archivos del proyecto
COPY . .

# Construir la aplicación Vue
RUN npm run build

# Usar una imagen base de Nginx para servir la aplicación
FROM nginx:alpine

# Copiar los archivos construidos desde la etapa anterior a la carpeta donde Nginx los servirá
COPY --from=build /usr/src/app/dist /usr/share/nginx/html

# Exponer el puerto 80 (el que usa Nginx por defecto)
EXPOSE 80

# Comando por defecto para iniciar Nginx
CMD ["nginx", "-g", "daemon off;"]
