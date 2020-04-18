const path        = require('path');
const fs          = require('fs-extra');
const gulp        = require('gulp');
const browserSync = require('browser-sync');
const sourcemaps  = require('gulp-sourcemaps');
const sass        = require('gulp-sass');
const rtlcss      = require('rtlcss');
const cssnano     = require('gulp-cssnano');
const glob        = require("glob");
const concat      = require('gulp-concat');
const uglify      = require('gulp-uglify');
const babel       = require('gulp-babel');
const inject      = require('gulp-inject');
const addsrc      = require('gulp-add-src');

var paths = {
	sass:"./assets/sass",
	dev:"./assets/babel",
	js:'./assets/js',
    css:'./assets/css',
    "node": "./node_modules/",
    "bower": "./bower_components/",
    "distprod": "./dist-product",
    "dist":"/Applications/XAMPP/xamppfiles/htdocs/wordpress/svn/opal-widgets-for-elementor/trunk"
}

var folderPlugin = './';

gulp.task( 'watch', [ 'babel-admin-elementor-frontend' ], function(){
    gulp.watch([
        path.join(folderPlugin, 'assets/babel/elementor/frontend/*.js'),
        path.join(folderPlugin, 'assets/sass/*.scss'),
        path.join(folderPlugin, 'assets/sass/**/*.scss')
    ], () => {
        gulp.start('babel-admin-elementor-frontend');
        gulp.start('elementor-frontend');
    });
} );

gulp.task( 'elementor-frontend', function() {
    return gulp.src( path.join(folderPlugin, 'assets/sass/elementor-frontend.scss') )
      //  .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
     //   .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(path.join(folderPlugin, 'assets/css')));
} );

gulp.task('babel-admin-elementor-frontend', function () {
    return gulp.src([
        path.join(folderPlugin, 'assets/babel/fixjquery/before.js'),
        path.join(folderPlugin, 'assets/babel/elementor/frontend/*.js'),
        path.join(folderPlugin, 'assets/babel/fixjquery/after.js'),
    ])
        .pipe(sourcemaps.init())
        .pipe(concat('frontend.js'))
        .pipe(babel({
            presets: ['es2015', 'stage-0']
        }).on('error', function (error) {
            console.log(error);
            this.emit('end')
        }))
        .pipe(uglify())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(path.join(folderPlugin, 'assets/js/elementor/')));
});


gulp.task('babel-admin-elementor', function () {
    return gulp.src([
        path.join(folderPlugin, 'assets/babel/fixjquery/before.js'),
        path.join(folderPlugin, 'assets/babel/elementor/editor/*.js'),
        path.join(folderPlugin, 'assets/babel/fixjquery/after.js'),
    ])
               .pipe(sourcemaps.init())
               .pipe(concat('admin-editor.js'))
               .pipe(babel({
                   presets: ['es2015', 'stage-0']
               }).on('error', function (error) {
                   console.log(error);
                   this.emit('end')
               }))
                // .pipe(addsrc.prepend('assets/babel/libs/jquery.sticky.js'))
                // .pipe(concat('sticky-header.js'))
               .pipe(uglify())
               .pipe(sourcemaps.write('.'))
               .pipe(gulp.dest(path.join(folderPlugin, 'assets/js/elementor/')));
});


// Deleting any file inside the /dist folder
gulp.task( 'clean-dist', function() {
    // return del( [paths.dist + '/**'] );
   });
 gulp.task( 'dist', ['clean-dist'], function() {
     return gulp.src( ['**/*', '!*.js', '!' + paths.bower, '!' + paths.bower + '/**', '!' + paths.node, '!' + paths.node + '/**', '!' + paths.dev, '!' + paths.dev + '/**', '!' + paths.dist, '!' + paths.dist + '/**', '!' + paths.distprod, '!' + paths.distprod + '/**', '!' + paths.sass, '!' + paths.sass + '/**', '!readme.md', '!package.json', '!package-lock.json', '!gulpfile.js', '!project.json', '!CHANGELOG.md', '!.travis.yml', '!jshintignore',  '!codesniffer.ruleset.xml',"!**/*.map",  '*'], { 'buffer': false } )
       .pipe( gulp.dest( paths.dist ) );
 });