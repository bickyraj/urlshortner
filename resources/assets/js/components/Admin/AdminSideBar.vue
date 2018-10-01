<template>
	<div>
		<div class="page-sidebar-wrapper">
		    <div class="page-sidebar navbar-collapse collapse">
		        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
		            <li class="sidebar-toggler-wrapper hide">
		                <div class="sidebar-toggler">
		                    <span></span>
		                </div>
		            </li>
		            <li v-bind:class="{ active:$route.path == '/laravelapps/laravel5/ess/public/admin' }">
			            <router-link to="/laravelapps/laravel5/ess/public/admin" class="nav-link">
			                <i class="icon-home"></i>
			                <span class="nav-link-text">Dashboard</span>
			            </router-link>
		            </li>
		            <li v-bind:class="{ active:$route.path == '/laravelapps/laravel5/ess/public/admin/menus' }">
			            <router-link to="/laravelapps/laravel5/ess/public/admin/menus" class="nav-link">
			                <i class="icon-home"></i>
			                <span class="nav-link-text">Menu</span>
			            </router-link>
		            </li>
		        </ul>
		    </div>
		    <!-- END SIDEBAR -->
		</div>
	</div>
</template>