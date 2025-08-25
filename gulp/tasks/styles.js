import gulpif from 'gulp-if';
import browserSync from 'browser-sync';
import cleanCSS from 'gulp-clean-css';
import * as sass from 'sass'; // Импортируем напрямую Dart Sass
import gulpSass from 'gulp-sass'; // Современный API
import plumber from 'gulp-plumber';
import autoprefixer from 'gulp-autoprefixer';
import notify from 'gulp-notify';

// Инициализация Sass компилятора (современный API)
const sassCompiler = gulpSass(sass);

// Конфигурация Autoprefixer
const autoprefixerConfig = {
  cascade: false,
  grid: true,
  overrideBrowserslist: "last 10 versions"
};

// Конфигурация cleanCSS для production
const cleanCssConfig = {
  level: 2
};

// Обработчик ошибок
const errorHandler = notify.onError({
  title: "SCSS Compilation Error",
  message: "Error: <%= error.message %>"
});

/**
 * Компиляция SCSS в CSS
 * @returns {Stream} Gulp stream
 */
export const styles = () => {
  const { srcScss, buildCssFolder } = app.paths;
  const { isProd } = app;

  // Конфигурация Sass
  const sassOptions = {
    style: isProd ? 'compressed' : 'expanded', // заменили outputStyle на style
    sourceMap: !isProd, // включение source maps
    // другие опции если нужно
  };

  return app.gulp.src(srcScss, {
      sourcemaps: !isProd
    })
    .pipe(plumber({ errorHandler }))
    .pipe(sassCompiler(sassOptions).on('error', sassCompiler.logError))
    .pipe(autoprefixer(autoprefixerConfig))
    .pipe(gulpif(isProd, cleanCSS(cleanCssConfig)))
    .pipe(app.gulp.dest(buildCssFolder, {
      sourcemaps: isProd ? false : '.'
    }))
    .pipe(browserSync.stream());
};
