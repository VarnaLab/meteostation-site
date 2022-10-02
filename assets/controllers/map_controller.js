import {Controller} from '@hotwired/stimulus';
import "leaflet/dist/leaflet.css";
import L from 'leaflet';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        const map = L.map('map').setView({lon: 27.90430, lat: 43.21665}, 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
        }).addTo(map);

        // For testing - marked on VarnaLab
        L.marker({lon: 27.90430, lat: 43.21665}).bindPopup('VarnaLab').addTo(map);
    }
}