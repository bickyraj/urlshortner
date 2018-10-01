<template>
	<div>
		<h2>Menus</h2>
		<nav aria-label="Page navigation example">
		  <ul class="pagination">
		    <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchMenus(pagination.prev_page_url)">Previous</a></li>
		    <li class="page-item disabled"><a class="page-link" href="">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
		    <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" @click="fetchMenus(pagination.next_page_url)" href="javascript:;">Next</a></li>
		  </ul>
		</nav>
		<div class="card card-body" v-for="menu in menus" v-bind:key="menu.id">
			<h6>{{ menu.name }}</h6>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				menus: [],
				menu: {
					id: '',
					name: '',
				},
				menu_id: '',
				pagination: {},
				edit: false
			}
		},

		created() {
			this.fetchMenus();
		},

		methods: {
			fetchMenus(page_url) {
				let vm = this;
				page_url = page_url || 'api/menus'
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.menus = res.data;
					vm.makePagination(res.meta, res.links);
				})
				.catch(err => console.log(err));
			},

			makePagination(meta, links) {
				let pagination = {
					current_page: meta.current_page,
					last_page: meta.last_page,
					next_page_url: links.next,
					prev_page_url: links.prev
				}

				this.pagination = pagination;
			}
		}
	}
</script>