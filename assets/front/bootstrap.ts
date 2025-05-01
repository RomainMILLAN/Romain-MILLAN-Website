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