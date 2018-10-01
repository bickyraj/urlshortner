<template>
  <div>
    <gmap-autocomplete
      ref="googleAutocompleteInput"
      :value="locationInput"
      @place_changed="setPlace" 
      class="form-control"
      style="margin-bottom:5px;">
    </gmap-autocomplete>
    <button v-if="!hide" class="btn btn-sm btn-blue" @click.prevent="centerMarker" style="margin-bottom: 20px;">center marker</button>
    <span v-if="error" class="help is-danger custom-input-error" style="margin-bottom: 10px;"><i class="fas fa-exclamation-circle"></i> location field is required.</span>
    <gmap-map
      v-if="!hide"
      ref="gMap"
      :center="center"
      :zoom="12"
      style="width:100%;  height: 400px;"
    >
      <gmap-marker
        :key="index"
        :draggable="true"
        v-for="(m, index) in markers"
        @drag="updateCoordinates"
        :position="m.position"
        @click="center=m.position"
      ></gmap-marker>
    </gmap-map>
  </div>
</template>

<script>
export default {
  name: "GoogleMap",
  props: {
      locationInput: {
        type: String,
      },
      // 'item': [Object, Array],
      error: {
        type: Boolean, 
        default: false
      },
      hide: {
        type: Boolean, 
        default: false
      },
  },
  data() {
    return {
      lat: '',
      long: '',
      // default to Montreal to keep it simple
      // change this to whatever makes sense
      center: { lat: 45.508, lng: -73.587 },
      markers: [],
      places: [],
      currentPlace: null,
      coordinates: null,
    };
  },
  mounted() {
    this.geolocate();
  },

  methods: {
    centerMarker() {
      var self = this
      this.$refs.gMap.$mapPromise.then((map) => {
        var c = map.getCenter()
        self.markers = [];
        let marker = {
          lat: c.lat(),
          lng: c.lng()
        };
        self.lat = c.lat()
        self.long = c.lng()

        self.markers.push({ position: marker });
        self.center = marker;
      })
    },
    updateCoordinates(location) {
        this.lat = location.latLng.lat()
        this.long = location.latLng.lng()
        this.coordinates = {
            lat: location.latLng.lat(),
            lng: location.latLng.lng(),
        };
    },
    // receives a place object via the autocomplete component
    setPlace(place) {
      if (place.geometry.location) {
        this.currentPlace = place;
        this.lat = this.currentPlace.geometry.location.lat()
        this.long = this.currentPlace.geometry.location.lng()
        // console.log(this.$refs.googleAutocompleteInput.$el.value);
        this.addMarker();
      } else {
        this.currentPlace = []
      }
    },
    addMarker() {
      this.markers = [];
      this.places = [];
      if (this.currentPlace) {
        const marker = {
          lat: this.currentPlace.geometry.location.lat(),
          lng: this.currentPlace.geometry.location.lng()
        };
        this.markers.push({ position: marker });
        this.places.push(this.currentPlace);
        this.center = marker;
        // this.currentPlace = null;
      }
    },
    setMarker(lat, long) {
      this.markers = [];
      this.places = [];
      const marker = {
        lat: lat,
        lng: long
      };
      this.markers.push({ position: marker });
      // this.places.push(this.currentPlace);
      this.center = marker;
    },
    geolocate: function() {
      navigator.geolocation.getCurrentPosition(position => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
      });
    }
  }
};
</script>