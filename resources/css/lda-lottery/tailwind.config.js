// Tailwind build for /lda-lottery-result only (17 Nov 2026). The site layout has no Tailwind, so:
//  - prefix 'tw-' + preflight off: nothing here can restyle the site header/footer
//  - important '#llr': utilities apply inside the page wrapper and beat the site's global element styles
// Rebuild after editing the view:
//   npx tailwindcss -c resources/css/lda-lottery/tailwind.config.js -i resources/css/lda-lottery/input.css -o public/css/lda-lottery.css --minify
module.exports = {
  content: ['./resources/views/pages/lda-lottery-result.blade.php'],
  prefix: 'tw-',
  important: '#llr',
  corePlugins: { preflight: false },
  theme: {
    extend: {
      colors: {
        navy: { DEFAULT: '#011f4b', 700: '#0b2d63' },
        brand: { teal: '#008080', tealdark: '#006b6b', orange: '#FF5C00' },
      },
      fontFamily: { sans: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
    },
  },
  plugins: [],
};
