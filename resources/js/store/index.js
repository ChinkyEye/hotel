export default{
	state:{
		dashboard:[],
		reportdashboard:[],
		fiscalyear:[],
		selectfiscalyear:[],
		setting:[],
		billsetting:[],
		buyertype:[],
		sellertype:[],
		user:[],
		usertypeSelect : [],
		sellerusertypeSelect : [],
		buyingcategory:[],
		sellingcategory:[],
		manager:[],
		testcategory:[],
		unit:[],
		table:[],
		item:[],
		stockoutlist:[],
		categorySelect : [],
		unitSelect : [],
		userSelect : [],
		itemSelect : [],
		tableSelect : [],
		counterSelect : [],
		waiterSelect : [],
		managerSelect : [],
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
		confirmorderdetail:[],
		confirmorder:[],
		counterorderdetail:[],
		purchaseorderdetail:[],
		stockdetail:[],
		kitchenstockdetail:[],
		userorderdetail:[],
		userpaydetail:[],
		userordersummarydetail:[],
		userorderoveralldetail:[],
		billorderdetail:[],
		daybook:[],
		waiterreport:[],
		assetreport:[],
		activitylog:[],
		incometopic:[],
		income:[],
		expensetopic:[],
		expense:[],
		room:[],
		incometopicSelect : [],
		expensetopicSelect : [],
		incomereport:[],
		expensereport:[],
		roomreport:[],
	},
	getters:{
		getDashboard(state){
			return state.dashboard
		},
		getReportDashboard(state){
			return state.reportdashboard
		},
		getFiscalYear(state){
			return state.fiscalyear
		},
		getSelectFiscalYear(state){
			return state.selectfiscalyear
		},
		getSetting(state){
			return state.setting
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
		getManager(state){
			return state.manager
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
		getStockOutList(state){
			return state.stockoutlist
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
		getTableSelect(state){
			return state.tableSelect
		},
		getCounterSelect(state){
			return state.counterSelect
		},
		getWaiterSelect(state){
			return state.waiterSelect
		},
		getManagerSelect(state){
			return state.managerSelect
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
		getConfirmOrderdetail(state){
			return state.confirmorderdetail
		},
		getConfirmOrder(state){
			return state.confirmorder
		},
		getCounterOrderdetail(state){
			return state.counterorderdetail
		},
		getPurchaseOrderdetail(state){
			return state.purchaseorderdetail
		},
		getAssetReport(state){
			return state.assetreport
		},
		getStockdetail(state){
			return state.stockdetail
		},
		getKitchenStockdetail(state){
			return state.kitchenstockdetail
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
		getBillOrderdetail(state){
			return state.billorderdetail
		},
		getDaybook(state){
			return state.daybook
		},
		getWaiterReport(state){
			return state.waiterreport
		},
		getActivityLog(state){
			return state.activitylog
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
		},
		getIncomeTopicSelect(state){
			return state.incometopicSelect
		},
		getExpenseTopicSelect(state){
			return state.expensetopicSelect
		},
		getIncomeReport(state){
			return state.incomereport
		},
		getExpenseReport(state){
			return state.expensereport
		},
		getRoomReport(state){
			return state.roomreport
		},
	},
	actions:{
		allDashboard(context){
			axios.get("/home/dashboard")
				.then((response)=>{
					// debugger;
					context.commit('dashboards', [response.data])
				})
		},
		allReportDashboard(context){
			axios.get("/home/report")
				.then((response)=>{
					context.commit('reportdashboards', [response.data])
				})
		},
		allFiscalYear(context, params){
			axios.get("/home/fiscalyear?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					// console.log(response.data.fiscalyears.data);
					context.commit('fiscalyears', [response.data.fiscalyears.data,response.data.pagination])
				})
		},
		allSelectFiscalYear(context){
			axios.get("/home/fiscalyear/select/getAllFiscalYear")
				.then((response)=>{
					context.commit('selectfiscalyears', [response.data.selectfiscalyears[0]])
				})
		},
		allSetting(context, params){
			axios.get("/home/setting?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('settings', [response.data.settings.data,response.data.pagination])
				})
		},
		allBillSetting(context){
			axios.get("/home/billsetting")
				.then((response)=>{
					context.commit('billsettings', response.data.settings)
				})
		},
		getAllBuyerType(context, params){
			axios.get('/home/customer/buyer?page='+params[0]+'&&search='+params[1])
			.then((response)=>{
				context.commit('allbuyertype', [response.data.buyertypes.data,response.data.pagination])
			})
		},

		getAllSellerType(context, params){
			axios.get('/home/customer/seller?page='+params[0]+'&&search='+params[1])
			.then((response)=>{
				context.commit('allsellertype', [response.data.sellertypes.data,response.data.pagination])
			})
		},
		allUser(context, params){
			axios.get('/home/customer?page='+params[0]+'&&search='+params[1]+"&type="+params[2])
				.then((response)=>{
					context.commit('useres', [response.data,response.data.pagination])
				})
		},
		allUsertypeSelect(context){
			axios.get('/home/usertypeList')
				.then((response)=>{
					context.commit('usertypeSelects', response.data.usertypeSelect)
				})
		},
		allSellerUsertypeSelect(context){
			axios.get('/home/sellerusertypeList')
				.then((response)=>{
					context.commit('sellerusertypeSelects', response.data.sellerusertypeSelect)
				})
		},
		allBuyingCategory(context, params){
			axios.get("/home/category/buying?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('buyingcategories', [response.data.buyingcategories.data,response.data.pagination])
				})
		},
		allSellingCategory(context, params){
			axios.get("/home/category/selling?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('sellingcategories', [response.data.sellingcategories.data,response.data.pagination])
				})
		},
		allManager(context, params){
			axios.get("/home/manager?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('managers', [response.data.managers.data,response.data.pagination])
				})
		},
		allTestCategory(context, params){
			axios.get("/home/testcategory")
				.then((response)=>{
					context.commit('testcategories', [response.data.categories.data,response.data.pagination])
				})
		},
		allUnit(context, params){
			axios.get("/home/unit?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('units', [response.data.units.data,response.data.pagination])
				})
		},
		allTable(context, params){
			axios.get("/home/table?page="+params[0])
				.then((response)=>{
					context.commit('tables', [response.data.tables.data,response.data.pagination])
				})
		},
		allItem(context, params){
			axios.get("/home/item?page="+params[0]+"&search="+params[1]+"&category_id="+params[2])
				.then((response)=>{
					context.commit('items', [response.data.items.data,response.data.pagination])
				})
		},
		allStockOutList(context, params){
			axios.get("/home/stock/"+params[0]+"/out/list")
				.then((response)=>{
					context.commit('stockoutlists', [response.data.stockoutlists.data,response.data.pagination])
				})
		},
		allCategorySelect(context){
			axios.get('/home/categoryList')
				.then((response)=>{
					context.commit('categorySelects', response.data.categorySelect)
				})
		},
		allUnitSelect(context){
			axios.get('/home/unitList')
				.then((response)=>{
					context.commit('unitSelects', response.data.unitSelect)
				})
		},
		allUserSelect(context, type_id){
			axios.get('/home/userList' + (typeof type_id=="undefined"?"":"?type=" + type_id))
				.then((response)=>{
					context.commit('userSelects', response.data.userSelect)
				})
		},
		allItemSelect(context){
			axios.get('/home/itemList')
				.then((response)=>{
					context.commit('itemSelects', response.data.itemSelect)
				})
		},
		allTableSelect(context){
			axios.get('/home/tableList')
				.then((response)=>{
					context.commit('tableSelects', response.data.tableSelect)
				})
		},
		allCounterSelect(context){
			axios.get('/home/counterList')
				.then((response)=>{
					context.commit('counterSelects', response.data.counterSelect)
				})
		},
		allWaiterSelect(context){
			axios.get('/home/waiterList')
				.then((response)=>{
					context.commit('waiterSelects', response.data.waiterSelect)
				})
		},
		allManagerSelect(context){
			axios.get('/home/managerList')
				.then((response)=>{
					context.commit('managerSelects', response.data.managerSelect)
				})
		},
		allBill(context, id){
			axios.get('/home/order/'+id+'/preview')
				.then((response)=>{
					context.commit('billes', response.data.bills)
				})
		},
		allReviewBill(context, id){
			axios.get('/home/review/'+id+'/preview')
				.then((response)=>{
					context.commit('reviewbilles', response.data.reviewbills)
				})
		},
		allBefReviewBill(context, id){
			axios.get('/home/befreview/'+id+'/preview')
				.then((response)=>{
					context.commit('befreviewbilles', response.data.befreviewbills)
				})
		},
		allConfirmBill(context, id){
			axios.get('/home/confirm/'+id+'/preview')
				.then((response)=>{
					context.commit('confirmbilles', response.data.bills)
				})
		},
		allOrderBill(context, id){
			axios.get('/home/confirm/'+id+'/show')
				.then((response)=>{
					context.commit('orderbilles', response.data.bills)
				})
		},
		allStock(context, params){
			axios.get("/home/stock?page="+params[0]+"&search="+params[1]+"&category_id="+params[2]+"&startdate="+params[3]+"&enddate="+params[4])
				.then((response)=>{
					context.commit('stocks', [response.data.stocks.data,response.data.pagination])
				})
		},
		allPurchaseList(context, params){
			axios.get("/home/purchase/list?page="+params[0]+"&search="+params[1]+"&category_id="+params[2]+"&type="+params[3]+"&date="+params[4])
				.then((response)=>{
					context.commit('purchaselists', [response.data.purchaselists.data,response.data.pagination])
				})
		},
		allAsset(context, params){
			axios.get("/home/asset?page="+params[0]+"&search="+params[1]+"&category_id="+params[2])
				.then((response)=>{
					context.commit('assets', [response.data.assets.data,response.data.pagination])
				})
		},
		allBuyerSelect(context){
			axios.get('/home/buyerList')
				.then((response)=>{
					context.commit('buyerSelects', response.data.buyerSelect)
				})
		},
		allBuyerCategorySelect(context){
			axios.get('/home/buyercategoryList')
				.then((response)=>{
					context.commit('buyercategorySelects', response.data.buyercategorySelect)
				})
		},
		allBuyerCategorySelectAll(context){
			axios.get('/home/buyercategoryListAll')
				.then((response)=>{
					context.commit('buyercategorySelectsAll', response.data.buyercategorySelectAll)
				})
		},
		allSellerCategorySelectAll(context){
			axios.get('/home/sellercategoryListAll')
				.then((response)=>{
					context.commit('sellercategorySelectsAll', response.data.sellercategorySelectAll)
				})
		},
		allPackage(context, params){
			axios.get("/home/package?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('packages', [response.data.packages.data,response.data.pagination])
				})
		},
		allPackageSelect(context){
			axios.get('/home/packageList')
				.then((response)=>{
					context.commit('packageSelects', response.data.packageSelect)
				})
		},
		allUserSalarySelect(context){
			axios.get('/home/userSalaryList')
				.then((response)=>{
					context.commit('userSalarySelects', response.data.userSalarySelect)
				})
		}
		,
		allMonth(context){
			axios.get('/home/month')
				.then((response)=>{
					context.commit('months', response.data.months)
				})
		},
		allSalary(context, params){
			axios.get("/home/salary?page="+params[0]+"&search="+params[1]+"&month_id="+params[2])
				.then((response)=>{
					context.commit('salaries', [response.data.salaries.data,response.data.pagination])
				})
		},
		allSpecialUserPackage(context, user_id){
			axios.get('/home/spcialuserpackage' + (typeof user_id=="undefined"?"":"?user=" + user_id))
				.then((response)=>{
					context.commit('spcialuserpackages', response.data.spcialuserpackage)
				})
		},
		allUserSalary(context, params){
			axios.get("/home/salary/"+params[0])
				.then((response)=>{
					context.commit('usersalaries', response.data)
				})
		},
		allOrderdetail(context, params){
			axios.get("/home/confirm?page="+params[0]+"&search="+params[1]+"&date="+params[2]+"&user_type="+params[3]+"&table_id="+params[4]+"&status_id="+params[5])
				.then((response)=>{
					context.commit('orderdetails', [response.data.orderdetails.data,response.data.pagination])
				})
		},
		allConfirmOrderdetail(context, params){
			axios.get("/home/report/sales?page="+params[0]+"&search="+params[1]+"&user_type="+params[2]+"&table_id="+params[3]+"&manager_id="+params[4]+"&bill_type="+params[5]+"&date1="+params[6]+"&date2="+params[7])
				.then((response)=>{
					context.commit('confirmorderdetails', [response.data,response.data.pagination])
				})
		},
		allConfirmOrder(context, params){
			axios.get("/home/report/items?page="+params[0]+"&category_id="+params[1]+"&item_id="+params[2]+"&manager_id="+params[3]+"&date1="+params[4]+"&date2="+params[5])
				.then((response)=>{
					context.commit('confirmorders', [response.data,response.data.pagination])
				})
		},
		allCounterOrderdetail(context, params){
			axios.get("/home/report/counter?&counter_id="+params[0]+"&date1="+params[1]+"&date2="+params[2])
				.then((response)=>{
					context.commit('counterorderdetailss', [response.data,response.data.pagination])
				})
		},
		allPurchaseOrderdetail(context, params){
			axios.get("/home/report/purchases?page="+params[0]+"&buyer_id="+params[1]+"&search="+params[2]+"&category_id="+params[3]+"&manager_id="+params[4]+"&date1="+params[5]+"&date2="+params[6])
				.then((response)=>{
					context.commit('purchaseorderdetails', [response.data,response.data.pagination])
				})
		},
		allAssetReport(context, params){
			axios.get("/home/report/asset?page="+params[0]+"&buyer_id="+params[1]+"&search="+params[2]+"&category_id="+params[3]+"&manager_id="+params[4])
				.then((response)=>{
					context.commit('assetreports', [response.data,response.data.pagination])
				})
		},
		allStockdetail(context, params){
			axios.get("/home/report/stocks?page="+params[0]+"&search="+params[1]+"&category_id="+params[2]+"&manager_id="+params[3]+"&type="+params[4]+"&date1="+params[5]+"&date2="+params[6])
				.then((response)=>{
					context.commit('stockdetails', [response.data,response.data.pagination])
				})
		},
		allKitchenStockdetail(context, params){
			axios.get("/home/report/kitchen-stocks?page="+params[0]+"&search="+params[1]+"&category_id="+params[2]+"&manager_id="+params[3])
				.then((response)=>{
					context.commit('kitchenstockdetails', [response.data,response.data.pagination])
				})
		},
		allUserOrderdetail(context, params){
			axios.get("/home/report/customer?page="+params[0]+"&user_id="+params[1])
				.then((response)=>{
					context.commit('userorderdetails', [response.data,response.data.pagination])
				})
		},
		allUserPaydetail(context, params){
			axios.get("/home/report/customer/pay?page="+params[0]+"&user_id="+params[1])
				.then((response)=>{
					context.commit('userpaydetails', [response.data,response.data.pagination])
				})
		},
		allUserOrderSummarydetail(context, params){
			axios.get("/home/report/customer/seller?page="+params[0]+"&user_id="+params[1]+"&receive_type="+params[2]+"&bill_type="+params[3]+"&date1="+params[4]+"&date2="+params[5])
				.then((response)=>{
					context.commit('userordersummarydetails', [response.data,response.data.pagination])
				})
		},
		allUserOrderOVeralldetail(context, params){
			axios.get("/home/report/overall?page="+params[0]+"&receive_type="+params[1]+"&bill_type="+params[2]+"&date1="+params[3]+"&date2="+params[4]+"&counter_id="+params[5])
				.then((response)=>{
					context.commit('userorderoveralldetails', [response.data,response.data.pagination])
				})
		},
		allBillOrderdetail(context, params){
			axios.get("/home/report/bill?page="+params[0]+"&search="+params[1]+"&date1="+params[2]+"&date2="+params[3])
				.then((response)=>{
					context.commit('billorderdetails', [response.data,response.data.pagination])
				})
		},
		allDaybook(context, params){
			axios.get("/home/report/daybook?&date="+params[0])
				.then((response)=>{
					context.commit('daybookss', response.data)
				})
		},
		allWaiterReport(context, params){
			axios.get("/home/report/waiter?page="+params[0]+"&waiter_id="+params[1]+"&date="+params[2])
				.then((response)=>{
					context.commit('waiterreports', [response.data,response.data.pagination])
				})
		},
		allActivityLog(context, params){
			axios.get("/home/activitylog?page="+params[0])
				.then((response)=>{
					// console.log(response.data.activitylogs.data);
					context.commit('activitylogs', [response.data.activitylogs.data,response.data.pagination])
				})
		},
		allIncomeTopic(context, params){
			axios.get("/home/income/topic?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('incometopics', [response.data.incometopics.data,response.data.pagination])
				})
		},
		allIncome(context, params){
			axios.get("/home/income?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('incomes', [response.data.incomes.data,response.data.pagination])
				})
		},
		allExpenseTopic(context, params){
			axios.get("/home/expense/topic?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('expensetopics', [response.data.expensetopics.data,response.data.pagination])
				})
		},
		allExpense(context, params){
			axios.get("/home/expense?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('expenses', [response.data.expenses.data,response.data.pagination])
				})
		},
		allRoom(context, params){
			// console.log(params);
			axios.get("/home/room?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('rooms', [response.data.rooms.data,response.data.pagination])
				})
		},
		allIncomeTopicSelect(context){
			axios.get('/home/incometopicList')
				.then((response)=>{
					context.commit('incometopicSelects', response.data.incometopicSelect)
				})
		},
		allExpenseTopicSelect(context){
			axios.get('/home/expensetopicList')
				.then((response)=>{
					context.commit('expensetopicSelects', response.data.expensetopicSelect)
				})
		},
		allIncomeReport(context, params){
			axios.get("/home/report/incomereport?page="+params[0]+"&date1="+params[1]+"&date2="+params[2])
				.then((response)=>{
					// console.log(response.data.incomereports.data);
					context.commit('incomereports', [response.data.incomereports.data,response.data.pagination,response.data.total])
				})
		},
		allExpenseReport(context, params){
			axios.get("/home/report/expensereport?page="+params[0]+"&date1="+params[1]+"&date2="+params[2])
				.then((response)=>{
					// console.log(response.data.expensereports.data);
					context.commit('expensereports', [response.data.expensereports.data,response.data.pagination,response.data.total])
				})
		},
		allRoomReport(context, params){
			axios.get("/home/report/roomreport")
				.then((response)=>{
					console.log(response.data.roomreports.data);
					context.commit('roomreports', [response.data.roomreports.data,response.data.pagination])
				})
		},
	},
	mutations:{
		dashboards(state, payload){
			return state.dashboard = payload
		},
		reportdashboards(state, payload){
			return state.reportdashboard = payload
		},
		fiscalyears(state, data)
		{
			return state.fiscalyear = data
		},
		selectfiscalyears(state, data){
			return state.selectfiscalyear = data
		},
		settings(state, data){
			return state.setting = data
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
		managers(state, data){
			return state.manager = data
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
		stockoutlists(state, data){
			return state.stockoutlist = data
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
		tableSelects(state, data){
			return state.tableSelect = data
		},
		counterSelects(state, data){
			return state.counterSelect = data
		},
		waiterSelects(state, data){
			return state.waiterSelect = data
		},
		managerSelects(state, data){
			return state.managerSelect = data
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
		assetreports(state, data){
			return state.assetreport = data
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
		confirmorderdetails(state, data){
			return state.confirmorderdetail = data
		},
		confirmorders(state, data){
			return state.confirmorder = data
		},
		counterorderdetailss(state, data){
			return state.counterorderdetail = data
		},

		purchaseorderdetails(state, data){
			return state.purchaseorderdetail = data
		},
		stockdetails(state, data){
			return state.stockdetail = data
		},
		kitchenstockdetails(state, data){
			return state.kitchenstockdetail = data
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
		billorderdetails(state, data){
			return state.billorderdetail = data
		},
		daybookss(state,data){
			return state.daybook = data
		},
		waiterreports(state,data){
			return state.waiterreport = data
		},
		activitylogs(state,data){
			return state.activitylog = data
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
		},
		incometopicSelects(state, data){
			return state.incometopicSelect = data
		},
		expensetopicSelects(state, data){
			return state.expensetopicSelect = data
		},
		incomereports(state, data){
			return state.incomereport = data
		},
		expensereports(state, data){
			return state.expensereport = data
		},
		roomreports(state, data){
			return state.roomreport = data
		},
	}
}