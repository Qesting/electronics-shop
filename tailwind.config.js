/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            flexBasis: {
                '1/8': '12.5%'
            },
            backgroundImage: {
                'hero-pattern': 'url("https://mowic.pl/wp-content/uploads/2018/07/Mak%C5%82owicz-1024x691.jpg")'
            },
            colors: {
                current: 'currentColor'
            },
        },
    },
    plugins: [],
}

