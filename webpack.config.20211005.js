const path = require('path');

module.exports = {
    mode: 'development',
    entry: path.join(__dirname, 'resources/js/app.js'),
    output: {
        path: path.join(__dirname, 'public/js'),
        filename: 'bundle.js'
    },
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
            }
        ]
    },
    resolve: {
        modules: [path.join(__dirname, 'src'),'node_modules'],
        extensions: ['.js','.jsx'],
        alias:{
            vue: 'vue/dist/vue.esm.js'
        }
    }
}
