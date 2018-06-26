const { mix } = require('laravel-mix');

const CompressionPlugin = require('compression-webpack-plugin');

mix.webpackConfig({
  plugins: [
    // new LiveReloadPlugin(),
    // new webpack.ProvidePlugin({
    //   jQuery: 'jquery',
    // }),
    new CompressionPlugin({
      asset: "[path].gz[query]",
      algorithm: "gzip",
      test: /\.js$|\.css$|\.html$|\.svg$/,
      threshold: 10240,
      minRatio: 0.8
    })
  ],
});

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

mix.js('resources/assets/js/app.js', 'public/js')
	.sass('resources/assets/sass/app.scss', 'public/css')
	.scripts([
		'public/js/jquery.min.js',
		'public/js/jquery-ui.min.js',
		'public/js/bootstrap.min.js',
		'public/js/iscroll/iscroll-probe.js',
		'public/js/jquery.flexslider-min.js',
		'public/js/45fb30cf5a.js',
		'public/js/admin.js',
		'public/js/main.js',
		],
		'public/js/all.js'
	)
	.styles([
		'public/css/bootstrap.min.css',
		'public/css/fonts.css',
		'public/css/main.css',
		],
		'public/css/all.css'
	);