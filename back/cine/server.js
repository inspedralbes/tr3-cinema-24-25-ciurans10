
import dotenv from 'dotenv'; 
import express from 'express';
import nodemailer from 'nodemailer';
import cors from 'cors';
import { createServer } from 'http';
import { Server } from 'socket.io';

dotenv.config(); 

const app = express();
const server = createServer(app);
const io = new Server(server, {
  cors: {
    origin: '*',
  },
});

app.use(cors());
app.use(express.json());

const butacasSeleccionadasGlobal = new Map();

io.on('connection', (socket) => {
  console.log('Usuario conectado:', socket.id);

  socket.emit('butacas-actualizadas', Array.from(butacasSeleccionadasGlobal.entries()));

  socket.on('seleccionar-butaca', (butaca) => {
    if (!butacasSeleccionadasGlobal.has(butaca)) {
      butacasSeleccionadasGlobal.set(butaca, socket.id);
      io.emit('butacas-actualizadas', Array.from(butacasSeleccionadasGlobal.entries()));
      socket.emit('butaca-seleccionada', butaca); 
    } else {
      socket.emit('butaca-no-disponible', butaca); 
    }
  });

  socket.on('deseleccionar-butaca', (butaca) => {
    if (butacasSeleccionadasGlobal.get(butaca) === socket.id) {
      butacasSeleccionadasGlobal.delete(butaca);
      io.emit('butacas-actualizadas', Array.from(butacasSeleccionadasGlobal.entries()));
    }
  });

  socket.on('disconnect', () => {
    console.log('Usuario desconectado:', socket.id);

    for (const [butaca, usuario] of butacasSeleccionadasGlobal.entries()) {
      if (usuario === socket.id) {
        butacasSeleccionadasGlobal.delete(butaca);
      }
    }
    io.emit('butacas-actualizadas', Array.from(butacasSeleccionadasGlobal.entries()));
  });
});


const transporter = nodemailer.createTransport({
  host: process.env.MAIL_HOST, 
  port: process.env.MAIL_PORT, 
  secure: false, 
  auth: {
    user: process.env.MAIL_USER, 
    pass: process.env.MAIL_PASS, 
  },
});

const enviarCorreo = (correoDestinatario, nombreUsuario, butaquesSeleccionades, precioTotal) => {
  if (!Array.isArray(butaquesSeleccionades)) {
    console.error('Error: butaquesSeleccionades no es un array');
    return;
  }

  const mailOptions = {
    from: `"${process.env.MAIL_FROM_NAME}" <${process.env.MAIL_FROM_ADDRESS}>`, 
    to: correoDestinatario, 
    subject: 'Confirmación de compra', 
    text: `Hola ${nombreUsuario},\n\nGracias por tu compra. Aquí tienes los detalles:\n\nButaques seleccionades: ${butaquesSeleccionades.join(', ')}\nPreu total: ${precioTotal}€\n\n¡Disfruta de la película!`,
  };

  transporter.sendMail(mailOptions, (error, info) => {
    if (error) {
      console.error('Error al enviar el correo:', error);
    } else {
      console.log('Correo enviado:', info.response);
    }
  });
};

app.post('/enviar-correo', (req, res) => {
  const { correoDestinatario, nombreUsuario, butaquesSeleccionades, precioTotal } = req.body;

  if (!correoDestinatario || !nombreUsuario || !butaquesSeleccionades || !precioTotal) {
    return res.status(400).send('Faltan campos obligatorios en la solicitud.');
  }

  if (!Array.isArray(butaquesSeleccionades)) {
    return res.status(400).send('butaquesSeleccionades debe ser un array.');
  }

  enviarCorreo(correoDestinatario, nombreUsuario, butaquesSeleccionades, precioTotal);
  res.status(200).send('Correo enviado correctamente');
});

const PORT = process.env.PORT || 3000; 
server.listen(PORT, () => {
  console.log(`Servidor corriendo en el puerto ${PORT}`);
});
