const gulp = require('gulp');
const replace = require('gulp-replace');
/**
 * Copy Font Awesome
 */
gulp.task('copy_fa', function(done) {
    gulp.src('./node_modules/@fortawesome/fontawesome-free/css/all.min.css')
        .pipe(replace('*/', '*/\n\n/* .editor-styles-wrapper がないと 5.9 のブロックパターン挿入プレビューやタブレットで読み込まれない(2022.2.1現在)ので応急対応 */\n.editor-styles-wrapper{}'))
        .pipe(gulp.dest('./src/versions/6/css/'))
    gulp.src('./node_modules/@fortawesome/fontawesome-free/js/all.min.js')
        .pipe(gulp.dest('./src/versions/6/js/'))
    gulp.src('./node_modules/@fortawesome/fontawesome-free/sprites/**')
        .pipe(gulp.dest('./src/versions/6/sprites/'))
    gulp.src('./node_modules/@fortawesome/fontawesome-free/webfonts/**')
        .pipe(gulp.dest('./src/versions/6/webfonts/'))
    done();
});