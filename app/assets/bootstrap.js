import { startStimulusApp } from '@symfony/stimulus-bundle';
import { Turbo } from '@hotwired/turbo-rails';

const app = startStimulusApp();
// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);

if (Turbo) {
    console.log('✅ Turbo is enabled');
} else {
    console.log('❌ Turbo is not enabled');
}