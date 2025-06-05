import { defineConfig } from 'vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'
//import laravel from 'laravel-vite-plugin';


export default defineConfig({
	build: {
		//outDir: '../../../public_html/themes/One',
		outDir: './Resources/dist',
		emptyOutDir: false,
		manifest: true,
		rollupOptions: {
			output: {
				entryFileNames: `assets/[name].js`,
				chunkFileNames: `assets/[name].js`,
				assetFileNames: `assets/[name].[ext]`
			}
		}
	},
    ssr:{
        noExternal: ['chart.js/**']
    },
	plugins: [
		laravel({
			publicDirectory: '../../../public_html/',
			// buildDirectory: 'assets/',
			input: [
				//__dirname + '/Resources/sass/app.scss',
                __dirname + '/Resources/css/filament/admin/theme.css',
                __dirname + '/Resources/css/app.css',
				__dirname + '/Resources/js/app.js',

			],
            refresh: true,
			//refresh: [
            //    ...refreshPaths,
            //    'app/Livewire/**',
            //],
		}),
	],
});

