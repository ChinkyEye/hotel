// dashboard
import Dashboard from './components/admin/Home.vue'
// user-type component
import BuyerList from './components/admin/usertype/BuyerList.vue'
import CustomerBuyerNew from './components/admin/usertype/CustomerBuyer/New.vue'
import CustomerBuyerEdit from './components/admin/usertype/CustomerBuyer/Edit.vue'
//activitylog
import ActivityLog from './components/admin/activitylog/List.vue'
//report list
import Report from './components/admin/report/List.vue'

import SellerList from './components/admin/usertype/SellerList.vue'
import CustomerSellerNew from './components/admin/usertype/CustomerSeller/New.vue'
import CustomerSellerEdit from './components/admin/usertype/CustomerSeller/Edit.vue'

// user component
import User from './components/admin/user/List.vue'
import UserNew from './components/admin/user/New.vue'
import UserEdit from './components/admin/user/Edit.vue'

//allcustomer list
import AllCustomer from './components/admin/user/AllCustomerList.vue'

// category component
import CategoryBuying from './components/admin/category/CategoryBuyingList.vue'
import CategoryBuyingNew from './components/admin/category/categorybuying/New.vue'
import CategoryBuyingEdit from './components/admin/category/categorybuying/Edit.vue'

//category selling
import CategorySelling from './components/admin/category/CategorySellingList.vue'
import CategorySellingNew from './components/admin/category/categoryselling/New.vue'
import CategorySellingEdit from './components/admin/category/categoryselling/Edit.vue'

// unit component
import Unit from './components/admin/unit/List.vue'
import UnitNew from './components/admin/unit/New.vue'
import UnitEdit from './components/admin/unit/Edit.vue'

// table component
import Table from './components/admin/table/List.vue'
import TableNew from './components/admin/table/New.vue'
import TableEdit from './components/admin/table/Edit.vue'

// item component
import Item from './components/admin/item/List.vue'
import ItemEdit from './components/admin/item/Edit.vue'

// order component
import Order from './components/admin/order/List.vue'
import OrderBill from './components/admin/order/Bill.vue'

// confirm component
import Confirm from './components/admin/confirm/New.vue'
import ConfirmEdit from './components/admin/confirm/List.vue'
import ConfirmBill from './components/admin/confirm/Bill.vue'

// stock component
import Stock from './components/admin/stock/List.vue'
import StockEdit from './components/admin/stock/Edit.vue'

// asset component
import Asset from './components/admin/asset/List.vue'

// package component
import Package from './components/admin/package/List.vue'
import PackageNew from './components/admin/package/New.vue'
import PackageEdit from './components/admin/package/Edit.vue'

// salary component
import Salary from './components/admin/salary/List.vue'
import SalaryEdit from './components/admin/salary/Edit.vue'
import SalaryAdd from './components/admin/salary/New.vue'

// category component
import TestCategory from './components/admin/testcategory/List.vue'

// visitororder component
import VisitorOrder from './components/admin/visitororder/List.vue'
import VisitorOrderBill from './components/admin/visitororder/Bill.vue'

// manager component
import Manager from './components/admin/manager/List.vue'
import ManagerNew from './components/admin/manager/New.vue'
import ManagerEdit from './components/admin/manager/Edit.vue'

// income topic
import IncomeTopic from './components/admin/incometopic/List.vue'
import IncomeTopicNew from './components/admin/incometopic/New.vue'
import IncomeTopicEdit from './components/admin/incometopic/Edit.vue'

// income 
import Income from './components/admin/income/List.vue'
import IncomeNew from './components/admin/income/New.vue'
import IncomeEdit from './components/admin/income/Edit.vue'

//room
import Room from './components/admin/room/List.vue'
import RoomNew from './components/admin/room/New.vue'
import RoomEdit from './components/admin/room/Edit.vue'

// expense topic
import ExpenseTopic from './components/admin/expensetopic/List.vue'
import ExpenseTopicNew from './components/admin/expensetopic/New.vue'
import ExpenseTopicEdit from './components/admin/expensetopic/Edit.vue'

// expense 
import Expense from './components/admin/expense/List.vue'
import ExpenseNew from './components/admin/expense/New.vue'
import ExpenseEdit from './components/admin/expense/Edit.vue'

// change password
import ChangePassword from './components/admin/ChangePassword.vue'

// report component
// sales
import Sales from './components/admin/report/sales/List.vue'
// purchases
import Purchases from './components/admin/report/purchases/List.vue'
// items
import Items from './components/admin/report/items/List.vue'
// asset
import AssetReport from './components/admin/report/asset/List.vue'
// stocks
import Stocks from './components/admin/report/stocks/List.vue'
// kitchen stocks
import Kitchenstocks from './components/admin/report/kitchenstocks/List.vue'
// counter
import Counter from './components/admin/report/counter/List.vue'
// customer
import Customer from './components/admin/report/customer/List.vue'
// customer detail
import CustomerDetail from './components/admin/report/customer/Detail.vue'
// overall detail
import Overall from './components/admin/report/overall/List.vue'
// daybook detail
import Daybook from './components/admin/report/daybook/List.vue'
// waiter detail
import Waiter from './components/admin/report/waiter/List.vue'
// bill
import Bill from './components/admin/report/bill/List.vue'

//purchase list
import PurchaseList from './components/admin/purchaselist/List.vue'
//purchasselist stock out
import StockOutList from './components/admin/purchaselist/OutList.vue'


export const routes = [
	// dashboard
	{
		path:'/',
		name: 'dashboard',
		component:Dashboard
	},
	{
		path:'/activitylog',
		name: 'activitylog',
		component:ActivityLog
	},
	{
		path:'/report',
		name: 'report',
		component:Report
	},
	// user-type routes buyer1 seller2
	{ 
		path:'/customer/buyer', 
		component: BuyerList
	},
	{
		path:'/customer/buyer/create',
		component: CustomerBuyerNew
	},
	{
		path:'/customer/buyer/:customerid/edit',
		component: CustomerBuyerEdit
	},
	{ 
		path:'/customer/seller', 
		component: SellerList
	},
	{
		path:'/customer/seller/create',
		component: CustomerSellerNew
	},
	{
		path:'/customer/seller/:customerid/edit',
		component: CustomerSellerEdit
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
	{
		path:'/usertypeList',
		component: AllCustomer
	},
	{
		path:'/stock/:stockid/out/list',
		component: StockOutList
	},
	// category
	{
		path:'/category/buying',
		component: CategoryBuying
	},
	{
		path:'/category/buying/create',
		component: CategoryBuyingNew
	},
	{
		path:'/category/buying/:categoryid/edit',
		component: CategoryBuyingEdit
	},
	{
		path:'/category/selling',
		component: CategorySelling
	},
	{
		path:'/category/selling/create',
		component: CategorySellingNew
	},
	{
		path:'/category/selling/:categoryid/edit',
		component: CategorySellingEdit
	},
	// unit
	{
		path:'/unit',
		component: Unit
	},
	{
		path:'/unit/create',
		component: UnitNew
	},
	{
		path:'/unit/:unitid/edit',
		component: UnitEdit
	},
	// table
	{
		path:'/table',
		component: Table
	},
	{
		path:'/table/create',
		component: TableNew
	},
	{
		path:'/table/:tableid/edit',
		component: TableEdit
	},
	// item
	{
		path:'/item',
		component: Item
	},
	{
		path:'/item/:itemid/edit',
		component: ItemEdit
	},
	// order
	{
		path:'/order',
		component: Order
	},
	{
		path:'/order/:billid/preview',
		component: OrderBill
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
	// stock
	{
		path:'/stock',
		component: Stock
	},
	{
		path:'/stock/:stockid/edit',
		component: StockEdit
	},
	// asset
	{
		path:'/asset',
		component: Asset
	},
	// package
	{
		path:'/package',
		component: Package
	},
	{
		path:'/package/create',
		component: PackageNew
	},
	{
		path:'/package/:packageid/edit',
		component: PackageEdit
	},
	// salary
	{
		path:'/salary',
		component: Salary
	},
	{
		path:'/salary/:salaryid/edit',
		component: SalaryEdit
	},
	{
		path:'/salary/create',
		component:SalaryAdd
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
	// manager
	{
		path:'/manager',
		component: Manager
	},
	{
		path:'/manager/create',
		component: ManagerNew
	},
	{
		path:'/manager/:managerid/edit',
		component: ManagerEdit
	},
	// income topic
	{
		path:'/income/topic',
		component: IncomeTopic
	},
	{
		path:'/income/topic/create',
		component: IncomeTopicNew
	},
	{
		path:'/income/topic/:incometopicid/edit',
		component: IncomeTopicEdit
	},
	// income 
	{
		path:'/income',
		component: Income
	},
	{
		path:'/income/create',
		component: IncomeNew
	},
	{
		path:'/income/:incomeid/edit',
		component: IncomeEdit
	},
	// expense topic
	{
		path:'/expense/topic',
		component: ExpenseTopic
	},
	{
		path:'/expense/topic/create',
		component: ExpenseTopicNew
	},
	{
		path:'/expense/topic/:expensetopicid/edit',
		component: ExpenseTopicEdit
	},
	// expense 
	{
		path:'/expense',
		component: Expense
	},
	{
		path:'/expense/create',
		component: ExpenseNew
	},
	{
		path:'/expense/:expenseid/edit',
		component: ExpenseEdit
	},
	//room
	{
		path:'/room',
		component: Room
	},
	{
		path:'/room/create',
		component: RoomNew
	},
	{
		path:'/room/:roomid/edit',
		component: RoomEdit
	},
	// change password
	{ 
		path:'/change-password', 
		component: ChangePassword
	},
	//purchasse list
	{
		path:'/purchase/list',
		component: PurchaseList
	},
	// sales report
	{
		path:'/report/sales',
		component: Sales,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/purchases',
		component: Purchases,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	// items report
	{
		path:'/report/items',
		component: Items,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	// items report
	{
		path:'/report/stocks',
		component: Stocks,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	// kitchen stocks report
	{
		path:'/report/kitchen-stocks',
		component: Kitchenstocks,
		meta: { bodyClass: 'sidebar-collapse' }
	},
	// asset
	{
		path:'/report/asset',
		component: AssetReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	// counter report
	{
		path:'/report/counter',
		component: Counter,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	// customer report
	{
		path:'/report/customer',
		component: Customer,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/customer/seller/:userid',
		component: CustomerDetail,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	// overall report
	{
		path:'/report/overall',
		component: Overall,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	// overall report
	{
		path:'/report/daybook',
		component: Daybook,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	// overall report
	{
		path:'/report/waiter',
		component: Waiter,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	// bill report
	{
		path:'/report/bill',
		component: Bill,
		meta: { bodyClass: 'sidebar-collapse' },
	}
]