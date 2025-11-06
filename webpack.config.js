const App = require('./webpack-app.config')
const Front = require('./webpack-front.config')
const Panel = require('./webpack-panel.config')
const Pwa = require('./webpack-pwa.config')



const Signature = require('./webpack-signature.config')



module.exports = [App, Front, Signature, Panel, Pwa]
