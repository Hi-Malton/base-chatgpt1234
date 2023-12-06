const nodemailer = require('nodemailer');

const username = process.argv[2];
const email = process.argv[3];

// Configuración del transporte de nodemailer
const transporter = nodemailer.createTransport({
    service: 'Gmail',
    auth: {
        user: 'cleocmorcillon@gmail.com', // Tu dirección de correo electrónico de Gmail
        pass: 'gcau oxht eglf gngf' // Tu contraseña
    }
});

// Configuración del correo electrónico
const mailOptions = {
    from: 'cleocmorcillon@gmail.com', // Tu dirección de correo electrónico
    to: email, // La dirección de correo electrónico del usuario registrado
    subject: 'Restablecimiento de Contraseña',
    text: `Hola ${username},\n\nHas solicitado restablecer tu contraseña en nuestro foro. Puedes continuar con el proceso enlace proporcionado.`
    // Puedes agregar un enlace que lleve al usuario a una página donde puedan restablecer su contraseña
    // Ejemplo: `text: `Hola ${username},\n\nHas solicitado restablecer tu contraseña en nuestro foro. Puedes restablecerla [aquí](enlace-de-restablecimiento)`.`
};

// Envía el correo electrónico
transporter.sendMail(mailOptions, function (error, info) {
    if (error) {
        console.log('[ERROR] No se pudo enviar el correo electrónico de restablecimiento: ' + error);
        process.exit(1); // Termina con un código de error
    } else {
        console.log('Correo electrónico de restablecimiento enviado: ' + info.response);
        process.exit(0); // Termina con éxito
    }
});
