import { startStimulusApp } from '@symfony/stimulus-bridge';
// @ts-ignore
import * as Turbo from '@hotwired/turbo';

if(Turbo) {
    console.log("Symfony UX/Turbo is enabled ✅")
} else {
    console.log("Symfony UX/Turbo is disable ❌")
}

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});