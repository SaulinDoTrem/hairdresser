const { src, dest, watch, parallel } = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const connect = require("gulp-connect");

const rootPath = "src/view";

const paths = {
    html: {
        root: rootPath + "/templates/",
        all: rootPath + "/templates/**/*.html",
    },
    styles: {
        all: rootPath + "/styles/sass/**/*.scss",
        main: rootPath + "/styles/sass/main.scss",
    },
    scripts: {
        all: rootPath + "/scripts/**/*.js",
        main: rootPath + "src/scripts/index.js",
    },
    output: rootPath + "/styles/css",
};

function server() {
    connect.server({
        root: paths.html.root,
        livereload: true,
        port: 3030,
    });
}

function styles() {
    return src(paths.styles.main)
        .pipe(sass({ outputStyle: "compressed" }).on("error", sass.logError))
        .pipe(dest(paths.output))
        .pipe(connect.reload());
}

function html() {
    return src(paths.html.all).pipe(connect.reload());
}

function scripts() {
    return src(paths.scripts.all).pipe(connect.reload());
}

function sentinel() {
    watch(paths.html.all, { ignoreInitial: false }, html);
    watch(paths.styles.all, { ignoreInitial: false }, styles);
    watch(paths.scripts.all, { ignoreInitial: false }, scripts);
}

exports.default = parallel(server, sentinel);
