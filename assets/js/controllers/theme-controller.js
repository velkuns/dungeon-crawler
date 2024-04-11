import { Controller } from "@hotwired/stimulus"
import * as cookies from '../cookies';

export default class extends Controller {
    dark() {
        cookies.set('theme', 'dark', 360);
        document.documentElement.setAttribute('data-bs-theme', 'dark');
    }

    light() {
        cookies.set('theme', 'light', 360);
        document.documentElement.setAttribute('data-bs-theme', 'light');
    }
}
