<template>
  <div class="animated">
    <b-row>
      <b-col>
        <b-card class="mb-2 trump-card">
          <div class="card-title">
            <div class="caption">
              <h5><i class="fas fa-key"></i> Roles</h5>
            </div>
            <div class="caption card-title-actions">
              <b-button @click="showModal" variant="primary" class="btn btn-sm green pull-right">Add New Role</b-button>
              <b-modal class="ess-modal" ref="myModalRef" hide-footer title="Add Role">
                <form @submit.prevent="addRole" ref="addRoleForm">
                  <div class="form-group">
                    <label for="exampleFormControlInput1">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="" required>
                  </div>
                  <b-btn class="mt-3 pull-right" variant="primary" type="submit">Create Role</b-btn>
                  <b-btn class="mt-3 pull-right" style="margin-right:5px;" variant="default" @click="hideModal">Cancel</b-btn>
                </form>
              </b-modal>
            </div>
          </div>
          <table class="table trump-table table-hover">
            <thead>
              <tr>
                <th>Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody v-if="table_items.length > 0" v-show="!loading">
              <tr v-for="(role, index) in table_items" :key="role.id">
                <td>{{ role.name }}</td>
                <td>
                  <b-button size="sm" @click.stop="info(role, index, $event.target)" class="mr-1 btn-success">
                    Edit
                  </b-button>
                  <b-button size="sm" @click="deleteRole(role, index, $event.target)" class="mr-1 btn-danger">
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
      <form @submit.prevent="editRole" :row="modalInfo.row" ref="editRoleForm">
        <input type="hidden" name="id" :value="modalInfo.data.id">
        <div class="form-group">
          <label for="exampleFormControlInput1">Name</label>
          <input type="text" name="name" v-bind:value="modalInfo.data.name" class="form-control" placeholder="" required>
        </div>
        <b-btn class="mt-3 pull-right" variant="primary" type="submit">Update</b-btn>
        <b-btn class="mt-3 pull-right" style="margin-right:5px;" variant="default" @click="hideRoleModal">Cancel</b-btn>
      </form>
    </b-modal>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        loading: true,
        table_items: [],
        role_table_fields: ['name', 'action'],
        modalInfo: {
          title: '',
          content: '',
          data: []
        },
      }
    },
    created() {
      // let socket = io(`http://localhost:3000`);

      // socket.on('connect', function() {
      //   if (socket.connect) {
      //     console.log('connected bro');
      //   }
      // });
      this.fetchRoles();
      // socket.on("test-channel:App\\Events\\TestNotification", function(message){
      //     // increase the power everytime we load test route
      //     // alert(parseInt(message.data.power))
      //     console.log(message.data.users);
      // });
    },
    computed: {
      // edit_option_for_parent_role: function (roleOptionId, parentId, roleId) {
      //  console.log(roleOptionId);
      // }
    },
    methods: {
      info(item, index, button) {
        let self = this;
        axios.get('../api/admin/role/' + item.id).then(function(response) {
            if (response.status === 200 || response.status === 201) {
              self.modalInfo.row = index
              self.modalInfo.title = `Edit Role`
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
        this.modalInfo.title = 'Edit Role'
        this.modalInfo.content = ''
      },
      editRole: function() {
        var self = this;
        var form = self.$refs.editRoleForm;
        var row_index = form.getAttribute('row');
        var formData = new FormData(form);
        axios.post('../api/admin/edit-role', formData).then(function(response) {
            if (response.status === 200) {
              var role = response.data.data;
              self.table_items[row_index].name = role.name;
              self.hideRoleModal();
              self.$swal({
                // position: 'top-end',
                type: 'success',
                title: 'Role updated successfully.',
                showConfirmButton: true,
                // timer: 1500,
                customClass: 'crm-swal',
                confirmButtonText: 'Thanks',
              })
            }
          })
          .catch(function(error) {});
      },
      deleteRole: function(item, row, event) {
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
            axios.delete('../api/admin/role/' + item.id).then(function(response) {
                if (response.status === 200) {
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
                    if (result.value) {}
                  })
                }
              })
              .catch(function(error) {});
          }
        })
      },
      addRole: function() {
        var self = this;
        var form = self.$refs.addRoleForm;
        var formData = new FormData(form);
        var des = this.getAddRoleContent;
        formData.append('description', des);
        axios.post('../api/admin/role', formData).then(function(response) {
            if (response.status === 201) {
              var role = response.data.data;
              var role_data = {
                id: role.id,
                name: role.name,
              }
              self.table_items.push(role_data);
              $(form)[0].reset();
              self.hideModal();
              self.$toastr.s("A role has been added.");
            }
          })
          .catch(function(error) {});
      },
      fetchRoles(role_url) {
        let vm = this;
        role_url = role_url || '../api/admin/roles'
        axios.get(role_url)
          .then(function(response) {
            var role_itmes = response.data.data;
            vm.table_items = role_itmes.map(obj => {
              var rObj = {};
              rObj['id'] = obj.id;
              rObj['name'] = obj.name;
              return rObj;
            })
            vm.loading = false;
          })
          .catch(function(error) {
            console.log(error);
            vm.loading = false;
          });
      },
      showModal() {
        this.$refs.myModalRef.show()
      },
      hideModal() {
        this.$refs.myModalRef.hide()
      },
      hideRoleModal() {
        this.$refs.editModal.hide();
      },
    },
  }
</script>