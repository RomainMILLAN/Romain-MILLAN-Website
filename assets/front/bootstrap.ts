import { startStimulusApp } from '@symfony/stimulus-bridge';
// @ts-ignore
import * as Turbo from '@hotwired/turbo';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));