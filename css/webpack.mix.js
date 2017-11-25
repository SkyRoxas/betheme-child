let mix = require('laravel-mix');

mix.standaloneSass('scss/style.scss', 'css/')
   .browserSync({
     proxy: 'http://ms.local.a-wei.tw/',
     files: "css/*.css"
   });
