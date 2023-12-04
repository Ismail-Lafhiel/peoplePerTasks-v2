/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html, php,js}", "./**/*.{html,php}"],
  darkMode: 'class',
  theme: {
    extend: {
      screens: {
        'tablet': '1360px',
        'smXl': '800px'
      },
      maxWidth: {
        '1/2': '50%',
      },
      fontFamily: {
        'inter': ['Inter', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
};
