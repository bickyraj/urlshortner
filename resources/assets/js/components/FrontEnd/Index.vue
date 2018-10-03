<template>
	<div class="animated">
		<b-container>
			<b-row style="margin-top: 20px;">
				<b-col>
					<div class="pull-right">
						<router-link title="Admin Login" :to="{ name: 'login'}" class="mr-1 btn btn-sm btn-primary"><i class="fa fa-user"></i> Admin Login</router-link>
					</div>
				</b-col>
			</b-row>
			<b-row class="justify-content-md-center" style="margin-top: 50px;">
				<a href="" class="navbar-brand gym-navbar-brand" target="_self"> Url Shortner </a>
			</b-row>
			  <b-row class="justify-content-md-center">
			    <b-col cols="9" class="col-centered">
			      <b-card class="mb-2">
			        <div class="card-title">
			          <b-col cols="12">
			          	<form @submit.prevent="addLink" ref="addLinkForm">
				            <div class="input-group">
				              <input type="url" ref="lookupShortUrl" name="url" class="form-control" placeholder="Enter url" required>
				              <div class="input-group-text">Expiration Time</div>
				              <div class="input-group-append">
			                    <date-picker v-model="date" autocomplete="off" name="expiration_time" :config="config"></date-picker>
				              </div>
				              <div class="input-group-append">
				                <button type="submit" class="btn btn-outline-success">Shorten Url</button>
				              </div>
				            </div>
			          	</form>
			          </b-col>
			        </div>
			        <div class="card-body" v-show="shortUrlLink != ''">
			        	The short url for <strong><i>{{ longUrl }}</i></strong> is
			        	<a :href="appUrl + '/shortUrl/' + shortUrlLink" target="_blank">{{ appUrl + '/shortUrl/' + shortUrlLink }}</a>
			        </div>
			      </b-card>
			    </b-col>
			  </b-row>
		</b-container>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				appUrl: this.$root.baseUrl,
				shortUrlLink: '',
				longUrl: '',
				date: '',
				config: {
				  format: 'YYYY-MM-DD',
				  useCurrent: false,
				  showClear: true,
				  showClose: true,
				}
			}
		},
		methods: {
			addLink: function() {
			  var self = this;
			  var form = self.$refs.addLinkForm;
			  var formData = new FormData(form);
			  let url = this.$root.baseUrl + '/api/link';
			  axios.post(url, formData).then(function(response) {
			      if (response.status === 201) {
			      	self.shortUrlLink = response.data.data.code
			      	self.longUrl = response.data.data.url
			        $(form)[0].reset();
			        self.$toastr.s("A link has been added.");
			      } else {
			        self.$toastr.i("This link already exists.");
			      }
			    })
			    .catch(function(error) {});
			},
		}
	}
</script>