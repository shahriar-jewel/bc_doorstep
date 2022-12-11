<?php  
$_segments = Request::segments();
$_routeName = request()->route()->getName();
$_userType = session()->get('doorstepuser.usertype');

?>
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
			<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
			<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
			<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
			<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- END SIDEBAR TOGGLER BUTTON -->
				</li>
				<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
				<li class="sidebar-search-wrapper">
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
					<!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
					<form class="sidebar-search " action="extra_search.html" method="POST">
						<a href="javascript:;" class="remove">
						<i class="icon-close"></i>
						</a>
						<div class="input-group">
							<!-- <input type="text" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
							<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
							</span> -->
						</div>
					</form>
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
				<li class="{{ $_segments[0] == 'dashboard' ? 'start active open' : '' }}">
					<a href="javascript:;">
					<i class="icon-speedometer"></i>
					<span class="title">Dashboard</span>
					<span class="selected"></span>
					<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class=" {{ $_routeName == 'dashboard.index' ? 'active' : '' }} ">
							<a href="{{ route('dashboard.index') }}">
							<i class="icon-bar-chart"></i>
							Default Dashboard</a>
						</li>
					</ul>
				</li>
				<li class="{{ $_segments[0] == 'member' ? 'start active open' : '' }}">
					<a href="javascript:;">
					<i class="icon-rocket"></i>
					<span class="title">Member</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li class=" {{ $_routeName == 'member.create' ? 'active' : '' }} ">
							<a href="{{ route('member.create') }}">
							<i class="icon-plus"></i>
							Create</a>
						</li>
						<li class=" {{ $_routeName == 'member.index' ? 'active' : '' }} ">
							<a href="{{ route('member.index') }}">
							<i class="icon-tag"></i>
							View All</a>
						</li>
					</ul>
				</li>
				<li class="{{ $_segments[0] == 'order' ? 'start active open' : '' }}">
					<a href="javascript:;">
					<i class="icon-basket"></i>
					<span class="title">Order</span>
					<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class=" {{ $_routeName == 'order.create' ? 'active' : '' }} ">
							<a href="{{ route('order.create') }}">
							<i class="icon-basket"></i>
							Place an Order</a>
						</li>
						<li class=" {{ $_routeName == 'order.index' ? 'active' : '' }} ">
							<a href="{{ route('order.index') }}">
							<i class="icon-tag"></i>
							View All</a>
						</li>
						<!-- <li class=" {{ $_routeName == 'order-refund.index' ? 'active' : '' }} ">
							<a href="{{ route('order-refund.index') }}">
							<i class="icon-share-alt"></i>
							bKash Refund</a>
						</li> -->
					</ul>
				</li>

				@if( $_userType != 3 && $_userType != 4 )
				<li class="{{ $_segments[0] == 'restaurant' ? 'start active open' : '' }}">
					<a href="javascript:;">
					<i class="fa fa-cutlery"></i>
					<span class="title">Restaurant</span>
					<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						@if( $_userType == -1 )
						<li class=" {{ $_routeName == 'restaurant.index' ? 'active' : '' }} ">
							<a href="{{ route('restaurant.index') }}">
							<i class="icon-tag"></i>
							Restaurant List</a>
						</li>
						@endif
						<!-- <li>
							<a href="{{ route('restaurant.create') }}">
							<i class="icon-plus"></i>
							Add New</a>
						</li> -->
						<li class=" {{ $_routeName == 'kitchen.index' ? 'active' : '' }} ">
							<a href="{{ route('kitchen.index') }}">
							<i class="fa fa-home"></i>
							Kitchen List</a>
						</li>
						<!-- <li>
							<a href="#">
							<i class="fa fa-tag"></i>
							Restaurant Type</a>
						</li> -->
						<!-- <li>
							<a href="#">
							<i class="fa fa-tag"></i>
							Delivery Zone</a>
						</li> -->
					</ul>
				</li>
				@endif

				@if( $_userType != 3 && $_userType != 4 )
				<li class="{{ $_segments[0] == 'category' || $_segments[0] == 'foodgroup' || $_segments[0] == 'food' ? 'start active open' : '' }}">
					<a href="javascript:;">
					<i class="icon-notebook"></i>
					<span class="title">Menu</span>
					<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class=" {{ $_routeName == 'category.index' ? 'active' : '' }} ">
							<a href="{{ route('category.index') }}">
							<i class="icon-tag"></i>
							Menu Category</a>
						</li>
						<li class=" {{ $_routeName == 'foodgroup.index' ? 'active' : '' }} ">
							<a href="{{ route('foodgroup.index') }}">
							<i class="icon-layers"></i>
							Menu Group</a>
						</li>
						<li class=" {{ $_routeName == 'food.index' ? 'active' : '' }} ">
							<a href="{{ route('food.index') }}">
							<i class="icon-notebook"></i>
							Menu List</a>
						</li>
					</ul>
				</li>
				@endif


				<li class="{{ $_segments[0] == 'deliveryzone' ? 'start active open' : '' }}">
					<a href="javascript:;">
					<i class="icon-rocket"></i>
					<span class="title">Deliveryzone</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li class=" {{ $_routeName == 'deliveryzone.create' ? 'active' : '' }} ">
							<a href="{{ route('deliveryzone.create') }}">
							<i class="icon-plus"></i>
							Create</a>
						</li>
						<li class=" {{ $_routeName == 'deliveryzone.index' ? 'active' : '' }} ">
							<a href="{{ route('deliveryzone.index') }}">
							<i class="icon-tag"></i>
							View All</a>
						</li>
						
					</ul>
				</li>

				<!-- <li class="{{ $_segments[0] == 'general-category' ? 'start active open' : $_segments[0] == 'general-food' ? 'start active open' : '' }}">
					<a href="javascript:;">
					<i class="icon-rocket"></i>
					<span class="title">Real Good Food</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li class=" {{ $_routeName == 'general-category.index' ? 'active' : '' }} ">
							<a href="{{ route('general-category.index') }}">
							<i class="icon-plus"></i>
							General Category</a>
						</li>
						<li class=" {{ $_routeName == 'general-food.index' ? 'active' : '' }} ">
							<a href="{{ route('general-food.index') }}">
							<i class="icon-tag"></i>
							General Food</a>
						</li>
						
					</ul>
				</li> -->

				<!-- <li>
					<a href="javascript:;">
					<i class="icon-bag"></i>
					<span class="title">Food</span>
					<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="{{ route('food.index') }}">
							<i class="icon-tag"></i>
							View All</a>
						</li>
						<li>
							<a href="{{ route('food.create') }}">
							<i class="icon-plus"></i>
							Add New</a>
						</li>
					</ul>
				</li> -->

				<!-- <li>
					<a href="javascript:;">
					<i class="icon-layers"></i>
					<span class="title">Combo Menu</span>
					<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="{{ url('#') }}">
							<i class="icon-tag"></i>
							View All</a>
						</li>
						<li>
							<a href="{{ url('#') }}">
							<i class="icon-plus"></i>
							Add New</a>
						</li>
						<li>
							<a href="{{ url('#') }}">
							<i class="icon-plus"></i>
							Add Combo Item</a>
						</li>
					</ul>
				</li> -->

				@if( $_userType == -1 || $_userType == 1 )
				<li class="{{ $_segments[0] == 'userinfo' ? 'start active open' : '' }}">
					<a href="javascript:;">
					<i class="icon-user"></i>
					<span class="title">Userinfo</span>
					<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class=" {{ $_routeName == 'userinfo.index' ? 'active' : '' }} ">
							<a href="{{ route('userinfo.index') }}">
							<i class="icon-tag"></i>
							View All</a>
						</li>
						<li class=" {{ $_routeName == 'userinfo.create' ? 'active' : '' }} ">
							<a href="{{ route('userinfo.create') }}">
							<i class="icon-plus"></i>
							Add New</a>
						</li>
					</ul>
				</li>
				@endif
				@if( $_userType == -1 || $_userType == 1 )
				<li class="{{ $_segments[0] == 'waiter-sales-report' ? 'start active open' : '' }}">
					<a href="javascript:;">
					<i class="icon-user"></i>
					<span class="title">Reports</span>
					<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<!-- <li class=" {{ $_routeName == 'waiter-sales-report' ? 'active' : '' }} ">
							<a href="{{ url('waiter-sales-report') }}">
							<i class="icon-tag"></i>
							Waiter Sales</a>
						</li> -->
						<li class=" {{ $_routeName == 'member-sales-report' ? 'active' : '' }} ">
							<a href="{{ url('member-sales-report') }}">
							<i class="icon-tag"></i>
							Member Sales</a>
						</li>
						<li class=" {{ $_routeName == 'kitchen-sales-report' ? 'active' : '' }} ">
							<a href="{{ url('kitchen-sales-report') }}">
							<i class="icon-tag"></i>
							Kitchen Sales</a>
						</li>
						<li class=" {{ $_routeName == 'category-sales-report' ? 'active' : '' }} ">
							<a href="{{ url('category-sales-report') }}">
							<i class="icon-tag"></i>
							Category Sales</a>
						</li>
						<li class=" {{ $_routeName == 'order-timeline-report' ? 'active' : '' }} ">
							<a href="{{ url('order-timeline-report') }}">
							<i class="icon-tag"></i>
							Order Timeline</a>
						</li>
					</ul>
				</li>
				@endif

				<li class="{{ $_segments[0] == 'order-live-monitoring' ? 'start active open' : '' }}">
					<a href="{{ url('order-live-monitoring') }}">
					<i class="icon-rocket"></i>
					<span class="title">Order Live Monitoring</span>
					</a>
				</li>
				<!-- <li class="heading">
					<h3 class="uppercase">Features</h3>
				</li> -->
				
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->