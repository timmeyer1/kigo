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
        'logo_hover': '#CAA867',
        'light_gray': '#E3E3E3',
        'btn_submit': '#0E9F6E',
        'btn_submit_hover': '#0B7A54'
      }
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
