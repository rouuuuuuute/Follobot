const path = require('path');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

module.exports = {
    mode: 'development',
    entry: path.join(__dirname, 'resources/js/app.js'),
    output: {
        path: path.join(__dirname, 'public/js'),
        filename: 'bundle.js'
    },
    plugins: [
        new VueLoaderPlugin()
    ],
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
            {
                test: /\.vue$/,
                exclude: /node_modules/,
                use: {
                    loader: 'vue-loader',
                }
            }]},
    resolve: {
        modules: [path.join(__dirname, 'resources'),'node_modules'],
        extensions: ['.js','.jsx'],
        alias:{
            vue: 'vue/dist/vue.esm.js'
               }
              }
}
