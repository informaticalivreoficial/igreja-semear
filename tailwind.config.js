/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    50: '#F2FBF6',
                    100: '#DFF6E7',
                    200: '#BEECCF',
                    300: '#8DDFAE',
                    400: '#4FC87B',
                    500: '#00A650',
                    600: '#008A43',
                    700: '#006B34',
                    800: '#004E27',
                    900: '#00351B',
                },
            },
        },
    },

    plugins: [],
}