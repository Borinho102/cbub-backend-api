const mix = require("laravel-mix")
const tailwindcss = require("tailwindcss")

mix
    .js("resources/js/cbub-backend.js", "public/build/cbub-backend.js")
    .js("resources/js/cbub-frontend.js", "public/build/cbub-frontend.js")
    .css("resources/css/cbub-backend.css", "public/build/cbub-backend.css")
    .css("resources/css/cbub-frontend.css", "public/build/cbub-frontend.css")
    .css("resources/css/tailwind-base.css", "public/build/tailwind-base.css")
    .css("resources/css/tailwind-utilities.css", "public/build/tailwind-utilities.css")
    .css("resources/css/tailwind-components.css", "public/build/tailwind-components.css")
    .options({
        processCssUrls: false,
        postCss: [
            tailwindcss('tailwind.config.js'),
        ],
    })
    .browserSync("cbub.test")
    .version()
