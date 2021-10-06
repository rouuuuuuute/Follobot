import gulp from 'gulp';
import webpackConfig from './webpack.config.js';
import webpack from 'webpack-stream';
import browserSync from 'browser-sync';
import notify from 'gulp-notify';
import plumber from 'gulp-plumber';
import eslint from 'gulp-eslint';

gulp.task('build', function(){
    gulp.src('resources/js/app.js')
        .pipe(plumber({
            errorHandler: notify.onError("Error: <%= error.message %>")
        }))
        .pipe(webpack(webpackConfig))
        .pipe(gulp.dest('public/js'));
});

gulp.task('browser-sync', function(){
    browserSync.init({
        server: {
            baseDir: "./",
            index: "index.php"
        }
    });
});

gulp.task('bs-reload',function (){
    browserSync.reload();
    }
);

gulp.task('eslint',function () {
    return gulp.src(['resources/**/*.js'])
        .pipe(plumber({
            errorHandler: function (error) {
                const taskName = 'eslint';
                const title = '[task]'+ taskName + '' + error.plugin;
                const errorMsg = 'error:' + error.message;
                console.error(title + '\n' + errorMsg);
                notify.onError({
                    title: title,
                    message: errorMsg,
                    time : 3000
                });
            }
        }))
        .pipe(eslint({useEslintrc:true}))
        .pipe(eslint.format())
        .pipe(eslint.failOnError())
        .pipe(plumber.stop());
});

gulp.task('default',['eslint','build','browser-sync'], function(){
    gulp.watch("./resources/**/*.js",['build']);
    gulp.watch("./*.php",['bs-reload']);
    gulp.watch("./public/**/*.+(js|css)",['bs-reload']);
    gulp.watch("./resources/**/*.js",['eslint']);
})


//
// const gulp = require('gulp');
// const webpackConfig =require('./webpack.config.js');
// const webpack = require('webpack-stream');
// const notify = require('gulp-notify');
// const plumber = require('gulp-plumber');
// const browserSync = require("browser-sync");
//
// function build(cb){
//     gulp.src('resources/js/app.js')
//         .pipe(plumber({
//             errorHandler: notify.onError("Error: <%= error.message %>")
//         }))
//         .pipe(webpack(webpackConfig))
//         .pipe(gulp.dest('public/js'));
//     cb();
// }
//
// function browser_sync(cb){
//     browserSync.init({
//         server: {
//             baseDir: "./",
//             index: "index.php"
//         }
//     });
//     cb();
// }
//
// exports.default = gulp.series(gulp.parallel(build , browser_sync));
