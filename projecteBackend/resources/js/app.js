import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

window.Echo.channel('ConectaSalud')
    .listen('.LlamadaActualizada', (e) => {
      console.log('Llamada actualizada', e)
      let message = '';
      if(e.call){
        message = `Llamada ${e.call.id} actualizada. Realizada en ${e.call.dateTime}`
      } 

      if(e.patient){
        message = `Paciente ${e.patient.id} actualizado: ${e.patient.name}`
      }

      if(e.alert){
        message = `Alerta ${e.alert.id} actualizada: ${e.alert.status}`
      }

      console.log(message)

    });
    console.log('Escuchando mensajes')

