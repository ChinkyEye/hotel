// dashboard
import Dashboard from './components/bar/Home.vue'
// user-type component
import UserList from './components/bar/usertype/List.vue'

// user component
import User from './components/bar/user/List.vue'
import UserNew from './components/bar/user/New.vue'
import UserEdit from './components/bar/user/Edit.vue'

//allcustomer list
import AllCustomer from './components/bar/user/AllCustomerList.vue'

// category component
import CategoryBuying from './components/bar/category/CategoryBuyingList.vue'

import CategorySelling from './components/bar/category/CategorySellingList.vue'

// unit component
import Unit from './components/bar/unit/List.vue'

// table component
import Table from './components/bar/table/List.vue'

// item component
import Item from './components/bar/item/List.vue'

// confirm component
import Confirm from './components/bar/confirm/New.vue'
import ConfirmEdit from './components/bar/confirm/List.vue'

// stock component
import Stock from './components/bar/stock/List.vue'

// package component
import Package from './components/bar/package/List.vue'

// category component
import TestCategory from './components/bar/testcategory/List.vue'

// change password
import ChangePassword from './components/bar/ChangePassword.vue'

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
	// {
	// 	path:'/confirm/:billid/preview',
	// 	component: ConfirmBill
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
]