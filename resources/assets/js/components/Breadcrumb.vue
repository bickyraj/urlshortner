<template>
  <ol class="breadcrumb">
    <li class="breadcrumb-item" :key="index" v-for="(item, index) in list">
      <span class="active" v-if="isLast(index)">{{ showName(item) }}</span>
      <router-link :to="showPath(item)" v-else>{{ showName(item) }}</router-link>
    </li>
  </ol>
</template>
<style>
  .breadcrumb {
    border-bottom: 1px solid #e2e2e2;
  }
</style>

<script>
export default {
  props: {
    list: {
      type: Array,
      required: true,
      default: () => []
    }
  },
  created: function() {
  },
  methods: {
    isLast (index) {
      return index === this.list.length - 1
    },
    showName (item) {
      if (item.meta && item.meta.label) {
        item = item.meta && item.meta.label
      }
      if (item.name) {
        item = item.name
      }
      return item
    },
    showPath (item) {
      let vm = this;
      if (item.path) {
        item = item.path
        var path_array =  item.split( '/' );
        path_array.forEach(function(v, i) {
          if (v.match(/:/)) {
             let param = v.slice(1);
             v = vm.$route.params[param]
             path_array[i] = v
          }
        })

        item = path_array.join('/')
      }
      return item
    }
  }
}
</script>
