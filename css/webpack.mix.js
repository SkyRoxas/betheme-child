let mix = require('laravel-mix');

mix.standaloneSass('scss/style.scss', 'css/')
   .browserSync({
     proxy: 'http://ms.roxas.tw/',
     files: "css/*.css"
   });
