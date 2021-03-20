const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.options({
	postCss: [
		require('autoprefixer')({
			browsers: ['last 40 versions'],
		})
	]
});
mix.js('resources/js/app.js', 'public/js/app.min.js');
mix.sass('resources/sass/app.scss', 'public/css/app.min.css', { implementation: require('node-sass') }).options({

	processCssUrls: false,
});
