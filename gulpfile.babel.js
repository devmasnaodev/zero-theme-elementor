import {src, dest, watch, series, parallel} from "gulp";
import yargs from "yargs";
import cleanCss from "gulp-clean-css";
import gulpif from "gulp-if";
import postcss from "gulp-postcss";
import sourcemaps from "gulp-sourcemaps";
import autoprefixer from "autoprefixer";
import imagemin from "gulp-imagemin";
import del from "del";
import webpack from "webpack-stream";
import browserSync from "browser-sync";
import zip from "gulp-zip";
import named from "vinyl-named";
import replace from "gulp-replace-task";
import rename from "gulp-rename";
import wpPot from "gulp-wp-pot";
import info from "./package.json";
import tailwind from "tailwindcss";
import cache from "gulp-cache";
import importcss from "gulp-cssimport";

const sass = require('gulp-sass')(require('sass'));
require("dotenv").config();

const PRODUCTION = yargs.argv.prod;

const devpatterns = [
    {
        json: {
            "THEME_NAME": `${info.description} src`,
            "THEME_VERSION": `${info.version}`,
            "THEME_TEXT_DOMAIN": process.env.TEXT_DOMAIN
        }
    }
];

const prodpatterns = [
    {
        json: {
            "THEME_NAME": `${info.description}`,
            "THEME_VERSION": `${info.version}`,
            "THEME_TEXT_DOMAIN": process.env.TEXT_DOMAIN
        }
    }
];

//PHP Replace
export const replace_main_style = () => {
    return src("src/css/style.css")
        .pipe(gulpif(!PRODUCTION, replace({patterns: devpatterns})))
        .pipe(gulpif(PRODUCTION, replace({patterns: prodpatterns})))
        .pipe(dest("./"));
};


//Tailwind Style
export const processcss = () => {

    return src(["src/css/tailwind.css"])
        .pipe(postcss([
            tailwind('./tailwind.config.js'),
            autoprefixer
        ]))
        .pipe(importcss())
        .pipe(dest("./dist/css"))
        .pipe(server.stream());

}

//Sass Style
export const styles = () => {
    return src(["src/scss/theme.scss"])
        .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
        .pipe(sass().on("error", sass.logError))
        .pipe(gulpif(PRODUCTION, postcss([autoprefixer])))
        .pipe(gulpif(PRODUCTION, cleanCss({compatibility: "ie8"})))
        .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
        .pipe(dest("./dist/css"))
        .pipe(server.stream());
};


//Image
export const images = () => {
    return src("src/images/**/*.{jpg,jpeg,png,svg,gif}")
        .pipe(gulpif(PRODUCTION, imagemin()))
        .pipe(dest("dist/images"));
};

//Watch
export const watching = () => {
    watch("src/scss/**/*.scss", series(styles, reload));
    watch("src/js/**/*.js", series(scripts, processcss, reload));
    watch("src/css/style.css", replace_main_style);
    watch(["**/*.php", "src/css/**/*.css", "!src/php/*.php"], series(clear_cache, processcss, copy, reload));
};

//Copy
export const copy = () => {
    return src([
        "src/**/*",
        "!src/{images,js,css,scss,php}",
        "!src/{images,js,css,scss,php}/**/*",
    ]).pipe(dest("dist"));
};

// WP POT
export const pot = () => {
    return src(["*.php", "includes/**/*.php", "core/**/*.php"])
        .pipe(
            wpPot({
                domain: process.env.TEXT_DOMAIN,
                package: process.env.PACKAGE,
            })
        )
        .pipe(dest(`languages/zero-theme.pot`));
};


// Del
export const clean = () => del(["dist"]);

// Cache Control

export const clear_cache = (done) =>{
    return cache.clearAll(done);
}

// Scripts
export const scripts = () => {
    return (
        src(["src/js/main.js","src/js/components.js"])
            .pipe(named())
            .pipe(
                webpack({
                    module: {
                        rules: [
                            {
                                test: /\.js$/,
                                use: {
                                    loader: "babel-loader",
                                    options: {
                                        presets: [],
                                    },
                                },
                            },
                        ],
                    },
                    mode: PRODUCTION ? "production" : "development",
                    devtool: !PRODUCTION ? "inline-source-map" : false,
                    output: {
                        filename: "[name].js",
                    },
                })
            )
            .pipe(dest("dist/js"))
    );
};

//Browser Sync
const server = browserSync.create();
export const serve = (done) => {
    server.init({
        proxy: {
            target: process.env.DOMAIN,
            proxyReq: [
                function (proxyReq) {
                    proxyReq.setHeader("Access-Control-Allow-Origin", "*");
                },
            ],
        },
        https: {
            key: process.env.SSL_KEY_FILE,
            cert: process.env.SSL_CERT_FILE,
        },
    });
    done();
};
export const reload = (done) => {
    server.reload();
    done();
};

//ZIP
export const compress = () => {
    return src([
        "**/*",
        "!.idea{,/**}",
        "!.phpdoc{,/**}",
        "!.vscode{,/**}",
        "!node_modules{,/**}",
        "!src{,/**}",
        "!.babelrc",
        "!.env",
        "!.gitignore",
        "!gulpfile.babel.js",
        "!package.json",
        "!package-lock.json",
        "!dist/js/dev.js",
        "!composer.json",
        "!composer.lock",
        "!plugin.code-workspace",
        "!workspace.code-workspace"
    ])
        .pipe(
            rename(
                function (path) {
                    path.dirname = `${info.name}/${path.dirname}`;
                }
            )
        )
        .pipe(zip(`${info.name}-${info.version}.zip`))
        .pipe(dest("../"));
};

// Build e Dev Run
export const dev = series(
    clean,
    parallel(styles, images, copy, scripts, replace_main_style),
    processcss,
    serve,
    watching
);
export const build = series(
    clean,
    parallel(styles, images, copy, scripts, replace_main_style),
    processcss,
    pot
);
export default dev;
