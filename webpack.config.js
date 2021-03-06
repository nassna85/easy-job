var Encore = require('@symfony/webpack-encore');
const CopyPlugin = require ('copy-webpack-plugin');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('js/app', './assets/js/app.js')
    .addEntry('js/apply', './assets/js/apply.js')
    .addEntry('js/showJob', './assets/js/showJob.js')
    .addEntry('js/registration-user', './assets/js/registration-user.js')
    .addEntry('js/newJob', './assets/js/newJob.js')
    .addEntry('js/contact', './assets/js/contact.js')
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')
    .addStyleEntry('css/app', './assets/css/app.scss')
    .addStyleEntry('css/homepage', './assets/css/homepage.scss')
    .addStyleEntry('css/variable', './assets/css/variable.scss')
    .addStyleEntry('css/card-job', './assets/css/card-job.scss')
    .addStyleEntry('css/jobs', './assets/css/jobs.scss')
    .addStyleEntry('css/filter-form', './assets/css/filter-form.scss')
    .addStyleEntry('css/show-job', './assets/css/show-job.scss')
    .addStyleEntry('css/job-by-category', './assets/css/job-by-category.scss')
    .addStyleEntry('css/login-form', './assets/css/login-form.scss')
    .addStyleEntry('css/registration-user-form', './assets/css/registration-user-form.scss')
    .addStyleEntry('css/new-job', './assets/css/new-job.scss')
    .addStyleEntry('css/profile-user', './assets/css/profile-user.scss')
    .addStyleEntry('css/apply-form', './assets/css/apply-form.scss')
    .addStyleEntry('css/page-error', './assets/css/page-error.scss')
    .addStyleEntry('css/contact', './assets/css/contact.scss')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabel(() => {}, {
        useBuiltIns: 'usage',
        corejs: 3
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')
    .addPlugin(new CopyPlugin([
        {from: './assets/images', to: 'images'}
    ]))
;

module.exports = Encore.getWebpackConfig();
