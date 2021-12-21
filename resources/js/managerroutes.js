// dashboard
import Dashboard from './components/manager/Home.vue'

//report list
import Report from './components/manager/report/List.vue'
// user-type component
import BuyerList from './components/manager/usertype/BuyerList.vue'
import CustomerBuyerNew from './components/manager/usertype/CustomerBuyer/New.vue'
import CustomerBuyerEdit from './components/manager/usertype/CustomerBuyer/Edit.vue'

import SellerList from './components/manager/usertype/SellerList.vue'
import CustomerSellerNew from './components/manager/usertype/CustomerSeller/New.vue'
import CustomerSellerEdit from './components/manager/usertype/CustomerSeller/Edit.vue'

// user component
import User from './components/manager/user/List.vue'
import UserNew from './components/manager/user/New.vue'
import UserEdit from './components/manager/user/Edit.vue'
//allcustomer list
import AllCustomer from './components/manager/user/AllCustomerList.vue'

// category buying component
import CategoryBuying from './components/manager/category/CategoryBuyingList.vue'
import CategoryBuyingNew from './components/manager/category/categorybuying/New.vue'
import CategoryBuyingEdit from './components/manager/category/categorybuying/Edit.vue'

//category selling component
import CategorySelling from './components/manager/category/CategorySellingList.vue'
import CategorySellingNew from './components/manager/category/categoryselling/New.vue'
import CategorySellingEdit from './components/manager/category/categoryselling/Edit.vue'

// unit component
import Unit from './components/manager/unit/List.vue'
import UnitNew from './components/manager/unit/New.vue'
import UnitEdit from './components/manager/unit/Edit.vue'

// table component
import Table from './components/manager/table/List.vue'
import TableNew from './components/manager/table/New.vue'
import TableEdit from './components/manager/table/Edit.vue'

// item component
import Item from './components/manager/item/List.vue'
import ItemEdit from './components/manager/item/Edit.vue'
import ItemImage from './components/manager/item/AddImage.vue'

// order component
import Order from './components/manager/order/List.vue'
import OrderBill from './components/manager/order/Bill.vue'

// confirm component
import Confirm from './components/manager/confirm/New.vue'
import ConfirmEdit from './components/manager/confirm/List.vue'
import ConfirmBill from './components/manager/confirm/Bill.vue'

// review component
import Review from './components/manager/review/New.vue'
import ReviewEdit from './components/manager/review/List.vue'
import ReviewBill from './components/manager/review/Bill.vue'
import BefReviewBill from './components/manager/review/BefBill.vue'

// stock component
import Stock from './components/manager/stock/List.vue'
import StockEdit from './components/manager/stock/Edit.vue'

//purchasselist stock out
import StockOut from './components/manager/purchaselist/Out.vue'

// stock component
import Vendor from './components/manager/vendor/List.vue'
import VendorNew from './components/manager/vendor/New.vue'
import VendorEdit from './components/manager/vendor/Edit.vue'
import VendorPurchase from './components/manager/vendor/VendorPurchase.vue'
//purchase list
import PurchaseList from './components/manager/purchaselist/List.vue'

// stock component
import Asset from './components/manager/asset/List.vue'
import AssetNew from './components/manager/asset/New.vue'
import AssetEdit from './components/manager/asset/Edit.vue'
import AssetPurchase from './components/manager/asset/AssetPurchase.vue'


// package component
import Package from './components/manager/package/List.vue'
import PackageNew from './components/manager/package/New.vue'
import PackageEdit from './components/manager/package/Edit.vue'

// salary component
import Salary from './components/manager/salary/List.vue'
import SalaryEdit from './components/manager/salary/Edit.vue'
import SalaryAdd from './components/manager/salary/New.vue'

// category component
import TestCategory from './components/manager/testcategory/List.vue'

// visitororder component
import VisitorOrder from './components/manager/visitororder/List.vue'
import VisitorOrderBill from './components/manager/visitororder/Bill.vue'

// manager component
import Counter from './components/manager/counter/List.vue'
import CounterNew from './components/manager/counter/New.vue'
import CounterEdit from './components/manager/counter/Edit.vue'

// waiter component
import Waiter from './components/manager/waiter/List.vue'
import WaiterNew from './components/manager/waiter/New.vue'
import WaiterEdit from './components/manager/waiter/Edit.vue'

// bar component
import Bar from './components/manager/bar/List.vue'
import BarNew from './components/manager/bar/New.vue'
import BarEdit from './components/manager/bar/Edit.vue'

// kitchen component
import Kitchen from './components/manager/kitchen/List.vue'
import KitchenNew from './components/manager/kitchen/New.vue'
import KitchenEdit from './components/manager/kitchen/Edit.vue'

// income topic
import IncomeTopic from './components/manager/incometopic/List.vue'
import IncomeTopicNew from './components/manager/incometopic/New.vue'
import IncomeTopicEdit from './components/manager/incometopic/Edit.vue'

// income 
import Income from './components/manager/income/List.vue'
import IncomeNew from './components/manager/income/New.vue'
import IncomeEdit from './components/manager/income/Edit.vue'

//room
import Room from './components/manager/room/List.vue'
import RoomNew from './components/manager/room/New.vue'
import RoomEdit from './components/manager/room/Edit.vue'

// expense topic
import ExpenseTopic from './components/manager/expensetopic/List.vue'
import ExpenseTopicNew from './components/manager/expensetopic/New.vue'
import ExpenseTopicEdit from './components/manager/expensetopic/Edit.vue'

// expense 
import Expense from './components/manager/expense/List.vue'
import ExpenseNew from './components/manager/expense/New.vue'
import ExpenseEdit from './components/manager/expense/Edit.vue'

// change password
import ChangePassword from './components/manager/ChangePassword.vue'

// report component
// sales
import Sales from './components/manager/report/sales/List.vue'
// purchases
import Purchases from './components/manager/report/purchases/List.vue'
// items
import Items from './components/manager/report/items/List.vue'
// asset
import AssetReport from './components/manager/report/asset/List.vue'
// stocks
import Stocks from './components/manager/report/stocks/List.vue'
// kitchen stocks
import Kitchenstocks from './components/manager/report/kitchenstocks/List.vue'
// customer
import Customer from './components/manager/report/customer/List.vue'
// customer detail
import CustomerDetail from './components/manager/report/customer/Detail.vue'
// daybokk
import Daybook from './components/manager/report/daybook/List.vue'
//income report
import IncomeReport from './components/manager/report/incomereport/List.vue'
//expense report
import ExpenseReport from './components/manager/report/expensereport/List.vue'
// overall detail
import Overall from './components/manager/report/overall/List.vue'

export const routes = [
	// dashboard
	{
		path:'/',
		name: 'dashboard',
		component:Dashboard
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
	{
		path:'/item/:itemid/addimage',
		component: ItemImage
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
	// Vendor
	{
		path:'/vendor',
		component: Vendor
	},
	{
		path:'/vendor/create',
		component: VendorNew
	},
	{
		path:'/vendor/:vendorid/edit',
		component: VendorEdit
	},
	{
		path:'/vendor/:vendorid/addpurchase',
		component: VendorPurchase
	},

	//purchasse list
	{
		path:'/purchase/list',
		component: PurchaseList
	},
	// Asset
	{
		path:'/asset',
		component: Asset
	},
	{
		path:'/asset/create',
		component: AssetNew
	},
	{
		path:'/asset/:assetid/edit',
		component: AssetEdit
	},
	{
		path:'/asset/:assetid/addpurchase',
		component: AssetPurchase
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
	{
		path:'/stock/:stockid/out',
		component: StockOut
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
	// counter
	{
		path:'/counter',
		component: Counter
	},
	{
		path:'/counter/create',
		component: CounterNew
	},
	{
		path:'/counter/:counterid/edit',
		component: CounterEdit
	},
	// waiter
	{
		path:'/waiter',
		component: Waiter
	},
	{
		path:'/waiter/create',
		component: WaiterNew
	},
	{
		path:'/waiter/:waiterid/edit',
		component: WaiterEdit
	},
	// bar
	{
		path:'/bar',
		component: Bar
	},
	{
		path:'/bar/create',
		component: BarNew
	},
	{
		path:'/bar/:barid/edit',
		component: BarEdit
	},
	// kitchen
	{
		path:'/kitchen',
		component: Kitchen
	},
	{
		path:'/kitchen/create',
		component: KitchenNew
	},
	{
		path:'/kitchen/:kitchenid/edit',
		component: KitchenEdit
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
		component: ChangePassword,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	// sales report
	{
		path:'/report/sales',
		meta: { bodyClass: 'sidebar-collapse' },
		component: Sales,
	},
	{
		path:'/report/purchases',
		component: Purchases,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	// asset
	{
		path:'/report/asset',
		component: AssetReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	// items report
	{
		path:'/report/items',
		component: Items,
		meta: { bodyClass: 'sidebar-collapse' }
	},
	// stocks report
	{
		path:'/report/stocks',
		component: Stocks,
		meta: { bodyClass: 'sidebar-collapse' }
	},
	// kitchen stocks report
	{
		path:'/report/kitchen-stocks',
		component: Kitchenstocks,
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
	{
		path:'/report/daybook',
		component: Daybook,
		meta: { bodyClass: 'sidebar-collapse' }
	},
	{
		path:'/report/incomereport',
		component: IncomeReport,
		meta: { bodyClass: 'sidebar-collapse' }
	},
	{
		path:'/report/expensereport',
		component: ExpenseReport,
		meta: { bodyClass: 'sidebar-collapse' }
	},

	// overall report
	{
		path:'/report/overall',
		component: Overall,
		meta: { bodyClass: 'sidebar-collapse' }
	}
]