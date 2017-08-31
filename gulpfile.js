  var gulp = require('gulp'),
      uglify = require('gulp-uglify'),
      sass = require('gulp-ruby-sass'),
      concat = require('gulp-concat'),
      sourcemaps = require('gulp-sourcemaps');

gulp.task('sass', function () {
    return sass('scss/style.scss', {
      sourcemap: true,
      style: 'compressed'
    })
    .on('error', function (err) {
        console.error('Error!', err.message);
    })
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('public/css'));
});

gulp.task('watch', function() {
  gulp.watch(['scss/**/*'], ['sass']);
});

gulp.task('default', ['sass', 'watch']);
