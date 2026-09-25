import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import {globby} from 'globby';

const resourceFiles = await globby(['resources/pages', 'resources/includes'], {
    expandDirectories: {
        extensions: ['js', 'css']
    }
});

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/helper.js',
                ...resourceFiles
            ],
            refresh: true,
        }),
    ],
});
