const process = require('node:process')
const path = require('node:path')
const Encore = require('@symfony/webpack-encore')

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured())
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev')

Encore
  // directory where compiled assets will be stored
  .setOutputPath('public/build/app')
  // public path used by the web server to access the output path
  .setPublicPath('/build/app')
  // only needed for CDN's or subdirectory deploy
  .setManifestKeyPrefix('build/app')

  /*
    * ENTRY CONFIG
    *
    * Each entry will result in one JavaScript file (e.g. app.js)
    * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
    */
  .addEntry('app', './assets/app/app.ts')

  // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
  .splitEntryChunks()

  // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
  .enableStimulusBridge('./assets/app/controllers.json')

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

  .configureBabel((babelConfig) => {
    //
  }, {
    // node_modules is not processed through Babel by default
    // but you can whitelist specific modules to process
    includeNodeModules: ['foundation-sites'],
  })

  // enables and configure @babel/preset-env polyfills
  .configureBabelPresetEnv((config) => {
    config.useBuiltIns = 'usage'
    config.corejs = '3.23'
  })

  // enables Sass/SCSS support
  //.enableSassLoader()

  // uncomment if you use TypeScript
  .enableTypeScriptLoader()

  // uncomment if you use React
  // .enableReactPreset()

  // uncomment to get integrity="..." attributes on your script & link tags
  // requires WebpackEncoreBundle 1.4 or higher
  //.enableIntegrityHashes(Encore.isProduction())

  // uncomment if you're having problems with a jQuery plugin
  //.autoProvidejQuery()

  .copyFiles([
    {
      from: './assets/app/static',
      to: 'static/[path][name].[ext]'
    }
  ])
  .copyFiles([
    {
      from: './assets/app/pwa',
      to: 'pwa/[path][name].[ext]'
    }
  ])

const App = Encore.getWebpackConfig()
App.name = 'app'
Encore.reset()

module.exports = App
