/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        'atlas-teal': '#0d7a70', // The exact teal from your button
      },
    },
  },
  plugins: [],
}