/**
 * Gulpfile for WordPress Zero Theme
 *
 * This file contains various Gulp tasks for processing CSS, Sass, images, scripts, and more.
 * It also includes tasks for watching file changes, serving with BrowserSync, and creating a ZIP package.
 *
 * @file gulpfile.babel.js
 * @version 1.0.0
 * @description Gulp tasks for WordPress Zero Theme
 *
 *
 * @example
 * // Example of resolve alias in webpack configuration
 * resolve: {
 *   alias: {
 *     '@components': path.resolve(__dirname, 'src/js/components/'),
 *     '@utils': path.resolve(__dirname, 'src/js/utils/')
 *   },
 *   extensions: ['.js', '.json'],
 * }
 *
 * @constant {boolean} PRODUCTION - Flag to determine if the build is for production
 * @constant {Array} devpatterns - Patterns for development environment
 * @constant {Array} prodpatterns - Patterns for production environment
 *
 * @function replace_main_style - Task to replace main style in PHP files
 * @function processcss - Task to process Tailwind CSS
 * @function styles - Task to process Sass styles
 * @function images - Task to process images
 * @function watching - Task to watch file changes
 * @function copy - Task to copy files to dist directory
 * @function pot - Task to generate WP POT file
 * @function clean - Task to clean dist directory
 * @function clear_cache - Task to clear cache
 * @function scriptsTask - Helper function to process scripts
 * @function scripts - Task to process scripts
 * @function serve - Task to initialize BrowserSync server
 * @function reload - Task to reload BrowserSync server
 * @function compress - Task to create ZIP package
 * @function dev - Task to run development build
 * @function build - Task to run production build
 *
 * @default dev
 */

import autoprefixer from 'autoprefixer';
import browserSync from 'browser-sync';
import cache from 'gulp-cache';
import cleanCss from 'gulp-clean-css';
import del from 'del';
import flatmap from 'gulp-flatmap';
import gulpif from 'gulp-if';
import imagemin from 'gulp-imagemin';
import importcss from 'gulp-cssimport';
import named from 'vinyl-named';
import path from 'path';
import postcss from 'gulp-postcss';
import rename from 'gulp-rename';
import replace from 'gulp-replace-task';
import sourcemaps from 'gulp-sourcemaps';
import tailwind from 'tailwindcss';
import webpack from 'webpack-stream';
import wpPot from 'gulp-wp-pot';
import yargs from 'yargs';
import zip from 'gulp-zip';
import info from './package.json';
import { src, dest, watch, series, parallel } from 'gulp';

const sass = require( 'gulp-sass' )( require( 'sass' ) );
require( 'dotenv' ).config();

const PRODUCTION = yargs.argv.prod;

const devpatterns = [
	{
		json: {
			THEME_NAME: `${ info.description } src`,
			THEME_VERSION: `${ info.version }`,
			THEME_TEXT_DOMAIN: process.env.TEXT_DOMAIN,
		},
	},
];

const prodpatterns = [
	{
		json: {
			THEME_NAME: `${ info.description }`,
			THEME_VERSION: `${ info.version }`,
			THEME_TEXT_DOMAIN: process.env.TEXT_DOMAIN,
		},
	},
];

export const replace_main_style = () => {
	return src( 'src/css/style.css' )
		.pipe( gulpif( ! PRODUCTION, replace( { patterns: devpatterns } ) ) )
		.pipe( gulpif( PRODUCTION, replace( { patterns: prodpatterns } ) ) )
		.pipe( dest( './' ) );
};

export const processcss = () => {
	return src( [ 'src/css/tailwind.css' ] )
		.pipe( postcss( [ tailwind( './tailwind.config.js' ), autoprefixer ] ) )
		.pipe( importcss() )
		.pipe( dest( './dist/css' ) )
		.pipe( server.stream() );
};

export const styles = () => {
	return src( [ 'src/scss/theme.scss' ] )
		.pipe( gulpif( ! PRODUCTION, sourcemaps.init() ) )
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe( gulpif( PRODUCTION, postcss( [ autoprefixer ] ) ) )
		.pipe( gulpif( PRODUCTION, cleanCss( { compatibility: 'ie8' } ) ) )
		.pipe( gulpif( ! PRODUCTION, sourcemaps.write() ) )
		.pipe( dest( './dist/css' ) )
		.pipe( server.stream() );
};

export const images = () => {
	return src( 'src/images/**/*.{jpg,jpeg,png,svg,gif}' )
		.pipe( gulpif( PRODUCTION, imagemin() ) )
		.pipe( dest( 'dist/images' ) );
};

export const watching = () => {
	watch( 'src/scss/**/*.scss', series( styles, reload ) );
	watch( 'src/js/**/*.js', series( scripts, processcss, reload ) );
	watch( 'src/css/style.css', replace_main_style );
	watch(
		[ '**/*.php', 'src/css/**/*.css', '!src/php/*.php' ],
		series( clear_cache, processcss, copy, reload )
	);
};

export const copy = () => {
	return src( [
		'src/**/*',
		'!src/{images,js,css,scss,php}',
		'!src/{images,js,css,scss,php}/**/*',
	] ).pipe( dest( 'dist' ) );
};

export const pot = () => {
	return src( [ '*.php', 'includes/**/*.php', 'core/**/*.php' ] )
		.pipe(
			wpPot( {
				domain: process.env.TEXT_DOMAIN,
				package: process.env.PACKAGE,
			} )
		)
		.pipe( dest( `languages/zero-theme.pot` ) );
};

export const clean = () => del( [ 'dist' ] );

export const clear_cache = ( done ) => {
	return cache.clearAll( done );
};

const scriptsTask = ( minified ) => {
	return src( 'src/js/**/*.js' ).pipe(
		flatmap( ( stream, file ) => {
			const relativePath = path.relative(
				path.join( file.cwd, 'src/js' ),
				file.path
			);
			const outputPath = path.join(
				'dist/js',
				path.dirname( relativePath )
			);

			return stream
				.pipe( named() )
				.pipe(
					webpack( {
						module: {
							rules: [
								{
									test: /\.js$/,
									use: {
										loader: 'babel-loader',
										options: {
											presets: [ '@babel/preset-env' ],
										},
									},
								},
							],
						},
						externals: {
							jquery: 'jQuery',
						},
						mode: minified ? 'production' : 'development',
						devtool: ! minified ? 'inline-source-map' : false,
						optimization: {
							minimize: minified,
						},
						output: {
							filename: minified ? '[name].min.js' : '[name].js',
						},
					} )
				)
				.pipe( dest( outputPath ) );
		} )
	);
};

export const scripts = () => {
	return Promise.all( [ scriptsTask( false ), scriptsTask( true ) ] );
};

const server = browserSync.create();
export const serve = ( done ) => {
	server.init( {
		proxy: {
			target: process.env.DOMAIN,
			proxyReq: [
				function ( proxyReq ) {
					proxyReq.setHeader( 'Access-Control-Allow-Origin', '*' );
				},
			],
		},
		https: {
			key: process.env.SSL_KEY_FILE,
			cert: process.env.SSL_CERT_FILE,
		},
	} );
	done();
};

export const reload = ( done ) => {
	server.reload();
	done();
};

export const compress = () => {
	return src( [
		'**/*',
		'!.idea{,/**}',
		'!.phpdoc{,/**}',
		'!.vscode{,/**}',
		'!node_modules{,/**}',
		'!src{,/**}',
		'!.babelrc',
		'!.env',
		'!.gitignore',
		'!.stylelintrc',
		'!.eslintrc',
		'!.editorconfig',
		'!.prettierrc',
		'!.nvmrc',
		'!gulpfile.babel.js',
		'!package.json',
		'!package-lock.json',
		'!dist/js/dev.js',
		'!composer.json',
		'!composer.lock',
		'!plugin.code-workspace',
		'!theme.code-workspace',
		'!workspace.code-workspace',
	] )
		.pipe(
			rename( function ( filePath ) {
				filePath.dirname = `${ info.name }/${ filePath.dirname }`;
			} )
		)
		.pipe( zip( `${ info.name }-${ info.version }.zip` ) )
		.pipe( dest( '../' ) );
};

export const dev = series(
	clean,
	parallel( styles, images, copy, scripts, replace_main_style ),
	processcss,
	serve,
	watching
);

export const build = series(
	clean,
	parallel( styles, images, copy, scripts, replace_main_style ),
	processcss,
	pot
);

export default dev;
