const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/resources/assets/js/app.js', 'js/cms.js')
    .sass(__dirname + '/resources/assets/sass/app.scss', 'css/cms.css');

if (mix.inProduction()) {
    mix.version();
}
