

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import 'preline';

// Force Preline auto-init to bind components (like accordions and overlays)
document.addEventListener('DOMContentLoaded', () => {
    if (window.HSStaticMethods) {
        window.HSStaticMethods.autoInit();
    }
});
if (document.readyState === 'interactive' || document.readyState === 'complete') {
    if (window.HSStaticMethods) {
        window.HSStaticMethods.autoInit();
    }
}

