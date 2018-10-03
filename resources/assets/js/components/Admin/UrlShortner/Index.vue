<template>
  <div class="animated">
    <b-row v-if="notification != 0">
      <b-col>
        <b-card class="mb-2">
          <div class="card-title">
            <b-col cols="5">
              <h6>Notification from the socket</h6>
              <h5>{{ notification }}</h5>
            </b-col>
          </div>
        </b-card>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-card class="mb-2">
          <div class="card-title">
            <b-col cols="5">
              <h6>Lookup Short Url</h6>
              <v-select  
                v-model="selectedUrl" 
                  ref="selectShortUrlList"
                  :options="shortUrlList"
                  @input="lookupShortUrl"       
                ></v-select>
            </b-col>
            <!-- <b-col cols="4">
              <div class="input-group">
                <input type="url" ref="lookupShortUrl" class="form-control" placeholder="Short url" required>
                <div class="input-group-append">
                  <button type="button" @click="lookupShortUrl" class="btn btn-outline-success">Lookup</button>
                </div>
              </div>
            </b-col> -->
          </div>
          <div v-if="shortUrlData">
            <table class="table trump-table table-hover">
              <thead>
                <tr>
                  <th>Short Url</th>
                  <th>Url</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><a :href="appUrl + '/shortUrl/' + shortUrlData.code" target="_blank">{{ appUrl + '/shortUrl/' + shortUrlData.code }}</a></td>
                  <td>{{ shortUrlData.url }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-else>
            <b-col>
              <div v-show="noShortUrl"> No Data.</div>
              <div v-show="shortUrlLoading"> loading...</div>
            </b-col>
          </div>
        </b-card>
      </b-col>
    </b-row>

    <b-row>
      <b-col>
        <b-card class="mb-2 trump-card">
          <div class="card-title">
            <div class="caption">
              <h5><i class="fas fa-link"></i> Url Shortner</h5>
            </div>
            <div class="caption card-title-actions pull-right">
              <b-button @click="showModal" variant="primary" class="btn btn-sm green pull-right">Add New</b-button>
              <b-modal class="ess-modal" ref="myModalRef" hide-footer title="Add Link">
                <form @submit.prevent="addLink" ref="addLinkForm">
                  <div class="form-group">
                    <label for="exampleFormControlInput1">Url</label>
                    <input type="url" name="url" class="form-control" placeholder="" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlInput1">Expiration Time</label>
                    <date-picker v-model="date" autocomplete="off" name="expiration_time" :config="config"></date-picker>
                  </div>
                  <b-btn class="mt-3 pull-right" variant="primary" type="submit">Create Short Link</b-btn>
                  <b-btn class="mt-3 pull-right" style="margin-right:5px;" variant="default" @click="hideModal">Cancel</b-btn>
                </form>
              </b-modal>
            </div>
            <b-col cols="4" class="pull-right">
              <input type="url" id="searchUrl" @keyup="searchUrl" class="form-control form-control-sm" placeholder="Search by long url name" required>
            </b-col>
          </div>
          <table class="table trump-table table-hover">
            <thead>
              <tr>
                <th>Url</th>
                <th>Short Url</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody v-if="table_items.length > 0" v-show="!loading">
              <tr v-for="(link, index) in table_items" :key="link.id">
                <td>{{ link.url }}</td>
                <td><a :href="appUrl + '/shortUrl/' + link.code" target="_blank">{{ appUrl + '/shortUrl/' + link.code }}</a></td>
                <td>
                  <b-button size="sm" @click.stop="info(link, index, $event.target)" class="mr-1 btn-success">
                    View
                  </b-button>
                  <b-button size="sm" @click="deleteLink(link, index, $event.target)" class="mr-1 btn-danger">
                    Delete
                  </b-button>
                </td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr>
                <td colspan="2">
                  <div v-if="!loading"> No Data.</div>
                  <div v-else> loading...</div>
                </td>
              </tr>
            </tbody>
          </table>
        </b-card>
      </b-col>
    </b-row>
    <!-- Info modal -->
    <b-modal class="ess-modal" id="modalInfo" ref="editModal" hide-footer @hide="resetModal" :title="modalInfo.title">
      <!-- <pre>{{ modalInfo.data }}</pre> -->
      <form :row="modalInfo.row" ref="editLinkForm">
        <input type="hidden" name="id" :value="modalInfo.data.id">
        <div class="form-group">
          <label for="exampleFormControlInput1">Url</label>
          <div><b>{{ modalInfo.data.url }}</b></div>
        </div>
        <hr>
        <div class="form-group">
          <label for="exampleFormControlInput1">Short Link</label>
          <div><b>{{ appUrl + '/shortUrl/' + modalInfo.data.code }}</b></div>
        </div>
        <hr>
        <div class="form-group">
          <label for="exampleFormControlInput1">Counter</label>
          <div><b>{{ modalInfo.data.counter }}</b></div>
        </div>
        <div class="form-group">
          <label for="exampleFormControlInput1">Expiration Time</label>
          <div><b>{{ modalInfo.data.expiration_time }}</b></div>
        </div>
        <!-- <b-btn class="mt-3 pull-right" variant="primary" type="submit">Update</b-btn>
        <b-btn class="mt-3 pull-right" style="margin-right:5px;" variant="default" @click="hideLinkModal">Cancel</b-btn> -->
      </form>
    </b-modal>
  </div>
</template>
<style>
  .dropdown-toggle::after {
      display: none !important;
      width: 0;
      height: 0;
      margin-left: 0.255em;
      vertical-align: 0.255em;
      content: "";
      border-top: 0.3em solid;
      border-right: 0.3em solid transparent;
      border-bottom: 0;
      border-left: 0.3em solid transparent;
  }
</style>
<script>
  export default {
    data() {
      return {
        notification: 0,
        selectedUrl: '',
        shortUrlList: [],
        shortUrlData: null,
        appUrl: this.$root.baseUrl,
        loading: true,
        shortUrlLoading: false,
        noShortUrl: false,
        timer: 500,
        table_items: [],
        link_table_fields: ['name', 'action'],
        modalInfo: {
          title: '',
          content: '',
          data: []
        },
        date: '',
        config: {
          format: 'YYYY-MM-DD',
          useCurrent: false,
          showClear: true,
          showClose: true,
        }
      }
    },
    created() {
      let self = this;
      this.fetchLinks();
      this.fetchShortUrlList();
      let socket = io(`http://localhost:3000`);

      socket.on('connect', function() {
        if (socket.connect) {
          console.log('connected successfully');
        }
      });
      socket.on("test-channel:App\\Events\\TestNotification", function(message){
          // increase the power everytime we load test route
          // alert(parseInt(message.data.power))

          self.notification ++; 
          self.$toastr.s('You just called an event.');

          console.log(message.data.links);
      });
    },
    methods: {
      lookupShortUrl(event) {
        let self = this;
        // let shortUrl = self.$refs.lookupShortUrl.value;
        let shortUrl = this.selectedUrl;
        if (shortUrl != "" && shortUrl != null) {
          self.noShortUrl = false;
          self.shortUrlLoading = true;
          if (self.timer) {
              clearTimeout(self.timer);
              self.timer = null;
          }
          self.timer = setTimeout(() => {
            let url = self.$root.baseUrl + '/api/admin/link/lookupShortUrl';
            axios.post(url, { shortUrl: shortUrl }).then(function(response) {
              if ((response.status === 200 || response.status === 201) && response.data.status == 1) {
                self.shortUrlData = response.data.data;
              } else {
                self.shortUrlData = null;
                self.noShortUrl = true;
              }
            })
            .catch(function(error) {
              self.$toastr.e('Something went wrong please try again.');
            });
            self.shortUrlLoading = false;
          }, 800);
        } else {
          self.shortUrlData = null;
          self.noShortUrl = false;
          self.shortUrlLoading = false;
        }
      },
      searchUrl(event) {
        let keyword = event.target.value;
        let self = this;
        self.loading = true;
        self.table_items = [];
        if (self.timer) {
            clearTimeout(self.timer);
            self.timer = null;
        }
        self.timer = setTimeout(() => {
          let url = self.$root.baseUrl + '/api/admin/link/searchUrl';
          axios.post(url, { keyword: keyword }).then(function(response) {
            if (response.status === 200 || response.status === 201) {
              var link_items = response.data.data;
              self.table_items = link_items.map(obj => {
                var rObj = {};
                rObj['id'] = obj.id;
                rObj['url'] = obj.url;
                rObj['code'] = obj.code;
                rObj['counter'] = obj.counter;
                rObj['expiration_time'] = obj.expiration_time;
                return rObj;
              })
              self.loading = false;
            }
          })
          .catch(function(error) {
            self.$toastr.e('Something went wrong please try again.');
            self.loading = false;
          });
        }, 800);
      },
      info(item, index, button) {
        let self = this;
        let url = this.$root.baseUrl + '/api/admin/link/';
        axios.get(url + item.id).then(function(response) {
          if (response.status === 200 || response.status === 201) {
            self.modalInfo.row = index
            self.modalInfo.title = `Detail`
            self.modalInfo.data = response.data.data
            self.modalInfo.content = JSON.stringify(response.data.data, null, 2)
            self.$root.$emit('bv::show::modal', 'modalInfo', button)
          }
        })
        .catch(function(error) {
          self.$toastr.e('Something went wrong please try again.');
        });
      },
      resetModal() {
        this.modalInfo.title = 'Edit Link'
        this.modalInfo.content = ''
      },
      editLink: function() {
        var self = this;
        var form = self.$refs.editLinkForm;
        var row_index = form.getAttribute('row');
        var formData = new FormData(form);
        let url = this.$root.baseUrl + '/api/admin/edit-link';
        axios.post(url, formData).then(function(response) {
            if (response.status === 200) {
              var link = response.data.data;
              self.table_items[row_index].name = link.name;
              self.hideLinkModal();
              self.$swal({
                // position: 'top-end',
                type: 'success',
                title: 'Link updated successfully.',
                showConfirmButton: true,
                // timer: 1500,
                customClass: 'crm-swal',
                confirmButtonText: 'Thanks',
              })
            }
          })
          .catch(function(error) {});
      },
      deleteLink: function(item, row, event) {
        var self = this;
        self.$swal({
          // position: 'top-end',
          type: 'info',
          title: 'Are you sure you want to delete this?',
          showConfirmButton: true,
          showCancelButton: true,
          // timer: 1500,
          customClass: 'crm-swal',
          confirmButtonText: 'Yes',
        }).then((result) => {
          if (result.value) {
            let url = this.$root.baseUrl + '/api/admin/link/';
            axios.delete(url + item.id).then(function(response) {
              })
              .catch(function(error) {
                if (error.response.status === 410) {
                  self.table_items.splice(row, 1);
                  self.$swal({
                    // position: 'top-end',
                    type: 'success',
                    title: 'Deleted',
                    showConfirmButton: true,
                    // timer: 1500,
                    customClass: 'crm-swal',
                    confirmButtonText: 'Ok',
                  }).then((result) => {
                    if (result.value) {
                      self.fetchShortUrlList();
                    }
                  })
                }
              });
          }
        })
      },
      addLink: function() {
        var self = this;
        var form = self.$refs.addLinkForm;
        var formData = new FormData(form);
        let url = this.$root.baseUrl + '/api/admin/link';
        axios.post(url, formData).then(function(response) {
            if (response.status === 201) {
              var link = response.data.data;
              var link_data = {
                id: link.id,
                url: link.url,
                code: link.code,
                counter: link.counter,
              }
              self.table_items.push(link_data);
              $(form)[0].reset();
              self.hideModal();
              self.fetchShortUrlList();
              self.$toastr.s("A link has been added.");
            } else {
              self.$toastr.i("This link already exists.");
            }
          })
          .catch(function(error) {});
      },
      fetchShortUrlList(link_url) {
        let vm = this;
        let url = this.$root.baseUrl + '/api/admin/link/getShortUrlList';
        axios.get(url)
          .then(function(response) {
            vm.shortUrlList = response.data.data;
          })
          .catch(function(error) {
          });
      },
      fetchLinks(link_url) {
        let vm = this;
        let url = this.$root.baseUrl + '/api/admin/links';
        axios.get(url)
          .then(function(response) {
            // console.log(response.data);
            var link_items = response.data.data;
            vm.table_items = link_items.map(obj => {
              var rObj = {};
              rObj['id'] = obj.id;
              rObj['url'] = obj.url;
              rObj['code'] = obj.code;
              rObj['counter'] = obj.counter;
              rObj['expiration_time'] = obj.expiration_time;
              return rObj;
            })
            vm.loading = false;
          })
          .catch(function(error) {
            vm.loading = false;
          });
      },
      showModal() {
        this.$refs.myModalRef.show()
      },
      hideModal() {
        this.$refs.myModalRef.hide()
      },
      hideLinkModal() {
        this.$refs.editModal.hide();
      },
    },
  }
</script>