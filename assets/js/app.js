import './../scss/app.scss';

//~ Vendors Libs
import 'bootstrap';
import { Application } from "@hotwired/stimulus"
import { definitionsFromContext } from "@hotwired/stimulus-webpack-helpers"

//~ Load images for the build
const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);

//~ Stimulus controllers autoloader
window.Stimulus = Application.start()
const context = require.context("./controllers", true, /\.js$/)
Stimulus.load(definitionsFromContext(context))

document.addEventListener('DOMContentLoaded', () => {
});
