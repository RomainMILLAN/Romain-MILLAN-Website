/* eslint-disable flowtype/require-valid-file-annotation */
/* eslint-disable import/no-nodejs-modules*/
/* eslint-disable no-undef */
const path = require('path');
const webpackConfig = require('../../vendor/sulu/sulu/webpack.config.js');

module.exports = (env, argv) => {
    env = env ? env : {};
    argv = argv ? argv : {};

    env.project_root_path = path.resolve(__dirname, '..', '..');
    env.node_modules_path = path.resolve(__dirname, 'node_modules');

    const config = webpackConfig(env, argv);
    config.entry = path.resolve(__dirname, 'index.js');

    // Memory tuning for the production build (small VPS / Docker build → avoid OOM, exit 137).
    // The Sulu admin bundle is huge (all core bundles + CKEditor + React + MobX); the two
    // dominant memory consumers are source-map generation and Terser's parallel workers
    // (which are NOT bounded by NODE_OPTIONS=--max-old-space-size).
    if (argv.mode === 'production') {
        // Source maps for the whole admin bundle are the single biggest memory hog.
        config.devtool = false;

        // Force Terser to a single worker so minification stays within the heap limit
        // instead of spawning one unbounded worker process per CPU core.
        const TerserPlugin = require(path.resolve(env.node_modules_path, 'terser-webpack-plugin'));
        config.optimization = config.optimization || {};
        config.optimization.minimizer = (config.optimization.minimizer || []).map((minimizer) =>
            minimizer === '...' ? new TerserPlugin({parallel: false}) : minimizer
        );
    }

    return config;
};
