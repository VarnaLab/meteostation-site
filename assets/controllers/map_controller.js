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
    static values = {
        filter: {type: String, default: 'temperature'},
        sensorsData: {type: Array, default: []}
    }
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
        const sensorBoundaries = {
            "temp": {
                "low": {"value": 0},
                "medium": {"value": 20},
                "high": {"value": 30}
            },
            "pm25": {
                "low": {"value": 5},
                "medium": {"value": 10},
                "high": {"value": 20}
            }
        }

        this.load()
        // setInterval(this.load, 5000) //TODO: Update on couple of minutes
    }

    filterValueChanged() {
        this.load()
        this.render()
    }

    sensorsDataValueChanged() {
        this.render()
    }

    /**
     * Load data from server
     */
    load() {
        fetch(`/stations`)
            .then(response => response.json())
            .then(data => {
                this.sensorsDataValue = data
                    .map(station => {
                        station.measurements = JSON.parse(station.value)
                        if (!Array.isArray(station.measurements)) {
                            station.measurements = [station.measurements]
                        }

                        station.measurements =
                            station.measurements.filter(m => {
                                return Object.keys(m.data).filter(k => k === this.filterValue).length > 0
                            })

                        return station
                    })
                    .filter(station => station.measurements.length > 0)
            })
    }

    /**
     * Rerender based on current data and filters
     */
    render() {
        this.layer && this.layer.clearLayers()
        this.sensorsDataValue.forEach(s => {
            const data = s.measurements[0].data
            const popupData = `<h4>${s.name}</h4><table>` +
                Object.keys(data)
                    .filter(d => d === this.filterValue)
                    .reduce((acc, key) => acc + `<tr><th>${key}:</th> <td>${data[key]}</td></tr>`, '') +
                '</table>'

            L.marker(
                {lon: s.lng, lat: s.lat},
                {icon: this.markerIcon}
            )
                .bindPopup(popupData) //TODO: On separate layer
                .addTo(this.layer);
        })
    }

    filter(event) {
        this.filterValue = event.params['filter']
    }
}
