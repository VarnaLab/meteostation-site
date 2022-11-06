import {Controller} from '@hotwired/stimulus';
import "leaflet/dist/leaflet.css";
import "leaflet/dist/images/marker-shadow.png";
import L from 'leaflet';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    map = null;
    layer = null;

    async initialize() {
        super.initialize();

        this.markerIcon = L.icon({
            iconUrl: require('../icons/marker.png')
        });
    }

    connect() {
        this.map = L.map('map').setView({lon: 27.90430, lat: 43.21665}, 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
        }).addTo(this.map);

        this.layer = L.layerGroup().addTo(this.map);

        const ff = () => {
            fetch(`/stations`)
                .then(response => response.json())
                .then(data => {
                    this.layer.clearLayers()
                    data.forEach(station => {
                        let measurements = JSON.parse(station.value).data
                        let popupData = `<h4>${station.name}</h4><table>`+
                            Object.keys(measurements)
                                .reduce((acc, key) => acc + `<tr><th>${key}:</th> <td>${measurements[key]}</td></tr>`, '') +
                            '</table>'

                        L.marker(
                            {lon: station.lng, lat: station.lat},
                            {icon: this.markerIcon}
                        )
                            .bindPopup(popupData) //TODO: On separate layer
                            .addTo(this.layer);
                    })
                })
        }

        ff()
        setInterval(ff, 5000)
    }
}
