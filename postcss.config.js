const path = require('path');

module.exports = {
  plugins: [
    require('@tailwindcss/postcss'),
    require('autoprefixer'),
    require('postcss-url')([{
      filter: /\.(woff2?|ttf|eot|svg)(\?.*)?$/,
      url: (asset) => {
        const filename = path.basename(asset.url.split('?')[0]);
        return `../webfonts/${filename}`;
      },
    }]),
  ],
};
