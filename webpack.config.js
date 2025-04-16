const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    // Ajout des entrées CSS
    .addEntry('main', './assets/styles/main.css')
    .addEntry('common', './assets/styles/common.css')
    .addEntry('footer', './assets/styles/footer.css')
    .addEntry('header', './assets/styles/header.css')
    .addEntry('calendar', './assets/styles/calendar.css')
    .addEntry('llan', './assets/styles/llan.css')
    .addEntry('twitch', './assets/styles/twitch.css')
    .addEntry('buttons', './assets/styles/buttons.css')
    .addEntry('memory', './assets/styles/memory.css')
    .addEntry('morpion', './assets/styles/morpion.css')

    // Ajout des entrées JavaScript
    .addEntry('memoryjs', './assets/js/memory.js')
    .addEntry('morpionjs', './assets/js/morpion.js')
    .addEntry('sketchjs', './assets/js/sketch.js')

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

    // Gestion des fichiers image
    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[ext]',
        pattern: /\.(png|jpg|jpeg|svg)$/
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
