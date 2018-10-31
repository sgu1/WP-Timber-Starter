//https://stackoverflow.com/questions/21699146/gulp-js-task-return-on-src
/* ----------------------
*  -- Required Plugins --
   ---------------------- */

   var gulp = require('gulp'),
   // CSS
   sass            = require('gulp-sass'), // Gulp pluign for Sass compilation
   autoprefixer    = require('gulp-autoprefixer'), // Autoprefixing magic
   minifycss       = require('gulp-uglifycss'), // Minifies CSS files
   // JS
   concat = require('gulp-concat'), // Concatenates JS files
   uglify = require('gulp-uglify'), // Minifies JS files
   jshint = require('gulp-jshint'), // Detect JS errors
   // Utility
   rename      = require('gulp-rename'), // Renames files E.g. style.css -> style.min.css
   sourcemaps  = require('gulp-sourcemaps'), // Maps code in a compressed file (E.g. style.css) back to it’s original position in a source file
   del         = require('del'), //del: deletes folders and stuff
   notify      = require('gulp-notify'), // Sends message notification to you
   browserSync = require('browser-sync').create(),
   reload  = browserSync.reload;
/* ============================ */

/* ----------------------
*  -- Variables --
  ---------------------- */
var projectDirectory = 'public';
var projectTheme = 'starter_theme';

//Paths
const SRC_THEME = '../'+ projectDirectory +'/wp-content/themes/' + projectTheme +'/';
const SRC_RESOURCE = '../_resources/';

var styleSRC =  SRC_RESOURCE + 'scss/style.scss'; // Path to main .scss file
var styleDest = SRC_THEME; // Path to place compiled css file

var jsVendorSRC = SRC_RESOURCE + 'js/vendors/*.js'; // Path to JS custom scripts folder
var jsVendorDest = SRC_THEME + 'assets/js/'; // Path to compiled JS vendor files
var jsVendorFile = 'vendor'; // Compiled JS vendors file name
// Default set to vendors i.e. vendors.js

var jsCustomSRC         = SRC_RESOURCE + 'js/custom/*.js'; // Path to JS custom scripts folder
var jsCustomDest        = SRC_THEME + 'assets/js/'; // Path to place the compiled JS custom scripts file
var jsCustomFile        = 'vsg_custom'; // Compiled JS custom file name

var styleWatchFiles     = SRC_RESOURCE + 'scss/**/*.scss'; // Path to all *.scss files inside css folder and inside them
var vendorJSWatchFiles  = SRC_RESOURCE + 'js/vendor/*.js'; // Path to all vendors JS files
var customJSWatchFiles  = SRC_RESOURCE + 'js/custom/*.js'; // Path to all custom JS files

/* ============================ */

/* ----------------------
*  -- Task: Styles --
  ---------------------- 
*
* Compiles Sass, Autoprefixes it and Minifies CSS.
* 
* Make sure that your WordPress theme base stylesheet begins with /**! otherwise, the minifycss might remove the WordPress comment at the top. 
*
* This task does the following:
* 		1. Gets the source scss file
* 		2. Compiles Sass to CSS
* 		3. Writes Sourcemaps for it
* 		4. Autoprefixes it and generates style.css
* 		5. Renames the CSS file with suffix .min.css
* 		6. Minifies the CSS file and generates style.min.css 
*/
gulp.task('styles', function () {
   gulp.src( styleSRC )
      .pipe( sourcemaps.init() )
      .pipe( sass({
           errLogToConsole: true,
           outputStyle: 'compact',
           // outputStyle: 'compressed',
           // outputStyle: 'nested',
           // outputStyle: 'expanded',
           precision: 10
       }) )
       .pipe( sourcemaps.write( { includeContent: false } ) )
       .pipe( sourcemaps.init( { loadMaps: true } ) )
       .pipe( autoprefixer(
           'last 2 versions',
           '> 1%' ) )

       .pipe( sourcemaps.write ( './' ) )

       .pipe( minifycss( {
            maxLineLen: 200
       }))
       .pipe( gulp.dest( styleDest ) )
       .pipe( notify( { message: 'TASK: "styles" Completed!', onLast: true } ) );
});

/* ============================ */

/* ----------------------
*  -- Task: vendorJS --
 ----------------------
*
* Concatenate and uglify vendor JS scripts.
*
* This task does the following:
* 		1. Gets the source folder for JS vendor files
* 		2. Concatenates all the files and generates vendors.js
* 		3. Renames the JS file with suffix .min.js
* 		4. Uglifes/Minifies the JS file and generates vendors.min.js
*/

gulp.task( 'vendorsJs', function() {
   return gulp.src( jsVendorSRC )
       .pipe( concat( jsVendorFile + '.js' ) )
       .pipe( gulp.dest( jsVendorDest ) )
       .pipe( rename( {
           basename: jsVendorFile,
           suffix: '.min'
       }))
       .pipe( uglify() )
       .pipe( gulp.dest( jsVendorDest ) );
});

/* ============================ */

/* ----------------------
*  -- Task: customJS --
  ----------------------
*
* Concatenate and uglify custom JS scripts.
*
* This task does the following:
* 		1. Gets the source folder for JS custom files
* 		2. Concatenates all the files and generates custom.js
* 		3. Renames the JS file with suffix .min.js
* 		4. Uglifes/Minifies the JS file and generates custom.min.js
*/
gulp.task( 'customJS', function() {
   gulp.src( jsCustomSRC )
      .pipe( concat( jsCustomFile + '.js' ) )
      .pipe( gulp.dest( jsCustomDest ) )
      .pipe( rename( {
          basename: jsCustomFile,
          suffix: '.min'
      }))
      .pipe( uglify() )
      .pipe( gulp.dest( jsCustomDest ) );
});
/* ============================ */

/* ----------------------
*  -- Task: lintJS --
  ---------------------- */
gulp.task( 'lintJS', function() {
   return gulp.src( jsCustomSRC )
   .pipe(jshint.reporter('default'))
   .pipe(gulp.dest(jsCustomSRC));
});
/* ============================ */

/* ----------------------
*  -- Task: Defualt --
  ---------------------- 
*
* Also watch everything
*/
gulp.task( 'default', [ 'styles', 'vendorsJs', 'customJS' ], function () {
   browserSync.init({ 
       baseDir: "../vsg/"
   });
   gulp.watch( styleWatchFiles, [ 'styles' ] );
   gulp.watch( vendorJSWatchFiles, [ 'vendorsJs' ] );
   gulp.watch( customJSWatchFiles, [ 'customJS' ] );
   gulp.watch(SRC_THEME + '**/*').on('change', reload);
});
/* ============================ */

/* ----------------------
*  -- Task: Build Theme --
  ---------------------- 
*
* Build theme in the root folder
*/

var buildSrc = SRC_THEME + '**/*';
var buildDest = '../_build-theme/';

// 1) Delete the build directory
gulp.task('build:cleanfolder', function(){
   return del([buildDest + '**'], {force:true});
});
// 2) Copy App Directory
gulp.task('build:copy', ['build:cleanfolder'], function(){
   return gulp.src(buildSrc)
   .pipe(gulp.dest(buildDest));
});
// 3) Remove unwanted files/folders
gulp.task('build:remove', ['build:copy'], function(){
   return del([], {force:true});
});
// 4) Combine
gulp.task('build:theme', ['build:copy', 'build:remove']);
/* ============================ */