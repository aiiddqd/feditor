import svelte from 'rollup-plugin-svelte';
import commonjs from '@rollup/plugin-commonjs';
import resolve from '@rollup/plugin-node-resolve';
import livereload from 'rollup-plugin-livereload';
import { terser } from 'rollup-plugin-terser';
import css from 'rollup-plugin-css-only';
import replace from '@rollup/plugin-replace';
import dotenv from 'dotenv';
// import scss from 'rollup-plugin-scss'
import sveltePreprocess from 'svelte-preprocess';
// import {preprocess, sveltePreprocess, scss } from 'svelte-preprocess';



const production = !process.env.ROLLUP_WATCH;

function serve() {
	let server;

	function toExit() {
		if (server) server.kill(0);
	}

	return {
		writeBundle() {
			if (server) return;
			server = require('child_process').spawn('npm', ['run', 'start', '--', '--dev'], {
				stdio: ['ignore', 'inherit', 'inherit'],
				shell: true
			});

			process.on('SIGTERM', toExit);
			process.on('exit', toExit);
		}
	};
}

dotenv.config();

export default {
	input: 'src/main.js',
	output: {
		sourcemap: true,
		format: 'iife',
		name: 'app',
		file: 'public/build/bundle.js'
	},
	plugins: [
		svelte({
			preprocess: sveltePreprocess(
				{
					scss: {
						// includePaths: ['scss'],
						// prependData: `
						// 	@import 'src/scss/style.scss';
						// `
					},
				    sourceMap: !production,
					postcss: {
						plugins: [require('autoprefixer')()]
					}
				}
			),

			compilerOptions: {
				// enable run-time checks when not in production
				dev: !production
			}
		}),


		replace({
			preventAssignment: true,
            // DEV_ENV_APP: JSON.stringify({
			// 	...dotenv.config().parsed
			// }),
            ENV_APP_USER_NAME: JSON.stringify(process.env.APP_DEV_USERNAME),
            ENV_APP_PASS: JSON.stringify(process.env.APP_DEV_PASS),
            APP_API_URL: JSON.stringify(process.env.APP_API_URL),
            APP_REST_URL: JSON.stringify(process.env.APP_REST_URL),
            APP_POST_ID: JSON.stringify(process.env.APP_POST_ID)
        }),
		// we'll extract any component CSS out into
		// a separate file - better for performance
		css({ output: 'bundle.css' }),
		// scss({ 
		// 	include: [
		// 		"./src/scss/style.scss"
		// 	],

		// 	output: 'public/build/shared.css' 
		// }),

		// If you have external dependencies installed from
		// npm, you'll most likely need these plugins. In
		// some cases you'll need additional configuration -
		// consult the documentation for details:
		// https://github.com/rollup/plugins/tree/master/packages/commonjs
		resolve({
			browser: true,
			dedupe: ['svelte']
		}),
		commonjs(),

		// In dev mode, call `npm run start` once
		// the bundle has been generated
		!production && serve(),

		// Watch the `public` directory and refresh the
		// browser on changes when not in production
		!production && livereload('public'),

		// If we're building for production (npm run build
		// instead of npm run dev), minify
		production && terser()
	],
	watch: {
		clearScreen: false
	}
};
