const EslintWebpackPlugin = require('eslint-webpack-plugin');
const path = require('path');

module.exports = {
    plugins: [
        new EslintWebpackPlugin({
            extensions: ['js', 'vue'],
            fix: true,
        }),
    ],
    output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
    resolve: {
        alias: {
            '@': path.resolve('./resources/js'),
        },
    },
};
