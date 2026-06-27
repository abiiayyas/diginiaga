import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/preline/dist/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6', // Primary Blue
                    600: '#2563eb', // Hover
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                },
                surface: {
                    50: '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                }
            },
            boxShadow: {
                'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.07)',
            }
        },
    },

    plugins: [
        forms,
        function({ addVariant }) {
            addVariant('hs-accordion-active', ['&.active', '.active &']);
            addVariant('hs-overlay-open', ['&.open', '.open &']);
            addVariant('hs-dropdown-open', ['&.open', '.open &', '.hs-dropdown.open > &', '.hs-dropdown.open > .hs-dropdown-menu > &']);
        }
    ],
};


