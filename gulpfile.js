// Require all dev dependencies.
var gulp      = require('gulp'),
    minify    = require('gulp-minify'),
    watch     = require('gulp-watch'),
    cleanCSS  = require('gulp-clean-css'),
    rename    = require('gulp-rename'),
    postcss   = require('gulp-postcss'),
    sass      = require('gulp-sass'),
    zip       = require('gulp-zip'),
		prompt 	  = require('gulp-prompt'),
		git 	    = require('gulp-git'),
		request   = require('request'),
		shell     = require('shelljs'),
		semver    = require('semver'), // Versioning standard - http://semver.org/
		fs        = require('fs'),
		asynclib  =  require('async'),
		rmdir	    = require('rmdir'),
    autoprefixer = require('autoprefixer'),
    browserSync  = require('browser-sync').create(),
		sourcemaps   = require('gulp-sourcemaps'),
		spawn_shell  = require('spawn-shell'),
		imagemin 		 = require('gulp-imagemin');

		var exec = require('child_process').exec;

// me.js contains vars to your specific setup
var me = require('./gulpconf.js');
var environment = Object.assign({}, process.env, { PATH: process.env.PATH + ':/usr/local/bin' });

var WEBSITE   = me.WEBSITE;
var CONTENT_TYPE = me.CONTENT_TYPE;
var BASE_NAME = __dirname.match(/([^\/]*)\/*$/)[1];
const BASE_FILE = 'style.css';
const TAG_REGEX = /\*\s?version:\s?(?:(\d+)\.)?(?:(\d+)\.)?(\*|\d+)/i;

// JS source, destination, and excludes.
var JS_EXCLD  = '!assets/js/*.min.js',
    JS_SRC    = 'assets/js/*.js',
    JS_DEST   = 'assets/js/';

// CSS and SASS src, dest, and exclude.
var CSS_SRC   = 'assets/css/*.css',
		CSS_DEST  = 'assets/css/',
		CSS_EXCLD = '!assets/css/*.min.css',
		SASS_WATCH  = 'assets/scss/*.scss';
if( 'plugin' === CONTENT_TYPE){
		SASS_SRC  = 'assets/scss/*.scss';
}else{
		SASS_SRC  = ['assets/scss/*.scss', '!assets/scss/style.scss' ];
}

// Image src and dest.
var IMG_SRC  = 'assets/images/*',
		IMG_DEST = 'assets/images';

// Zip src and options.
var ZIP_SRC_ARR = [
  './**',
  '!**/composer.*',
	'!**/gulpfile.js',
  '!**/gulpconf.js',
  '!**/package.json',
  '!**/README.md',
	'!**/phpcs.xml',
	'!**/phpcs.ruleset.xml',
  '!**/phpdoc.dist.xml',
  '!**/phpunit.xml.dist',
  '!**/{node_modules,node_modules/**}',
  '!**/{bin,bin/**}',
  '!**/{dist,dist/**}',
	'!**/{vendor,vendor/**}',
  '!**/{docs,docs/**}',
  '!**/{tests,tests/**}'
];
var ZIP_OPTS = { base: '..' };

// PHP Source.
var PHP_SRC = '**/*.php';

/*******************************************************************************
 *                                Gulp Tasks
 ******************************************************************************/

/**
 * Default gulp task. Initializes browserSync proxy server and watches src files
 * for any changes.
 *
 * CMD: gulp
 */
gulp.task('default', function() {

  browserSync.init({
    proxy: WEBSITE
  });

  gulp.watch( SASS_SRC, ['build-sass']);
  gulp.watch( JS_SRC , ['js-watch']);
  gulp.watch( PHP_SRC, function(){
    browserSync.reload();
  });
});

/**
 * JS Watch task. This is a dependency task for the default gulp task that
 * builds the js files and reloads the browser in the correct order
 *
 * CMD: None. Not meant to be run as standalone command.
 */
gulp.task('js-watch', ['build-js'], function(){
  browserSync.reload();
});

/**
 * Compiles SCSS into regular CSS.
 *
 * CMD: gulp build-sass
 */
gulp.task('build-sass', function() {
  gulp.src( SASS_SRC )
		.pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
		.pipe(postcss([
      autoprefixer({browsers: ['> 5% in US']})
    ]))
    .pipe(cleanCSS({compatibility: 'ie8'}))
		.pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(CSS_DEST));

	gulp.src( 'assets/scss/style.scss' )
		.pipe(sourcemaps.init())
	  .pipe(sass().on('error', sass.logError))
		.pipe(postcss([
      autoprefixer({browsers: ['> 5% in US']})
    ]))
    .pipe(cleanCSS({compatibility: 'ie8'}))
		.pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('.'))
    .pipe(browserSync.stream());
});

/**
 * Minifies JS files.
 *
 * CMD: gulp build-js
 */
gulp.task('build-js', function(){
  gulp.src( [ JS_SRC, JS_EXCLD ] )
    .pipe(minify({
      ext:{
        src:'.js',
        min:'.min.js'
      },
      noSource: true
    }))
    .pipe(gulp.dest( JS_DEST ));
});

gulp.task('build-img', function(){
	gulp.src('assets/images/*')
    .pipe(imagemin())
    .pipe(gulp.dest('assets/images'));
});

/**
 * Executes all of the build tasks in the correct sequence.
 *
 * CMD: gulp build
 */
gulp.task('build', ['build-sass','build-js', 'build-img']);

/**
 * Creates a zip file of the current project without any of the config and dev
 * files and saves it under the 'dist' folder.
 *
 * CMD: gulp zip
 */
gulp.task('zip', function(){
  return gulp.src( ZIP_SRC_ARR, ZIP_OPTS )
    .pipe( zip( BASE_NAME + '.zip' ) )
    .pipe( gulp.dest('dist') );
});

/**
 * Initializes dev dependencies.
 */
gulp.task('init',['wp-enforcer'], function(){
	return request('https://gist.githubusercontent.com/sfgarza/32258b7332a715de4e3948892ba415d3/raw/8a499cfe32749f4cabe2f6fe0d95653ce98e14e2/pre-commit-gulp.bash').pipe(fs.createWriteStream('.git/hooks/pre-commit'));
});


/**
 * Runs composer install.
 */
gulp.task('composer', function(cb) {
  //Install composer packages
  return shell_exec('composer install', cb );
});

/**
 * Runs composer update
 */
gulp.task('composer-update', function(cb) {
  //Install composer packages
  return shell_exec('composer update', cb );
});

/**
 * Installs wp-enforcer
 */
gulp.task('wp-enforcer', ['composer'], function(cb){
	return shell_exec('./vendor/bin/wp-enforcer', cb );
});

gulp.task('clean', function(){
	rmdir('./dist');
});

gulp.task('tag', function(){
	get_current_version();
	get_current_branch();
	console.log(('Current version: ' + current_version).green );
	gulp.src( BASE_FILE )
    .pipe(prompt.prompt({
        type: 'list',
        name: 'bump',
        message: 'What kind of release would you like to make?',
        choices: ['patch', 'minor', 'major']
    }, function(res){
			asynclib.waterfall([
	      function(callback){
	        callback(null, res.bump);
	      },
	      git_bump,
				git_push,
				git_tag
				//git_push
	    ], function (err, result) {
	      if( null !== err ){
	        console.log('ERROR: %j', err);
	      }
	    });
    }));
})

/*******************************************************************************
 *                                Functions
 ******************************************************************************/
function get_current_version(){
 	head = shell.head( {'-n':30}, BASE_FILE );
 	found = head.match( TAG_REGEX )
	console.log('%j', head);
  current_version = found[1] + '.' + found[2] + '.' + found[3];
}

function get_current_branch(){
	git.revParse({args:'--abbrev-ref HEAD'}, function (err, hash) {
		if (err){
			console.error( (err.message).red );
		}
		else{
			current_branch = hash;
		}
	});
}

function git_bump(bump,callback){
	new_version = semver.inc( current_version, bump )
	shell.sed( '-i', TAG_REGEX, '* Version: ' + new_version, BASE_FILE );
	console.log(('New version: ' + new_version).green );
	gulp.src( '.' )
		.pipe(git.add({args: '--all'}))
		.pipe(git.commit('Bumping version number'));
	return callback(null, current_branch);
}

function git_tag(callback){
	git.tag(new_version, 'Release' + new_version, {quiet:false}, function (err) {
		if (err){
			console.error( (err.message).red );
			console.error( 'Reverting changes...'.yellow );
			shell.sed( '-i', TAG_REGEX, '* Version: ' + current_version, BASE_FILE );
			return callback(err)
		}
		else{
			return callback(null, '--tags')
		}
	});
}

function git_push( branch, callback ){
	console.log(branch);
	git.push('origin', branch, function (err) {
		if (err){
			console.error( (err.message).red );
			return callback(err);
		}
		else{
			return callback(null);
		}
	});
}

/**
 * Execute Shell script within node.
 *
 * Not currently being used.
 * @param  {String}   command  : Command to execute.
 * @param  {Function} callback : Callback function.
 * @return {Function}          : Callback function.
 */
function shell_exec( command, callback ){
  // Execute bash script.
  // command = path.join( __dirname , '/scripts/gulpconf.sh');
  shell = spawn_shell(command, { shell: '/bin/bash', env: environment });
  shell.on('exit', function(data){
    return callback();
  });
}
