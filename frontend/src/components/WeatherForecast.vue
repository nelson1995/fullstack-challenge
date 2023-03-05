<script>
export default {
  data: () => ({
    apiResponse: null,
    apiResponse2: null
  }),

  created() {
    this.fetchAllWeatherForecasts()
  },

  methods: {
    async fetchAllWeatherForecasts() {
      const url = 'http://localhost/users-weather-forecast'
      this.apiResponse = await (await fetch(url)).json()
      console.log("response: ",this.apiResponse);
    },
    async fetchForecastDetails(userId) {
      const url2 = 'http://localhost/weather-forecast/details/' + userId
      this.apiResponse2 = await (await fetch(url2)).json()
      console.log("response2: ",this.apiResponse2)
      $('#weather-details').modal('show')
    }, 
  }
}
</script>

<template>
  <div v-if="!apiResponse">
    Pinging the api...
  </div>

  <div v-if="apiResponse">
    <table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th scope="col">User</th>
            <th scope="col">Weather</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="data in apiResponse">
          <td @click='fetchForecastDetails(data.id)'>{{ data.name }}</td>
          <td>{{ data.weatherForecast.current.main }}</td>
        </tr>
    </tbody>
    </table>

    <div class="modal" data-drop="static" id="weather-details">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                  <em class="icon ni ni-cross"></em>
              </a>
              <div class="modal-header row">
                  <div class="modal-title col">
                      <h5 class="text-center">Weather details</h5>
                  </div>
              </div>
              <div class="modal-body">
                <div v-if="!apiResponse2"><i class="fa-solid fa-spinner-third"></i></div>
                <div v-if="apiResponse2">
                <div class="row mb-3">
                  <div class="col">
                    <p>Temperature is {{ apiResponse2.temp }} degrees celsius</p>
                    <p>Feels like {{ apiResponse2.feels_like }} degrees celsius</p>
                    <p>Weather: {{ apiResponse2.weather_main }}</p>
                    <p>Weather description {{ apiResponse2.weather_desc }}</p>
                    <p>Humidity: {{ apiResponse2.humidity }} %</p>
                    <p>Wind speed: {{ apiResponse2.wind_speed }} km/h</p>
                  </div>
                </div>
              </div>
          </div>
        </div>
    </div>
    </div>
  </div>
</template>