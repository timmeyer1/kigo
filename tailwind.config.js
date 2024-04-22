/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        'logo': '#F0C777',
        'light_gray': '#E3E3E3'
      }
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

