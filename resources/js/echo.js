import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

const scheme = import.meta.env.VITE_PUSHER_SCHEME ?? 'https';
const host   = import.meta.env.VITE_PUSHER_HOST || window.location.hostname;
const port   = Number(import.meta.env.VITE_PUSHER_PORT || (scheme === 'https' ? 443 : 80));

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    forceTLS: scheme === 'https',
    wsHost: host,
    wsPort: port,
    wssPort: port,
    enabledTransports: ['ws', 'wss'],
});
