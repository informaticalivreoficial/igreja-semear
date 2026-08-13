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
                forest: {
                    50: '#eef5ea',
                    100: '#d8e6d2',
                    200: '#b0c9a3',
                    300: '#7ba06d',
                    400: '#4f7a48',
                    500: '#3a5e36',
                    600: '#2d4a2a',
                    700: '#223820',
                    800: '#1a2e1a',
                    900: '#122112',
                },
                gold: {
                    50: '#fbf8ee',
                    100: '#f8f2de',
                    200: '#efe6c2',
                    300: '#e3d194',
                    400: '#d4ba66',
                    500: '#c4a84a',
                    600: '#b08c2e',
                    700: '#8c6e24',
                },
                paper: '#faf7f2',
            },
        },
    },

    plugins: [],
};
