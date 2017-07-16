var gulp = require('gulp'), //== https://github.com/gulpjs/gulp
    path = require('path'), //== http://nodejs.org/api/path.html
    sass = require('gulp-sass'), //== https://github.com/dlmanning/gulp-sass/
    spritesmith = require('gulp.spritesmith'), //== https://github.com/twolfson/gulp.spritesmith
    rename = require('gulp-rename'), //== https://github.com/hparra/gulp-rename
    rimraf = require('gulp-rimraf'), //== https://github.com/robrich/gulp-rimraf
    chalk = require('chalk'), //== https://github.com/sindresorhus/chalk
    plumber = require('gulp-plumber'), //== https://github.com/floatdrop/gulp-plumber
    notify = require("gulp-notify"), //== https://github.com/mikaelbr/gulp-notify
    shell = require('gulp-shell'), //== https://github.com/sun-zheng-an/gulp-shell
    uglify = require('gulp-uglify'), //== https://github.com/terinjokes/gulp-uglify
    concat = require('gulp-concat'), //== https://github.com/contra/gulp-concat
    yaml = require("js-yaml"), //== https://github.com/nodeca/js-yaml
    fs = require("fs"),
    newer = require('gulp-newer'), //== https://github.com/tschaub/gulp-newer
    argv = require('yargs').argv, //== https://github.com/yargs/yargs

    projectProtocol = 'https',
    projectHost = 'hitmakernation.sf',

    shortSrcAssets = 'app/Resources/assets',
    srcAssets = './app/Resources/assets',
    distAssets = './web',

    source = {
        dir: './', // add "{cwd: source.dir}" in watch task => http://stackoverflow.com/questions/22391527/gulps-gulp-watch-not-triggered-for-new-or-deleted-files
        img: distAssets + '/img',
        sprites: distAssets + '/img/sprites',
        sass: srcAssets + '/sass',
        js: srcAssets + '/js',
        yml: './app/config/assets.yml'
    },
    watch = {
        sass: shortSrcAssets + '/sass/**/**/*.scss',
        sassCorp: shortSrcAssets + '/sass/app_corporate.scss',
        css: distAssets + '/css/*.css',
        js: srcAssets + '/js/**/*.js',
        twig: './app/Resources/views/**/**/**/*.html.twig',
        controllers: 'src/AppBundle/Controller/*.php'
    },
    dist = {
        css: distAssets + '/css',
        img: distAssets + '/img',
        sprites: distAssets + '/img/sprites',
        js: distAssets + '/js'
    };

//== sprites :: gulp icons or logos (sprite alone), gulp icons-sass gulp logos-sass (sprite + sass)
var hashName = '', hash = '', hashPattern = "abcdefghijklmnopqrstuvwxyz0123456789";

function makeHash(hashName) {

    for (var i = 0; i < 11; i++) {
        hashName += hashPattern.charAt(Math.floor(Math.random() * hashPattern.length));
    }
    hash = hashName;
}

function spriteVersionning(spriteImg, pattern) {

    spriteImg.img.pipe(rename({suffix: '-' + hash}))
        .pipe(gulp.dest(dist.sprites));
    spriteImg.css.pipe(gulp.dest(dist.sprites));
    gulp.src(dist.sprites + pattern).pipe(rimraf({force: true}));
}

function makeSprite(spriteVar, name) {

    makeHash(hash);
    console.log(
        chalk.white('hash generated ')
        + chalk.cyan.bold(hash)
    );
    spriteVar = gulp.src(source.img + '/sprites/' + name + '/*.png').pipe(spritesmith({
        cssSpritesheetName: hash,
        imgName: name + '.png',
        imgPath: '../img/sprites/' + name, // css write
        cssName: '_' + name + '.scss', // relative to img folder...
        cssTemplate: source.sass + '/app/base/_' + name + '.scss.mustache',
        padding: 2
    }));
    spriteVersionning(spriteVar, '/' + name + '-*.png');
}


gulp.task('icons', function () {
    var icons = '';
    makeSprite(icons, 'icons');
});

gulp.task('c-icons', function() {
    var cIcons = '';
    makeSprite(cIcons, 'c-icons');
});





//== sass :: gulp sass, gulp sass --corp
gulp.task('sass', function () {

    if (argv.corp) {
        watcher = gulp.src(source.dir + watch.sassCorp)
    } else {
        watcher = gulp.src(source.dir + watch.sass)
    }

    watcher.pipe(plumber({
        errorHandler: notify.onError({
            message: "Error: <%= error.message %>",
            sound: true
        })
    }))
        .pipe(newer(dist.css))
        .pipe(sass({
            outputStyle: 'compressed',
            includePaths: [source.sass],
            errLogToConsole: true
        }))
        .pipe(plumber.stop())
        .pipe(gulp.dest(dist.css));
});




loadJsTasks();

function loadJsTasks() {
    assets = yaml.safeLoad(fs.readFileSync(source.yml));
    var tasks = [];
    for (file in assets.assets.js) {
        createJsTask(file, assets.assets.js[file]);
        tasks.push('js-' + file);
    }

    gulp.task('js', tasks);
}

function createJsTask(name, sources) {
    gulp.task('js-' + name, function () {
        test = [];
        for (file in sources) {
            test.push(source.js + '/' + name + '/' + sources[file]);
        }

        return gulp.src(test)
            .pipe(plumber({
                errorHandler: notify.onError({
                    message: "Error: <%= error.message %>",
                    sound: true
                })
            }))
            .pipe(concat(name + '.min.js'))
            .pipe(uglify({compress: {hoist_funs: false, hoist_vars: false}}))
            .pipe(plumber.stop())
            .pipe(gulp.dest(dist.js));
    });
}


//== shell :: gulp bs (browsersync)
var hasOpenUi = projectProtocol === 'http' ? '--open ui' : '';

gulp.task('bs', shell.task([
    'browser-sync start --proxy \
    ' + projectProtocol + '://' + projectHost + ' \
    ' + hasOpenUi + ' \
    --startPath "app_dev.php/" \
    --files "' + watch.css + ', ' + watch.js + ', ' + watch.twig + ', ' + watch.controllers + '"'
]));


//== watch
gulp.task('watch', function () {

    function logWatch(files, tasks) {

        var match = new RegExp('.*(?=' + tasks + ')');
        gulp.watch([files], {cwd: source.dir}, [tasks]).on('change', function (evt) {
            console.log(
                chalk.cyan.bold(evt.path.replace(match, ''))
                + chalk.white(' ' + evt.type)
            );
        });
        console.log(
            chalk.green(files)
        );
    }

    logWatch(watch.sass, 'sass');
    logWatch(watch.js, ['js-app', 'js-search']);
});