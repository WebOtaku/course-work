// Plug in
var gulp            = require('gulp'),
    sass            = require('gulp-sass'),
    uglify          = require('gulp-uglify'),
    concat          = require('gulp-concat'),
    rename          = require('gulp-rename'),
    сssnano         = require('gulp-cssnano'),
    cleancss        = require('gulp-clean-css'),
    groupcss        = require('gulp-group-css-media-queries'),
    imagemin        = require('gulp-imagemin'),
    pngquant        = require('imagemin-pngquant'),
    browsersync     = require('browser-sync'),
    del             = require('del'),
    cache           = require('gulp-cache'),
    autoprefixer    = require('gulp-autoprefixer'),
	notify          = require('gulp-notify'),
	smartgrid       = require('smart-grid');
    
// Tasks

// Smartgrid
gulp.task('smartgrid', function() {
	const settings = {
	outputStyle: 'sass', /* less || scss || sass || styl */
	columns: 12, /* number of grid columns */
	offset: '30px', /* gutter width px || % */
	container: {
	    maxWidth: '1200px', /* max-width оn very large screen */
	    fields: '30px' /* side fields */
	},
	breakPoints: {
	    xl: {
	        'width': '1140px', /* -> @media (max-width: 1100px) */
	        'fields': '15px' /* side fields */
	    },
	    lg: {
	        'width': '960px',
	        'fields': '15px'
	    },
	    md: {
	        'width': '720px',
	        'fields': '15px'
	    },
	    sm: {
	        'width': '540px',
	        'fields': '15px'
	    }
	}
	};
	smartgrid('./app/sass/_mixins', settings)
});

// Compile SASS in CSS 
gulp.task('sass', function() {
    return gulp.src('./app/sass/main.sass')
        .pipe(sass().on('error', notify.onError()))
        .pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], {cascade: true}))
        .pipe(cleancss())
        .pipe(groupcss())
        .pipe(gulp.dest('./app/css/'))
        .pipe(сssnano())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('./app/css/'))
});

// Concat CSS
gulp.task('css',['sass'], function(){
    return gulp.src([
        './app/libs/font-awesome/font-awesome.min.css',
        // libraries
        './app/css/main.min.css'
    ])
    .pipe(concat('styles.min.css'))
    //.pipe(сssnano()) если необходимо
    .pipe(gulp.dest('./app/css/'))
    .pipe(browsersync.reload({stream: true}))
});

// Minify JS
gulp.task('common-js', function() {
	return gulp.src([
        '!./app/js/**/*.min.js',
		'./app/js/**/*.js'
	])
	.pipe(concat('common.min.js'))
	.pipe(uglify()).on('error', notify.onError())
	.pipe(gulp.dest('app/js'));
});

// Concat JS
gulp.task('js',['common-js'], function(){
    return gulp.src([
        './app/libs/jquery/jquery.min.js',
        // libraries
        './app/js/common.min.js'
    ])
    .pipe(concat('scripts.min.js'))
    //.pipe(uglify()) если необходимо
    .pipe(gulp.dest('./app/js/'))
    .pipe(browsersync.reload({stream: true}));
});

// Cache Images
gulp.task('img', function(){
    return gulp.src('./app/img/**/*')
    .pipe(cache(imagemin({
        interlaced: true,
        progressive: true,
        svgoPlugins: [{removeViewBox: false}],
        une: [pngquant()]
    })))
    .pipe(gulp.dest('./dist/img/'))
});

// Gulp watch
gulp.task('watch', [/*'browsersync',*/'css', 'js'], function(){
    gulp.watch('./app/sass/**/*.sass',['css'])
    gulp.watch('./app/js/**/*.js', ['js'])
    gulp.watch('./app/**/*.html', browsersync.reload)
    // gulp.watch('./app/php/**/*.php', browsersync.reload({stream: true}))

});


// Build project
gulp.task('build',['clean', 'css', 'js', 'img'], function(){
    // css
    gulp.src([
        '!./app/css/main.min.css',
        './app/css/*.css'
    ])
        .pipe(gulp.dest('../dist/css/'))

    // fonts
    gulp.src('./app/fonts/**/*')
        .pipe(gulp.dest('../dist/fonts/'))

    // js
    gulp.src([
        '!./app/js/common.min.js',
        './app/js/**/*'
    ])
        .pipe(gulp.dest('../dist/js/'))

    // html
    gulp.src([
        './app/**/*.html',
        './app/.htaccess'
    ])
        .pipe(gulp.dest('../dist/'))

    // php
    gulp.src('./app/php/*.php')
        .pipe(gulp.dest('../dist/php/'))

    gulp.src('./app/*.php')
        .pipe(gulp.dest('../dist/'))
});

// Settings BrowserSync
gulp.task('browsersync', function(){
    browsersync({
        server: {
            baseDir: 'app'
        },
        notify: false
    })
});

// Del dist
gulp.task('clean', function(){
    return del.sync('dist')
});

// Clear cache
gulp.task('clear', function(){
    return cache.clearAll()
});

// default
gulp.task('default', ['watch']);

// Catch Error
/*function wrapPipe(taskFn) {
  return function(done) {
    var onSuccess = function() {
      done();
    };
    var onError = function(err) {
      done(err);
    }
    var outStream = taskFn(onSuccess, onError);
    if(outStream && typeof outStream.on === 'function') {
      outStream.on('end', onSuccess);
    }
  }
}*/