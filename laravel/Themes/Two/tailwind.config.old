// import preset from '../../../../../../vendor/filament/support/tailwind.config.preset'
const defaultTheme = require('tailwindcss/defaultTheme');


/** @type {import('tailwindcss').Config} */
module.exports = {
    // presets: [preset],
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/Filament/Blocks/*.php',
        './Resources/views/**/*.blade.php',
        '../../Modules/**/Filament/**/*.php',
        '../../Modules/Resources/views/**/*.blade.php',
        '../../resources/views/filament/**/*.blade.php',
        '../../vendor/filament/**/*.blade.php',
        '../../resources/views/**/*.blade.php',
        '../../storage/framework/views/*.php',
        '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],
    theme: {
        extend: {
            maxWidth: {
                'wide': '1200px',
                fontFamily: {
                    sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};
