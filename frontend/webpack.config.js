const path = require('path');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const {VueLoaderPlugin} = require('vue-loader');
const HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
    mode: 'development',
    entry: './src/index.js',
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'assets/js/main.js'
    },
    plugins: [
        new BrowserSyncPlugin({
            host: 'localhost',
            port: '3000',
            server: {
                baseDir: ['dist']
            }
        }),
        new HtmlWebpackPlugin({
            template: './src/index.html'
        }),
        new VueLoaderPlugin(),
    ],
    module: {
        rules: [
            {
                test: /\.pug$/,
                oneOf: [
                    {
                        resourceQuery: /^\?vue/,
                        use: ['pug-plain-loader']
                    },
                    {
                        use: ['raw-loader', 'pug-plain-loader']
                    }
                ]
            },
            {
                test: /\.(scss|css)$/,
                use: [
                    'style-loader',
                    'css-loader',
                    'sass-loader'
                ]
            },
            {
                test: /\.js$/,
                use: [
                    'babel-loader'
                ]
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    extractCSS: true
                }
            },
        ]
    }
}