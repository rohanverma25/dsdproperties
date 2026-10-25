// const defaultTheme = require('tailwindcss/defaultTheme');

// /** @type {import('tailwindcss').Config} */
// module.exports = {
//     content: [
//         './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
//         './storage/framework/views/*.php',
//         './resources/views/**/*.blade.php',
//     ],

//     theme: {
//         extend: {
//             fontFamily: {
//                 sans: ['Figtree', ...defaultTheme.fontFamily.sans],
//             },
//         },
//     },

//     plugins: [require('@tailwindcss/forms')],
// };
/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    './resources/**/*.blade.php',
    // Some Tailwind classes are held in PHP, not Blade — WaLabel::COLOURS maps a
    // stored colour name to its chip classes. Without this they get purged.
    './app/**/*.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './resources/**/*.tsx',
    './resources/**/*.ts',
  ],
  theme: {
    extend: {
      colors: {
        brandTeal: '#05ede3',
        brandNavy: '#011f4b',
        brandOrange: '#FFA500',
        customTeal: '#05ede3',
       customPrimary:'#011f4b',
       customSecondary: 'orange',
      },
      borderRadius: { '2xl': '1rem' },
    },
  },
  plugins: [require('@tailwindcss/typography'), require('@tailwindcss/forms')],
};
