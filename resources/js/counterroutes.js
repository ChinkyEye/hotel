// dashboard
import Dashboard from './components/counter/Home.vue'
// user-type component
import UserList from './components/counter/usertype/List.vue'

// user component
import User from './components/counter/user/List.vue'

//allcustomer list
import AllCustomer from './components/counter/user/AllCustomerList.vue'

// category component
import CategoryBuying from './components/counter/category/CategoryBuyingList.vue'

import CategorySelling from './components/counter/category/CategorySellingList.vue'

// unit component
import Unit from './components/counter/unit/List.vue'

// table component
import Table from './components/counter/table/List.vue'

// item component
import Item from './components/counter/item/List.vue'

//checkin component
import CheckIn from './components/counter/checkin/List.vue'
import CheckInNew from './components/counter/checkin/New.vue'
import CheckInCustomerBill from './components/counter/checkin/Detail.vue'

// order component
import Order from './components/counter/order/List.vue'
import OrderBill from './components/counter/order/Bill.vue'
import OrderBarBill from './components/counter/order/BarBill.vue'

// confirm component
import Confirm from './components/counter/confirm/New.vue'
import ConfirmEdit from './components/counter/confirm/List.vue'
import ConfirmBill from './components/counter/confirm/Bill.vue'

// review component
import Review from './components/counter/review/New.vue'
import ReviewEdit from './components/counter/review/List.vue'
import ReviewBill from './components/counter/review/Bill.vue'
import BefReviewBill from './components/counter/review/BefBill.vue'

// stock component
import Stock from './components/counter/stock/List.vue'

// package component
import Package from './components/counter/package/List.vue'

// category component
import TestCategory from './components/counter/testcategory/List.vue'

// visitororder component
import VisitorOrder from './components/counter/visitororder/List.vue'
import VisitorOrderBill from './components/counter/visitororder/Bill.vue'

// change password
import ChangePassword from './components/counter/ChangePassword.vue'

// report component
// sales
import Sales from './components/counter/report/sales/List.vue'
// items
import Items from './components/counter/report/items/List.vue'
// customer
import Customer from './components/counter/report/customer/List.vue'
// customer detail
import CustomerDetail from './components/counter/report/customer/Detail.vue'
// overall detail
import Overall from './components/counter/report/overall/List.vue'

export const routes = [
	// dashboard
	{
		path:'/',
		name: 'dashboard',
		component:Dashboard
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
	// order
	{
		path:'/order',
		component: Order,
		meta: { bodyClass: 'sidebar-collapse' }
	},
	{
		path:'/order/:billid/preview',
		component: OrderBill
	},
	{
		path:'/order/:billid/preview/bar',
		component: OrderBarBill
	},
	// confirm
	{
		path:'/confirm',
		component: Confirm
	},
	{
		path:'/confirm/:billid/preview',
		component: ConfirmBill
	},
	{
		path:'/confirm/:billid/show',
		component: ConfirmEdit
	},
	// review
	{
		path:'/review',
		component: Review
	},
	{
		path:'/review/:billid/preview',
		component: ReviewBill
	},
	{
		path:'/befreview/:billid/preview',
		component: BefReviewBill
	},
	{
		path:'/review/:billid/show',
		component: ReviewEdit
	},
	//checkin
	{
		path:'/checkin',
		component: CheckIn
	},
	{
		path:'/checkin/create',
		component: CheckInNew
	},
	{
		path:'/checkin/customer/:checkinid',
		component: CheckInCustomerBill

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
	// visitor-order
	{
		path:'/visitor-order',
		component: VisitorOrder
	},
	{
		path:'/visitor-order/:billid/preview',
		component: VisitorOrderBill
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