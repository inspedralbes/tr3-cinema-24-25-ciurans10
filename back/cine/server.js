import dotenv from 'dotenv'; // Cargar variables de entorno desde .env
import express from 'express';
import nodemailer from 'nodemailer';
import cors from 'cors';

dotenv.config(); // Configurar dotenv

const app = express();
app.use(cors());
app.use(express.json());

const transporter = nodemailer.createTransport({
  host: process.env.MAIL_HOST, // smtp.gmail.com
  port: process.env.MAIL_PORT, // 587
  secure: false, // true para 465, false para otros puertos
  auth: {
    user: process.env.MAIL_USER, // Tu correo
    pass: process.env.MAIL_PASS, // Tu contraseña de aplicación
  },
});

// Función para enviar el correo
const enviarCorreo = (correoDestinatario, nombreUsuario, butaquesSeleccionades, precioTotal) => {
  // Validar que butaquesSeleccionades sea un array
  if (!Array.isArray(butaquesSeleccionades)) {
    console.error('Error: butaquesSeleccionades no es un array');
    return;
  }

  const mailOptions = {
    from: `"${process.env.MAIL_FROM_NAME}" <${process.env.MAIL_FROM_ADDRESS}>`, // Nombre y correo del remitente
    to: correoDestinatario, // Correo del destinatario (dinámico)
    subject: 'Confirmación de compra', // Asunto del correo
    text: `Hola ${nombreUsuario},\n\nGracias por tu compra. Aquí tienes los detalles:\n\nButaques seleccionades: ${butaquesSeleccionades.join(', ')}\nPreu total: ${precioTotal}€\n\n¡Disfruta de la película!`, // Cuerpo del correo
  };

  transporter.sendMail(mailOptions, (error, info) => {
    if (error) {
      console.error('Error al enviar el correo:', error);
    } else {
      console.log('Correo enviado:', info.response);
    }
  });
};

// Endpoint para enviar correo
app.post('/enviar-correo', (req, res) => {
  const { correoDestinatario, nombreUsuario, butaquesSeleccionades, precioTotal } = req.body;

  // Validar que todos los campos estén presentes
  if (!correoDestinatario || !nombreUsuario || !butaquesSeleccionades || !precioTotal) {
    return res.status(400).send('Faltan campos obligatorios en la solicitud.');
  }

  // Validar que butaquesSeleccionades sea un array
  if (!Array.isArray(butaquesSeleccionades)) {
    return res.status(400).send('butaquesSeleccionades debe ser un array.');
  }

  enviarCorreo(correoDestinatario, nombreUsuario, butaquesSeleccionades, precioTotal);

  res.status(200).send('Correo enviado correctamente');
});

const PORT = process.env.PORT || 3000; 
app.listen(PORT, () => {
  console.log(`Servidor corriendo en el puerto ${PORT}`);
});