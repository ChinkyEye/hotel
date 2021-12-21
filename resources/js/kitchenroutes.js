// dashboard
import Dashboard from './components/kitchen/Home.vue'
// user-type component
import UserList from './components/kitchen/usertype/List.vue'

// user component
import User from './components/kitchen/user/List.vue'
import UserNew from './components/kitchen/user/New.vue'
import UserEdit from './components/kitchen/user/Edit.vue'

//allcustomer list
import AllCustomer from './components/kitchen/user/AllCustomerList.vue'

// category component
import CategoryBuying from './components/kitchen/category/CategoryBuyingList.vue'

import CategorySelling from './components/kitchen/category/CategorySellingList.vue'

// unit component
import Unit from './components/kitchen/unit/List.vue'

// table component
import Table from './components/kitchen/table/List.vue'

// item component
import Item from './components/kitchen/item/List.vue'

// confirm component
import Confirm from './components/kitchen/confirm/New.vue'
import ConfirmEdit from './components/kitchen/confirm/List.vue'

// stock component
import Stock from './components/kitchen/stock/List.vue'

// package component
import Package from './components/kitchen/package/List.vue'

// category component
import TestCategory from './components/kitchen/testcategory/List.vue'

// change password
import ChangePassword from './components/kitchen/ChangePassword.vue'

// report component
// sales
import Sales from './components/kitchen/report/sales/List.vue'
// items
import Items from './components/kitchen/report/items/List.vue'
// customer
import Customer from './components/kitchen/report/customer/List.vue'
// customer detail
import CustomerDetail from './components/kitchen/report/customer/Detail.vue'
// overall detail
import Overall from './components/kitchen/report/overall/List.vue'

export const routes = [
	// dashboard
	{
		path:'/',
		name: 'dashboard',
		component:Dashboard
	},
	{
		path:'/confirm',
		name: 'confirm',
		component:Confirm
	},
	// user-type routes
	{ 
		path:'/user-type', 
		component: UserList
	},
	{
		path:'/customer/:userid',
		component: User
	},
	{
		path:'/customer/:userid/create',
		component: UserNew
	},
	{
		path:'/customer/:userid/edit',
		component: UserEdit
	},
	// category
	{
		path:'/category/buying',
		component: CategoryBuying
	},
	{
		path:'/category/selling',
		component: CategorySelling
	},
	{
		path:'/all-customer',
		component: AllCustomer
	},
	// unit
	{
		path:'/unit',
		component: Unit
	},
	// table
	{
		path:'/table',
		component: Table
	},
	// item
	{
		path:'/item',
		component: Item
	},
	// confirm
	// {
	// 	path:'/confirm',
	// 	component: Confirm
	// },
	{
		path:'/confirm/:billid/show',
		component: ConfirmEdit
	},
	// stock
	{
		path:'/stock',
		component: Stock
	},
	// category
	{
		path:'/testcategory',
		component: TestCategory
	},
	// change password
	{ 
		path:'/change-password', 
		component: ChangePassword,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	// sales report
	{
		path:'/report/sales',
		meta: { bodyClass: 'sidebar-collapse' },
		component: Sales,
	},
	// items report
	{
		path:'/report/items',
		component: Items,
		meta: { bodyClass: 'sidebar-collapse' }
	},
	// customer report
	{
		path:'/report/customer',
		component: Customer,
		meta: { bodyClass: 'sidebar-collapse' }
	},
	{
		path:'/customer/seller/:userid',
		component: CustomerDetail,
		meta: { bodyClass: 'sidebar-collapse' }
	},
	// overall report
	{
		path:'/report/overall',
		component: Overall,
		meta: { bodyClass: 'sidebar-collapse' }
	}
]