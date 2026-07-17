/**
 * Dev-only helper: compiles the Studio Frame theme's assets/scss and
 * assets/js/src into assets/css and assets/js, reusing this folder's Gulp
 * Sass/Webpack setup instead of duplicating a build toolchain in the theme
 * root (which ships pre-compiled CSS/JS and needs no build step at all).
 *
 * Usage (from legacy-verstka/, after `npm install --ignore-scripts`):
 *   node build-theme-assets.mjs         # dev build, readable output
 *   node build-theme-assets.mjs --prod  # minified build
 */
import gulp from 'gulp';
import path from 'node:path';
import webpackStream from 'webpack-stream';
import plumber from 'gulp-plumber';
import { styles } from './gulp/tasks/styles.js';

const themeRoot = path.resolve('..');
const nodeModulesDir = path.resolve('./node_modules');
const isProd = process.argv.includes('--prod');

global.app = {
  gulp,
  isProd,
  paths: {
    base: {
      src: path.join(themeRoot, 'assets'),
      build: path.join(themeRoot, 'assets'),
    },
    srcScss: path.join(themeRoot, 'assets/scss/**/*.scss'),
    buildCssFolder: path.join(themeRoot, 'assets/css'),
  },
};

const scripts = () => {
  return gulp.src(path.join(themeRoot, 'assets/js/src/main.js'))
    .pipe(plumber())
    .pipe(webpackStream({
      mode: isProd ? 'production' : 'development',
      output: { filename: 'main.js' },
      resolve: {
        modules: [nodeModulesDir, 'node_modules'],
      },
      resolveLoader: {
        modules: [nodeModulesDir, 'node_modules'],
      },
      module: {
        rules: [{
          test: /\.m?js$/,
          exclude: /node_modules/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: [['@babel/preset-env', { targets: 'defaults' }]],
            },
          },
        }],
      },
      devtool: !isProd ? 'source-map' : false,
    }))
    .pipe(gulp.dest(path.join(themeRoot, 'assets/js')));
};

gulp.series(scripts, styles)((err) => {
  if (err) {
    console.error(err);
    process.exit(1);
  }
  console.log('THEME ASSETS BUILD DONE');
});
