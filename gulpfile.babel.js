const gulp = require('gulp');
const webpackConfig =require('./webpack.config.js');
const webpack = require('webpack-stream');
const notify = require('gulp-notify');
const plumber = require('gulp-plumber');

function build(cb){
    gulp.src('resources/js/app.js')
        .pipe(plumber({
            errorHandler: notify.onError("Error: <%= error.message %>")
        }))
        .pipe(webpack(webpackConfig))
        .pipe(gulp.dest('public/js'));
    cb();
}


function watch(cb){gulp.watch('resources/js/**/*.js',gulp.parallel(build));}

exports.default = gulp.series(gulp.parallel(watch));
