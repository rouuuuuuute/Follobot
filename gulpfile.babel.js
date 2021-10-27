const gulp = require('gulp');
const webpackConfig =require('./webpack.config.js');
const webpack = require('webpack-stream');
const notify = require('gulp-notify');
const plumber = require('gulp-plumber');
const browserSync = require("browser-sync");

function build(cb){
    gulp.src('resources/js/app.js')
        .pipe(plumber({
            errorHandler: notify.onError("Error: <%= error.message %>")
        }))
        .pipe(webpack(webpackConfig))
        .pipe(gulp.dest('public/js'));
    cb();
}

function buildCss(cb) {
    gulp.src('resources/sass/*.scss')
        .pipe()
}

function browser_sync(cb){
    browserSync.init({
        server: {
            baseDir: "./",
            index: "index.html"
        }
    });
    cb();
}

function bsReload(cb) {
    browserSync.reload();
    cb();
}
//ToDo VueができてからESlintの問題は片付ける 時間がない場合は無理にesLint使わなくても良い

// function esLint(cb) {
//     gulp.src(['resources/**/*.js'])
//         .pipe(plumber({
//             errorHandler: function (error) {
//                 const taskName = 'eslint';
//                 const title = '[task]'+ taskName + '' + error.plugin;
//                 const errorMsg = 'error:' + error.message;
//                 console.error(title + '\n' + errorMsg);
//                 notify.onError({
//                     title: title,
//                     message: errorMsg,
//                     time : 3000
//                 });
//             }
//         }))
//         .pipe(eslint({useEslintrc:true}))
//         .pipe(eslint.format())
//         .pipe(eslint.failOnError())
//         .pipe(plumber.stop());
//     cb();
// }

exports.default = gulp.series(gulp.parallel(build , browser_sync, bsReload));
