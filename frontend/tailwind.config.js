/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './pages/**/*.{html,js}',
    './components/**/*.{html,js}',
  ],
  important:true,
  theme: {
    fontFamily:{
      body: ['"Poppins"','sans-serif'],
      sans: ['"Poppins"','sans-serif']
    },
    extend: {
      colors:{
        'dark':'#212529',
        'secondary':'#10d38d',
        'primary':'#1f2937'
      }
    },
  },
  plugins: [],
}

