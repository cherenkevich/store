( function() {

  var config = {
    clean: 'dist',
    fonts: {
      src: [ 'src/fonts/**/*.woff', 'src/fonts/**/*.otf' ],
      dest: 'dist/assets/fonts'
    },
    pass: {
      src: [ 'src/pass/**/*.*', 'src/pass/.htaccess', 'src/pass/*/.htaccess' ],
      dest: 'dist'
    },
    html: {
      pages: 'src/pages/**/*.pug',
      src: [ 'src/pages/**/*.pug', 'src/blocks/**/*.pug' ],
      dest: 'dist'
    },
    images: {
      src: 'src/images/**/*.*',
      dest: 'dist/assets/images'
    },
    styles: {
      src: 'src/styles/**/*.*',
      main: 'src/styles/styles.sass',
      dest: 'dist/assets/styles',
      outFile: 'dist/assets/styles/styles.css'
    },
    scripts: {
      src: [
        'node_modules/jquery/dist/jquery.js',
        'src/scripts/waypoints/lib/jquery.waypoints.js',
        'src/scripts/*.js'
      ],
      dest: 'dist/assets/scripts'
    },
    rsync: {
      src: [ 'dist/**', 'dist/.htaccess', 'dist/*/.htaccess' ],
      options: {
        root: 'dist',
        incremental: true,
        username: 'root',
        hostname: '185.14.187.65',
        destination: '/var/www/magazine.cherenkevich.com/public_html/'
      }
    },
    server: {
      site: {
        // https: true,
        server: {
          baseDir: './dist/'
        }
      },
      wp: {
        // proxy: 'http://intercargoshipper/'
      }
    }
  };

  var gulp = require( 'gulp' ),
    del = require( 'del' ),
    pug = require( 'gulp-pug' ),
    plumber = require( 'gulp-plumber' ),
    inline = require( 'gulp-inline' ),
    rsync = require( 'gulp-rsync' ),
    pngquant = require('imagemin-pngquant'),
    imagemin = require('gulp-imagemin'),
    browserSync = require( 'browser-sync' ).create(),
    concat = require( 'gulp-concat' ),
    autoprefixer = require( 'gulp-autoprefixer' ),
    base64 = require('gulp-base64'),
    minifyCss = require( 'gulp-clean-css' ),
    sass = require('gulp-sass')(require('sass')),
    uglify = require( 'gulp-uglify' ),
    imageResize = require('gulp-image-resize');

  gulp.task( 'clean', function() {
    return del( config.clean );
  } );

  gulp.task( 'fonts', function() {
    return gulp
      .src( config.fonts.src )
      .pipe( gulp.dest( config.fonts.dest ) );
  } );

  gulp.task( 'pass', function() {
    return gulp
      .src( config.pass.src )
      .pipe( gulp.dest( config.pass.dest ) );
  } );

  gulp.task( 'html', function() {
    return gulp
      .src( config.html.pages )
      .pipe( plumber() )
      .pipe(
        pug( {
          pretty: true
        } )
      )
      .pipe( gulp.dest( config.html.dest ) )
      .pipe( browserSync.stream() );
  } );

  gulp.task( 'images:dev', function() {
    return gulp
      .src( config.images.src )
      .pipe( gulp.dest( config.images.dest ) )
      .pipe( browserSync.stream() );
  } );

  gulp.task( 'images:deploy', function() {
    return gulp
      .src( config.images.src )
      .pipe(
        imagemin( {
          progressive: true,
          svgoPlugins: [ {
            removeViewBox: false
          } ],
          use: [ pngquant() ]
        } )
      )
      .pipe( gulp.dest( config.images.dest ) );
  } );

  gulp.task( 'styles:dev', function() {
    return gulp
      .src( config.styles.main )
      .pipe( sass(
        {
          outputStyle: 'expanded',
          sourceMap: true,
          outFile: config.styles.outFile
        }
      ).on( 'error', sass.logError ) )
      .pipe( plumber() )
      .pipe(
        base64( {
          extensions: [ 'svg' ],
          maxImageSize: 1024*1024,
          debug: false
        } )
      )
      .pipe( autoprefixer( 'last 2 version', 'safari 5', 'ie 8', 'ie 7', 'opera 12.1', 'ios 6', 'android 4' ) )
      .pipe(
        minifyCss( {
          compatibility: 'ie8',
          format: 'beautify',
          processImport: true
        } )
      )
      .pipe( gulp.dest( config.styles.dest ) )
      .pipe( browserSync.stream() );
  } );

  gulp.task( 'styles:deploy:build', function() {
    return gulp
      .src( config.styles.main )
      .pipe( sass(
        {
          outputStyle: 'compressed',
          sourceMap: false
        }
      ).on( 'error', sass.logError ) )
      .pipe( plumber() )
      .pipe(
        base64( {
          extensions: [ 'svg', 'png', 'gif', 'jpg' ],
          maxImageSize: 1024*1024,
          debug: false
        } )
      )
      .pipe( autoprefixer( 'last 2 version', 'safari 5', 'ie 8', 'ie 7', 'opera 12.1', 'ios 6', 'android 4' ) )
      .pipe(
        minifyCss( {
          compatibility: 'ie8',
          processImport: true
        } )
      )
      .pipe( gulp.dest( config.styles.dest ) );
  } );

  gulp.task( 'styles:deploy', gulp.series( 'images:dev', 'fonts', 'styles:deploy:build' ) );

  gulp.task( 'scripts:dev', function() {
    return gulp
      .src( config.scripts.src )
      .pipe( plumber() )
      .pipe( concat( 'scripts.js' ) )
      .pipe( gulp.dest( config.scripts.dest ) )
      .pipe( browserSync.stream() );
  } );

  gulp.task( 'scripts:deploy', function() {
    return gulp
      .src( config.scripts.src )
      .pipe( plumber() )
      .pipe( concat( 'scripts.js' ) )
      .pipe( uglify() )
      .pipe( gulp.dest( config.scripts.dest ) );
  } );

  gulp.task( 'dev', gulp.parallel( 'fonts', 'pass', 'images:dev', 'styles:dev', 'scripts:dev' ) );

  gulp.task( 'deploy', gulp.parallel( 'pass', 'styles:deploy', 'scripts:deploy' ) );

  // Сначала захости текущий сайт где-нибудь
  gulp.task( 'rsync', function() {
    return gulp.src( config.rsync.src )
      .pipe( rsync( config.rsync.options ) );
  } );

  gulp.task( 'server', function() {
    browserSync.init( config.server.site );
  } );

  gulp.task( 'watch', function() {
    gulp.watch( config.images.src ).on( 'change', gulp.series( 'images:dev' ) );
    gulp.watch( config.styles.src ).on( 'change', gulp.series( 'styles:dev' ) );
    gulp.watch( config.scripts.src ).on( 'change', gulp.series( 'scripts:dev' ) );
    // gulp.watch( config.html.src ).on( 'change', gulp.series( 'html' ) );
    gulp.watch( config.pass.src ).on( 'change', gulp.series( 'pass' ) );
  } );

  gulp.task( 'release', gulp.series( 'deploy', 'rsync' ) );

  gulp.task( 'default', gulp.series( 'clean', 'dev', gulp.parallel( 'watch', 'server' ) ) );

} )();
