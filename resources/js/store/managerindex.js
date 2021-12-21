export default{
	state:{
		dashboard:[],
		reportdashboard:[],
		billsetting:[],
		buyertype:[],
		sellertype:[],
		user:[],
		usertypeSelect : [],
		sellerusertypeSelect : [],
		buyingcategory:[],
		sellingcategory:[],
		counter:[],
		waiter:[],
		kitchen:[],
		bar:[],
		vendor:[],
		vendorasset:[],
		testcategory:[],
		unit:[],
		table:[],
		item:[],
		itemimage:[],
		categorySelect : [],
		unitSelect : [],
		userSelect : [],
		itemSelect : [],
		itemSelectReady : [],
		tableSelect : [],
		incometopicSelect : [],
		expensetopicSelect : [],
		bill : [],
		reviewbill : [],
		befreviewbill : [],
		confirmbill : [],
		orderbill:[],
		stock:[],
		purchaselist:[],
		asset:[],
		buyerSelect : [],
		buyercategorySelect : [],
		buyercategorySelectAll : [],
		sellercategorySelectAll : [],
		package:[],
		packageSelect : [],
		userSalarySelect : [],
		month:[],
		salary:[],
		spcialuserpackage : [],
		usersalary:null,
		orderdetail:[],
		orderreviewdetail:[],
		confirmorderdetail:[],
		purchaseorderdetail:[],
		assetreport:[],
		incomereport:[],
		expensereport:[],
		stockdetail:[],
		kitchenstockdetail:[],
		confirmorder:[],
		userorderdetail:[],
		userpaydetail:[],
		userordersummarydetail:[],
		userorderoveralldetail:[],
		daybook:[],
		outstocklist:[],
		incometopic:[],
		income:[],
		expensetopic:[],
		expense:[],
		room:[],
	},
	getters:{
		getDashboard(state){
			return state.dashboard
		},
		getReportDashboard(state){
			return state.reportdashboard
		},
	
		
		getBillSetting(state){
			return state.billsetting
		},
		getBuyerType(state){
			return state.buyertype
		},
		getSellerType(state){
			return state.sellertype
		},
		getUser(state){
			return state.user
		},
		getUsertypeSelect(state){
			return state.usertypeSelect
		},
		getSellerUsertypeSelect(state){
			return state.sellerusertypeSelect
		},
		getBuyingCategory(state){
			return state.buyingcategory
		},
		getSellingCategory(state){
			return state.sellingcategory
		},
		getCounter(state){
			return state.counter
		},
		getWaiter(state){
			return state.waiter
		},
		getKitchen(state){
			return state.kitchen
		},
		getBar(state){
			return state.bar
		},
		getVendor(state){
			return state.vendor
		},
		getVendorAsset(state){
			return state.vendorasset
		},
		getTestCategory(state){
			return state.testcategory
		}		,
		getUnit(state){
			return state.unit
		},
		getTable(state){
			return state.table
		},
		getItem(state){
			return state.item
		},
		getItemImage(state){
			return state.itemimage
		},
		getCategorySelect(state){
			return state.categorySelect
		},
		getUnitSelect(state){
			return state.unitSelect
		},
		getUserSelect(state){
			return state.userSelect
		},
		getItemSelect(state){
			return state.itemSelect
		},
		getItemSelectReady(state){
			return state.itemSelectReady
		},
		getTableSelect(state){
			return state.tableSelect
		},
		getIncomeTopicSelect(state){
			return state.incometopicSelect
		},
		getExpenseTopicSelect(state){
			return state.expensetopicSelect
		},
		getBill(state){
			return state.bill
		},
		getReviewBill(state){
			return state.reviewbill
		},
		getBefReviewBill(state){
			return state.befreviewbill
		},
		getConfirmBill(state){
			return state.confirmbill
		},
		getOrderBill(state){
			return state.orderbill
		},
		getStock(state){
			return state.stock
		},
		getPurchaseList(state){
			return state.purchaselist
		},
		getAsset(state){
			return state.asset
		},
		getBuyerSelect(state){
			return state.buyerSelect
		},
		getBuyerCategorySelect(state){
			return state.buyercategorySelect
		},
		getBuyerCategorySelectAll(state){
			return state.buyercategorySelectAll
		},
		getSellerCategorySelectAll(state){
			return state.sellercategorySelectAll
		},
		getPackage(state){
			return state.package
		},
		getPackageSelect(state){
			return state.packageSelect
		},
		getUserSalarySelect(state){
			return state.userSalarySelect
		},
		getMonth(state){
			return state.month
		},
		getSalary(state){
			return state.salary
		},
		getSpecialUserPackageSelect(state){
			return state.spcialuserpackage
		},
		getUserSalary(state){
			return state.usersalary
		},
		getOrderdetail(state){
			return state.orderdetail
		},
		getOrderReviewdetail(state){
			return state.orderreviewdetail
		},
		getConfirmOrderdetail(state){
			return state.confirmorderdetail
		},
		getPurchaseOrderdetail(state){
			return state.purchaseorderdetail
		},
		getAssetReport(state){
			return state.assetreport
		},
		getIncomeReport(state){
			return state.incomereport
		},
		getExpenseReport(state){
			return state.expensereport
		},
		getStockdetail(state){
			return state.stockdetail
		},
		getKitchenStockdetail(state){
			return state.kitchenstockdetail
		},
		getConfirmOrder(state){
			return state.confirmorder
		},
		getUserOrderdetail(state){
			return state.userorderdetail
		},
		getUserPaydetail(state){
			return state.userpaydetail
		},
		getUserOrderSummarydetail(state){
			return state.userordersummarydetail
		},
		getUserOrderOVeralldetail(state){
			return state.userorderoveralldetail
		},
		getDaybook(state){
			return state.daybook
		},
		getOutStockList(state){
			return state.outstocklist
		},
		getIncomeTopic(state){
			return state.incometopic
		},
		getIncome(state){
			return state.income
		},
		getExpenseTopic(state){
			return state.expensetopic
		},
		getExpense(state){
			return state.expense
		},
		getRoom(state){
			return state.room
		}
	},
	actions:{
		allDashboard(context){
			axios.get("/manager/dashboard")
				.then((response)=>{
					context.commit('dashboards', [response.data])
				})
		},
		allReportDashboard(context){
			axios.get("/manager/report")
				.then((response)=>{
					context.commit('reportdashboards', [response.data])
				})
		},
	
		
		allBillSetting(context){
			axios.get("/manager/billsetting")
				.then((response)=>{
					context.commit('billsettings', response.data.settings)
				})
		},
		getAllBuyerType(context, params){
			axios.get('/manager/customer/buyer?page='+params[0]+'&&search='+params[1])
			.then((response)=>{
				context.commit('allbuyertype', [response.data.buyertypes.data,response.data.pagination])
			})
		},

		getAllSellerType(context, params){
			axios.get('/manager/customer/seller?page='+params[0]+'&&search='+params[1])
			.then((response)=>{
				context.commit('allsellertype', [response.data.sellertypes.data,response.data.pagination])
			})
		},
		allUser(context, params){
			axios.get('/manager/customer?page='+params[0]+'&search='+params[1]+"&type="+params[2])
				.then((response)=>{
					context.commit('useres', [response.data,response.data.pagination])
				})
		},
		allUsertypeSelect(context){
			axios.get('/manager/usertypeList')
				.then((response)=>{
					context.commit('usertypeSelects', response.data.usertypeSelect)
				})
		},
		allSellerUsertypeSelect(context){
			axios.get('/manager/sellerusertypeList')
				.then((response)=>{
					context.commit('sellerusertypeSelects', response.data.sellerusertypeSelect)
				})
		},
		allBuyingCategory(context, params){
			axios.get("/manager/category/buying?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('buyingcategories', [response.data.buyingcategories.data,response.data.pagination])
				})
		},
		allSellingCategory(context, params){
			axios.get("/manager/category/selling?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('sellingcategories', [response.data.sellingcategories.data,response.data.pagination])
				})
		},
		allCounter(context, params){
			axios.get("/manager/counter?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('counters', [response.data.counters.data,response.data.pagination])
				})
		},
		allWaiter(context, params){
			axios.get("/manager/waiter?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('waiters', [response.data.waiters.data,response.data.pagination])
				})
		},
		allKitchen(context, params){
			axios.get("/manager/kitchen?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('kitchens', [response.data.kitchens.data,response.data.pagination])
				})
		},
		allBar(context, params){
			axios.get("/manager/bar?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('bars', [response.data.bars.data,response.data.pagination])
				})
		},
		allVendor(context, params){
			axios.get("/manager/vendor?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('vendors', [response.data.vendors.data,response.data.pagination])
				})
		},
		allVendorAsset(context, params){
			axios.get("/manager/vendorasset?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('vendorassets', [response.data.vendorassets.data,response.data.pagination])
				})
		},
		allTestCategory(context, params){
			axios.get("/manager/testcategory")
				.then((response)=>{
					context.commit('testcategories', [response.data.categories.data,response.data.pagination])
				})
		},
		allUnit(context, params){
			axios.get("/manager/unit?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('units', [response.data.units.data,response.data.pagination])
				})
		},
		allTable(context, params){
			axios.get("/manager/table?page="+params[0])
				.then((response)=>{
					context.commit('tables', [response.data.tables.data,response.data.pagination])
				})
		},
		allItem(context, params){
			axios.get("/manager/item?page="+params[0]+"&search="+params[1]+"&category_id="+params[2])
				.then((response)=>{
					context.commit('items', [response.data.items.data,response.data.pagination])
				})
		},
		allItemImage(context, params){
			axios.get("/manager/item/"+params[0]+"/addimage")
				.then((response)=>{
					context.commit('itemimages', [response.data])
				})
		},
		allCategorySelect(context){
			axios.get('/manager/categoryList')
				.then((response)=>{
					context.commit('categorySelects', response.data.categorySelect)
				})
		},
		allUnitSelect(context){
			axios.get('/manager/unitList')
				.then((response)=>{
					context.commit('unitSelects', response.data.unitSelect)
				})
		},
		allUserSelect(context, type_id){
			// console.log(type_id);
			axios.get('/manager/userList' + (typeof type_id=="undefined"?"":"?type=" + type_id))
				.then((response)=>{
					// console.log(response.data);
					context.commit('userSelects', response.data.userSelect)
				})
		},
		allItemSelect(context){
			axios.get('/manager/itemList')
				.then((response)=>{
					context.commit('itemSelects', response.data.itemSelect)
				})
		},
		allItemSelectReady(context){
			axios.get('/manager/itemListReady') //web.php ln 155 ma update gareko
				.then((response)=>{
					context.commit('itemSelectsReady', response.data.itemSelectReady)
				})
		},
		allTableSelect(context){
			axios.get('/manager/tableList')
				.then((response)=>{
					context.commit('tableSelects', response.data.tableSelect)
				})
		},
		allIncomeTopicSelect(context){
			axios.get('/manager/incometopicList')
				.then((response)=>{
					context.commit('incometopicSelects', response.data.incometopicSelect)
				})
		},
		allExpenseTopicSelect(context){
			axios.get('/manager/expensetopicList')
				.then((response)=>{
					context.commit('expensetopicSelects', response.data.expensetopicSelect)
				})
		},
		allBill(context, id){
			axios.get('/manager/order/'+id+'/preview')
				.then((response)=>{
					context.commit('billes', response.data.bills)
				})
		},
		allReviewBill(context, id){
			axios.get('/manager/review/'+id+'/preview')
				.then((response)=>{
					context.commit('reviewbilles', response.data.reviewbills)
				})
		},
		allBefReviewBill(context, id){
			axios.get('/manager/befreview/'+id+'/preview')
				.then((response)=>{
					context.commit('befreviewbilles', response.data.befreviewbills)
				})
		},
		allConfirmBill(context, id){
			axios.get('/manager/confirm/'+id+'/preview')
				.then((response)=>{
					context.commit('confirmbilles', response.data.bills)
				})
		},
		allOrderBill(context, id){
			axios.get('/manager/confirm/'+id+'/show')
				.then((response)=>{
					context.commit('orderbilles', response.data.bills)
				})
		},
		allStock(context, params){
			axios.get("/manager/stock?page="+params[0]+"&search="+params[1]+"&category_id="+params[2]+"&vendor_id="+params[3]+"&type="+params[4]+"&date="+params[5])
				.then((response)=>{
					context.commit('stocks', [response.data.stocks.data,response.data.pagination])
				})
		},
		allPurchaseList(context, params){
			axios.get("/manager/purchase/list?page="+params[0]+"&search="+params[1]+"&category_id="+params[2]+"&type="+params[3]+"&date="+params[4])
				.then((response)=>{
					context.commit('purchaselists', [response.data.purchaselists.data,response.data.pagination])
				})
		},
		allAsset(context, params){
			axios.get("/manager/asset?page="+params[0]+"&search="+params[1]+"&category_id="+params[2]+"&assetid="+params[3]+"&type="+params[4]+"&date="+params[5])
				.then((response)=>{
					context.commit('assets', [response.data.assets.data,response.data.pagination])
				})
		},
		allBuyerSelect(context){
			axios.get('/manager/buyerList')
				.then((response)=>{
					context.commit('buyerSelects', response.data.buyerSelect)
				})
		},
		allBuyerCategorySelect(context){
			axios.get('/manager/buyercategoryList')
				.then((response)=>{
					context.commit('buyercategorySelects', response.data.buyercategorySelect)
				})
		},
		allBuyerCategorySelectAll(context){
			axios.get('/manager/buyercategoryListAll')
				.then((response)=>{
					context.commit('buyercategorySelectsAll', response.data.buyercategorySelectAll)
				})
		},
		allSellerCategorySelectAll(context){
			axios.get('/manager/sellercategoryListAll')
				.then((response)=>{
					context.commit('sellercategorySelectsAll', response.data.sellercategorySelectAll)
				})
		},
		allPackage(context, params){
			axios.get("/manager/package?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('packages', [response.data.packages.data,response.data.pagination])
				})
		},
		allPackageSelect(context){
			axios.get('/manager/packageList')
				.then((response)=>{
					context.commit('packageSelects', response.data.packageSelect)
				})
		},
		allUserSalarySelect(context){
			axios.get('/manager/userSalaryList')
				.then((response)=>{
					context.commit('userSalarySelects', response.data.userSalarySelect)
				})
		}
		,
		allMonth(context){
			axios.get('/manager/month')
				.then((response)=>{
					context.commit('months', response.data.months)
				})
		},
		allSalary(context, params){
			axios.get("/manager/salary?page="+params[0]+"&search="+params[1]+"&month_id="+params[2])
				.then((response)=>{
					context.commit('salaries', [response.data.salaries.data,response.data.pagination])
				})
		},
		allSpecialUserPackage(context, user_id){
			axios.get('/manager/spcialuserpackage' + (typeof user_id=="undefined"?"":"?user=" + user_id))
				.then((response)=>{
					context.commit('spcialuserpackages', response.data.spcialuserpackage)
				})
		},
		allUserSalary(context, params){
			axios.get("/manager/salary/"+params[0])
				.then((response)=>{
					context.commit('usersalaries', response.data)
				})
		},
		allOrderdetail(context, params){
			axios.get("/manager/confirm?page="+params[0]+"&search="+params[1]+"&user_type="+params[2]+"&table_id="+params[3]+"&date="+params[4])
				.then((response)=>{
					context.commit('orderdetails', [response.data.orderdetails.data,response.data.pagination])
				})
		},
		allOrderReviewdetail(context, params){
			axios.get("/manager/review?page="+params[0]+"&search="+params[1]+"&user_type="+params[2]+"&table_id="+params[3]+"&date="+params[4])
				.then((response)=>{
					context.commit('orderreviewdetails', [response.data.orderreviewdetails.data,response.data.pagination])
				})
		},
		allConfirmOrderdetail(context, params){
			axios.get("/manager/report/sales?page="+params[0]+"&search="+params[1]+"&user_type="+params[2]+"&table_id="+params[3]+"&bill_type="+params[4]+"&date1="+params[5]+"&date2="+params[6])
				.then((response)=>{
					context.commit('confirmorderdetails', [response.data,response.data.pagination])
				})
		},
		allPurchaseOrderdetail(context, params){
			axios.get("/manager/report/purchases?page="+params[0]+"&buyer_id="+params[1]+"&search="+params[2]+"&category_id="+params[3]+"&type="+params[4]+"&date1="+params[5]+"&date2="+params[6])
				.then((response)=>{
					context.commit('purchaseorderdetails', [response.data,response.data.pagination])
				})
		},
		allAssetReport(context, params){
			axios.get("/manager/report/asset?page="+params[0]+"&buyer_id="+params[1]+"&search="+params[2]+"&category_id="+params[3])
				.then((response)=>{
					context.commit('assetreports', [response.data,response.data.pagination])
				})
		},
		allIncomeReport(context, params){
			axios.get("/manager/report/incomereport?page="+params[0]+"&date1="+params[1]+"&date2="+params[2])
				.then((response)=>{
					// console.log(response.data.incomereports.data);
					context.commit('incomereports', [response.data.incomereports.data,response.data.pagination,response.data.total])
				})
		},
		allExpenseReport(context, params){
			axios.get("/manager/report/expensereport?page="+params[0]+"&date1="+params[1]+"&date2="+params[2])
				.then((response)=>{
					// console.log(response.data.expensereports.data);
					context.commit('expensereports', [response.data.expensereports.data,response.data.pagination,response.data.total])
				})
		},
		allStockdetail(context, params){
			axios.get("/manager/report/stocks?page="+params[0]+"&search="+params[1]+"&category_id="+params[2]+"&type="+params[3]+"&date1="+params[4]+"&date2="+params[5])
				.then((response)=>{
					context.commit('stockdetails', [response.data,response.data.pagination])
				})
		},
		allKitchenStockdetail(context, params){
			axios.get("/manager/report/kitchen-stocks?page="+params[0]+"&search="+params[1]+"&category_id="+params[2])
				.then((response)=>{
					context.commit('kitchenstockdetails', [response.data,response.data.pagination])
				})
		},
		allConfirmOrder(context, params){
			axios.get("/manager/report/items?page="+params[0]+"&category_id="+params[1]+"&item_id="+params[2]+"&date1="+params[3]+"&date2="+params[4])
				.then((response)=>{
					context.commit('confirmorders', [response.data,response.data.pagination])
				})
		},
		allUserOrderdetail(context, params){
			axios.get("/manager/report/customer?page="+params[0]+"&user_id="+params[1])
				.then((response)=>{
					context.commit('userorderdetails', [response.data,response.data.pagination])
				})
		},
		allUserPaydetail(context, params){
			axios.get("/manager/report/customer/pay?page="+params[0]+"&user_id="+params[1])
				.then((response)=>{
					context.commit('userpaydetails', [response.data,response.data.pagination])
				})
		},
		allUserOrderSummarydetail(context, params){
			// console.log(params[1]);
			axios.get("/manager/report/customer/seller?page="+params[0]+"&user_id="+params[1]+"&receive_type="+params[2]+"&bill_type="+params[3]+"&date1="+params[4]+"&date2="+params[5])
				.then((response)=>{
					context.commit('userordersummarydetails', [response.data,response.data.pagination])
				})
		},
		allUserOrderOVeralldetail(context, params){
			axios.get("/manager/report/overall?page="+params[0]+"&receive_type="+params[1]+"&bill_type="+params[2]+"&date1="+params[3]+"&date2="+params[4])
				.then((response)=>{
					context.commit('userorderoveralldetails', [response.data,response.data.pagination])
				})
		},
		allDaybook(context, params){
			axios.get("/manager/report/daybook?&date="+params[0])
				.then((response)=>{
					context.commit('daybookss', response.data)
				})
		},
		allOutStockList(context, params){
			axios.get("/manager/stock/out/"+params[0]+"/list")
				.then((response)=>{
					context.commit('outstocklists', [response.data.outstocklists])
				})
		},
		allIncomeTopic(context, params){
			axios.get("/manager/income/topic?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('incometopics', [response.data.incometopics.data,response.data.pagination])
				})
		},
		allIncome(context, params){
			axios.get("/manager/income?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('incomes', [response.data.incomes.data,response.data.pagination])
				})
		},
		allExpenseTopic(context, params){
			axios.get("/manager/expense/topic?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('expensetopics', [response.data.expensetopics.data,response.data.pagination])
				})
		},
		allExpense(context, params){
			axios.get("/manager/expense?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('expenses', [response.data.expenses.data,response.data.pagination])
				})
		},
		allRoom(context, params){
			// console.log(params);
			axios.get("/manager/room?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('rooms', [response.data.rooms.data,response.data.pagination])
				})
		}
	},
	mutations:{
		dashboards(state, payload){
			return state.dashboard = payload
		},
		reportdashboards(state, payload){
			return state.reportdashboard = payload
		},
	
		
		billsettings(state,data){
			return state.billsetting = data
		},
		allbuyertype(state, payload){
			return state.buyertype = payload
		},
		allsellertype(state, payload){
			return state.sellertype = payload
		},
		useres(state, data){
			return state.user = data
		},
		usertypeSelects(state, data){
			return state.usertypeSelect = data
		},
		sellerusertypeSelects(state, data){
			return state.sellerusertypeSelect = data
		},
		buyingcategories(state, data){
			return state.buyingcategory = data
		},
		sellingcategories(state, data){
			return state.sellingcategory = data
		},
		counters(state, data){
			return state.counter = data
		},
		waiters(state, data){
			return state.waiter = data
		},
		kitchens(state, data){
			return state.kitchen = data
		},
		bars(state, data){
			return state.bar = data
		},
		vendors(state, data){
			return state.vendor = data
		},
		vendorassets(state, data){
			return state.vendorasset = data
		},
		testcategories(state, data){
			return state.testcategory = data
		},
		units(state, data){
			return state.unit = data
		},
		tables(state, data){
			return state.table = data
		},
		items(state, data){
			return state.item = data
		},
		itemimages(state, data){
			return state.itemimage = data
		},
		categorySelects(state, data){
			return state.categorySelect = data
		},
		unitSelects(state, data){
			return state.unitSelect = data
		},
		userSelects(state, data){
			return state.userSelect = data
		},
		itemSelects(state, data){
			return state.itemSelect = data
		},
		itemSelectsReady(state, data){
			return state.itemSelectReady = data
		},
		tableSelects(state, data){
			return state.tableSelect = data
		},
		incometopicSelects(state, data){
			return state.incometopicSelect = data
		},
		expensetopicSelects(state, data){
			return state.expensetopicSelect = data
		},
		billes(state,data){
			return state.bill = data
		},
		reviewbilles(state,data){
			return state.reviewbill = data
		},
		befreviewbilles(state,data){
			return state.befreviewbill = data
		},
		confirmbilles(state,data){
			return state.confirmbill = data
		},
		orderbilles(state,data){
			return state.orderbill = data
		},
		stocks(state, data){
			return state.stock = data
		},
		purchaselists(state, data){
			return state.purchaselist = data
		},
		assets(state, data){
			return state.asset = data
		},
		buyerSelects(state, data){
			return state.buyerSelect = data
		},
		buyercategorySelects(state, data){
			return state.buyercategorySelect = data
		},
		buyercategorySelectsAll(state, data){
			return state.buyercategorySelectAll = data
		},
		sellercategorySelectsAll(state, data){
			return state.sellercategorySelectAll = data
		},
		packages(state, data){
			return state.package = data
		},
		packageSelects(state, data){
			return state.packageSelect = data
		},
		userSalarySelects(state, data){
			return state.userSalarySelect = data
		},
		months(state, data){
			return state.month = data
		},
		salaries(state, data){
			return state.salary = data
		},
		spcialuserpackages(state, data){
			return state.spcialuserpackage = data
		},
		usersalaries(state, data){
			return state.usersalary = data
		},
		orderdetails(state, data){
			return state.orderdetail = data
		},
		orderreviewdetails(state, data){
			return state.orderreviewdetail = data
		},
		confirmorderdetails(state, data){
			return state.confirmorderdetail = data
		},
		purchaseorderdetails(state, data){
			return state.purchaseorderdetail = data
		},
		assetreports(state, data){
			return state.assetreport = data
		},
		incomereports(state, data){
			return state.incomereport = data
		},
		expensereports(state, data){
			return state.expensereport = data
		},
		stockdetails(state, data){
			return state.stockdetail = data
		},
		kitchenstockdetails(state, data){
			return state.kitchenstockdetail = data
		},
		confirmorders(state, data){
			return state.confirmorder = data
		},
		userorderdetails(state, data){
			return state.userorderdetail = data
		},
		userpaydetails(state, data){
			return state.userpaydetail = data
		},
		userordersummarydetails(state, data){
			return state.userordersummarydetail = data
		},
		userorderoveralldetails(state, data){
			return state.userorderoveralldetail = data
		},
		daybookss(state,data){
			return state.daybook = data
		},
		outstocklists(state,data){
			return state.outstocklist = data
		},
		incometopics(state, data){
			return state.incometopic = data
		},
		incomes(state, data){
			return state.income = data
		},
		expensetopics(state, data){
			return state.expensetopic = data
		},
		expenses(state, data){
			return state.expense = data
		},
		rooms(state, data){
			return state.room = data
		}
	}
}