/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          50:"#eef9ff",100:"#dbf2ff",200:"#bfe6ff",300:"#94d6ff",
          400:"#5fc0ff",500:"#2aa7ff",600:"#1b90ef",700:"#1770be",800:"#155e9b",900:"#134f7f",
        },
      },
      boxShadow: { soft: "0 12px 30px rgba(42,167,255,.18)" },
      borderRadius: { "3xl":"1.5rem" },
      // ⬇️ Semua font disamakan: 'sans' & 'display' = default system UI
      fontFamily: {
        sans: [...defaultTheme.fontFamily.sans],
        display: [...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [require('@tailwindcss/forms')],
}
