import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// ── Axios setup (minimal, untuk X-CSRF-TOKEN) ────────────────
window.axios = {
    defaults: {
        headers: {
            common: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
            },
        },
    },
};

// ── Laravel Echo + Reverb ─────────────────────────────────────
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key:      import.meta.env.VITE_REVERB_APP_KEY,
    wsHost:   import.meta.env.VITE_REVERB_HOST   ?? window.location.hostname,
    wsPort:   import.meta.env.VITE_REVERB_PORT   ?? 8090,
    wssPort:  import.meta.env.VITE_REVERB_PORT   ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'http') === 'https',
    enabledTransports: ['ws', 'wss'],
    disableStats: true,
    logToConsole: false,
});
