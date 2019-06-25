const path = require('path');

module.exports = {
  module: {
    rules: [
      {
        test: /\.m?(js|jsx)$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
        },
      },
    ],
  },
  entry: './src/index.jsx',
  output: {
    path: path.resolve(__dirname, './build'),
    filename: 'index_bundle.js',
  },
};
