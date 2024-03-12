const mix = require("laravel-mix")
const tailwindcss = require("tailwindcss")

mix
    .js("resources/js/cbub-backend.js", "public/dist/cbub-backend.js")
    .js("resources/js/cbub-frontend.js", "public/dist/cbub-frontend.js")
    .css("resources/css/cbub-backend.css", "public/dist/cbub-backend.css")
    .css("resources/css/cbub-frontend.css", "public/dist/cbub-frontend.css")
    .css("resources/css/tailwind.css", "public/dist/tailwind.css")
    .options({
        processCssUrls: false,
        postCss: [
            tailwindcss('tailwind.config.js'),
        ],
    })
    .browserSync("cbub.test")
    .version()
