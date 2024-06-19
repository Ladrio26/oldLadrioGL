const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('main', './assets/styles/main.css')
    .addEntry('common', './assets/styles/common.css')
    .addEntry('footer', './assets/styles/footer.css')
    .addEntry('header', './assets/styles/header.css')
    .addEntry('calendar', './assets/styles/calendar.css')
    .addEntry('llan', './assets/styles/llan.css')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabel(() => {}, {
        useBuiltIns: 'usage',
        corejs: 3
    })

    // enables Sass/SCSS support
    //.enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes()

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()

    //.enablePostCssLoader((options) => {
    //    options.postcssOptions = {
    //        config: './postcss.config.js'
    //    };
    //})
;

module.exports = Encore.getWebpackConfig();
