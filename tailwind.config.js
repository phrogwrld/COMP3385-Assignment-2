/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./400007969/**/*.{html,js,php}"],
  theme: {
    screens: {
      sm: '650px',
      md: '868px',
      lg: '1024px',
    },
    extend: {
      colors: {
        // https://www.tints.dev/gray/20222D
        gray: {
          50: '#E7E8EE',
          100: '#CCCFDB',
          200: '#9A9EB7',
          300: '#686E92',
          400: '#44485F',
          500: '#20222D',
          600: '#191B24',
          700: '#13141B',
          800: '#0D0D12',
          900: '#060709',
          950: '#040406'
        }
      }
    },
  },
  plugins: [],
}

