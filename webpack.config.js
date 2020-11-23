const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');

module.exports = {
  ...defaultConfig,
  entry: {
    'modsnap-cards-block': './src/js/ms-cards-block.js',
  },
  output: {
    path: path.join(__dirname, '/js/'),
    filename: '[name].js',
  },
};
