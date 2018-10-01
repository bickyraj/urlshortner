<template>
	<div v-if="showSideModal" class="yenkii-side-modal animated fadeIn">
	  <div class="yenkii-side-modal-container animated slideInRight">
	      <div class="yenkii-close-side-modal" @click="hideSideMoal()"><i class="fas fa-times"></i></div>
	      <b-card class="mb-2 trump-card yenkii-side-modal-card custom-client-detail-card">
	        <div class="card-title">
	          <div class="caption">
	            <h5><i class="fas fa-image"></i> Banner</h5>
	          </div>
	        </div>
	        <form class="custom-form" @submit.prevent="addBanner('addBannerForm')" ref="addBannerForm" data-vv-scope="addBannerForm">
	          <div class="form-group">
	            <input type="hidden" name="client_id" v-bind:value="client.id">
	          </div>
	          <div class="form-group">
	            <label for="">Name</label>
	            <input v-validate="'required'" name="name" class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" value="" placeholder="" />
	            <span v-show="errors.has('addBannerForm.name')" class="help is-danger custom-input-error"><i v-show="errors.has('addBannerForm.name')" class="fas fa-exclamation-circle"></i> {{ errors.first('addBannerForm.name') }}</span>
	          </div>
	          <div class="form-group">
	            <label for="">Original Price</label>
	            <input v-validate="'required'" name="original_price" class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" value="" placeholder="" />
	            <span v-show="errors.has('addBannerForm.original_price')" class="help is-danger custom-input-error"><i v-show="errors.has('addBannerForm.original_price')" class="fas fa-exclamation-circle"></i> {{ errors.first('addBannerForm.original_price') }}</span>
	          </div>
	          <b-btn class="mt-3 pull-right" variant="primary" type="submit">Publish</b-btn>
	          <b-btn class="mt-3 pull-right" style="margin-right:5px;" variant="default" @click="hideSideMoal">Cancel</b-btn>
	        </form>
	      </b-card>
	  </div>
	</div>
</template>
<script>
  export default {
    data() {
      return {
        showSideModal: false,
      }
    },
    methods: {
      showYenkiiSideModal() {
        this.showSideModal = true;
        document.body.style.overflow = 'hidden';
      },
      hideSideMoal() {
        this.showSideModal = false;
        document.body.style.overflow = 'inherit';
      },
    }
  }
</script>