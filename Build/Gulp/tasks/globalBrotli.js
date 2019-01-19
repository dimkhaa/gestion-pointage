'use strict';

if (!config.tasks.compress) {
	return false;
}

function compress() {
  return gulp.src([
    'Packages/*/*/Resources/Public/**/*.js',
    'Packages/*/*/Resources/Public/**/*.css'
  ])
    .pipe(brotli.compress())
    .pipe(gulp.dest(function(file) {
      return file.base;
    }));
}

module.exports = compress;
