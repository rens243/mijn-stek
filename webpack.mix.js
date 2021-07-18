const mix = require('laravel-mix');
// const path = require('path');
// const MiniCssExtractPlugin = require('mini-css-extract-plugin');

require('laravel-mix-svelte');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */



// Normal laravel
mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css/app.css', [
        require('postcss-import'),
        require('tailwindcss'),
    ]);

mix.js('resources/js/svelte/main.js', 'public/js/svelte-app.js')
    .svelte();

if (mix.inProduction()) {
    mix.version();
}

//
// // Difficult svelte stuff
// mix.webpackConfig({
//     // devtool: "source-map", // any "source-map"-like devtool is possible
//     entry: './resources/js/svelte/main.js',
//     output: {
//         filename: 'svelte-app.js',
//         path: path.resolve(__dirname, 'public'),
//     },
//     resolve: {
//         // see below for an explanation
//         alias: {
//             svelte: path.resolve("node_modules", "svelte"),
//         },
//         extensions: [".mjs", ".js", ".svelte"],
//         mainFields: ["svelte", "browser", "module", "main"]
//     },
//     module: {
//         rules: [
//             {
//                 test: /\.(html|svelte)$/,
//                 // exclude: /node_modules/,
//                 // use: "svelte-loader"
//                 use: {
//                     loader: "svelte-loader",
//                     options: {
//                         emitCss: true, // emit virtual css file for each component
//                         preprocess: require("svelte-preprocess")({
//                             postcss: true
//                             /* options */
//                         })
//                     }
//                 }
//             },
//             {
//                 // required to prevent errors from Svelte on Webpack 5+, omit on Webpack 4
//                 test: /node_modules\/svelte\/.*\.mjs$/,
//                 resolve: {
//                     fullySpecified: false
//                 }
//             },
//             {
//                 test: /\.css$/,
//                 use: [
//                     MiniCssExtractPlugin.loader,
//                     {
//                         loader: 'css-loader',
//                         options: {
//                             url: false, // necessary if you use url('/path/to/some/asset.png|jpg|gif')
//                         }
//                     }
//                 ]
//             },
//         ]
//     },
//     plugins: [
//         new MiniCssExtractPlugin({filename: 'css/svelte.css'})
//     ]
// });
//
// mix.dump();
