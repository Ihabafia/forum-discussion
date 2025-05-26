const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: ['./resources/**/*.blade.php', './resources/**/*.js', './resources/**/*.vue'],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                test: '#ff0a00',
            },
        },
    },
    safelist: ['prose', 'prose-sm'],
    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
