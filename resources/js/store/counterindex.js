export default{
	state:{
		dashboard:[],
		billsetting:[],
		usertype:[],
		user:[],
		usertypeSelect : [],
		sellerusertypeSelect : [],
		buyingcategory:[],
		sellingcategory:[],
		testcategory:[],
		unit:[],
		table:[],
		item:[],
		categorySelect : [],
		unitSelect : [],
		userSelect : [],
		itemSelect : [],
		itemSelectReady : [],
		tableSelect : [],
		bill : [],
		barbill : [],
		reviewbill : [],
		befreviewbill : [],
		confirmbill : [],
		stock:[],
		buyerSelect : [],
		buyercategorySelect : [],
		buyercategorySelectAll : [],
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
		confirmorder:[],
		userorderdetail:[],
		userpaydetail:[],
		userordersummarydetail:[],
		userorderoveralldetail:[],
		checkin:[],
		customerSelect:[],
		roomSelect:[],
		customerorderdetail:[],
	},
	getters:{
		getDashboard(state){
			return state.dashboard
		},
		getBillSetting(state){
			return state.billsetting
		},
		getUserType(state){
			return state.usertype
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
		getBill(state){
			return state.bill
		},
		getBarBill(state){
			return state.barbill
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
		getStock(state){
			return state.stock
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
		getCustomerOrderdetail(state){
			return state.customerorderdetail
		},
		getOrderReviewdetail(state){
			return state.orderreviewdetail
		},
		getConfirmOrderdetail(state){
			return state.confirmorderdetail
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
		getCheckIn(state){
			return state.checkin
		},
		getCustomerSelect(state){
			return state.customerSelect
		},
		getRoomSelect(state){
			return state.roomSelect
		}
	},
	actions:{
		allDashboard(context){
			axios.get("/counter/dashboard")
				.then((response)=>{
					context.commit('dashboards', [response.data])
				})
		},
		allBillSetting(context){
			axios.get("/counter/billsetting")
				.then((response)=>{
					context.commit('billsettings', response.data.settings)
				})
		},
		getAllUserType(context, params){
			axios.post('/counter/user-type/search',{
				search: params[0],
				page: params[1]
			})
			.then((response)=>{
				context.commit('allusertype', response.data)
			})
		},
		allUser(context, params){
			axios.get('/counter/customer?page='+params[0]+'&search='+params[1]+"&type="+params[2])
				.then((response)=>{
					context.commit('useres', [response.data,response.data.pagination])
				})
		},
		allUsertypeSelect(context){
			axios.get('/counter/usertypeList')
				.then((response)=>{
					context.commit('usertypeSelects', response.data.usertypeSelect)
				})
		},
		allSellerUsertypeSelect(context){
			axios.get('/counter/sellerusertypeList')
				.then((response)=>{
					context.commit('sellerusertypeSelects', response.data.sellerusertypeSelect)
				})
		},
		allBuyingCategory(context, params){
			axios.get("/counter/category/buying?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('buyingcategories', [response.data.buyingcategories.data,response.data.pagination])
				})
		},
		allSellingCategory(context, params){
			axios.get("/counter/category/selling?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('sellingcategories', [response.data.sellingcategories.data,response.data.pagination])
				})
		},
		allTestCategory(context, params){
			axios.get("/counter/testcategory")
				.then((response)=>{
					context.commit('testcategories', [response.data.categories.data,response.data.pagination])
				})
		},
		allUnit(context, params){
			axios.get("/counter/unit?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('units', [response.data.units.data,response.data.pagination])
				})
		},
		allTable(context, params){
			axios.get("/counter/table?page="+params[0])
				.then((response)=>{
					context.commit('tables', [response.data.tables.data,response.data.pagination])
				})
		},
		allItem(context, params){
			axios.get("/counter/item?page="+params[0]+"&search="+params[1]+"&category_id="+params[2])
				.then((response)=>{
					context.commit('items', [response.data.items.data,response.data.pagination])
				})
		},
		allCategorySelect(context){
			axios.get('/counter/categoryList')
				.then((response)=>{
					context.commit('categorySelects', response.data.categorySelect)
				})
		},
		allUnitSelect(context){
			axios.get('/counter/unitList')
				.then((response)=>{
					context.commit('unitSelects', response.data.unitSelect)
				})
		},
		allUserSelect(context, type_id){
			axios.get('/counter/userList' + (typeof type_id=="undefined"?"":"?type=" + type_id))
				.then((response)=>{
					context.commit('userSelects', response.data.userSelect)
				})
		},
		allItemSelect(context){
			axios.get('/counter/itemList')
				.then((response)=>{
					context.commit('itemSelects', response.data.itemSelect)
				})
		},
		allItemSelectReady(context){
			axios.get('/counter/itemListReady') //web.php ln 155 ma update gareko
				.then((response)=>{
					context.commit('itemSelectsReady', response.data.itemSelectReady)
				})
		},
		allTableSelect(context){
			axios.get('/counter/tableList')
				.then((response)=>{
					context.commit('tableSelects', response.data.tableSelect)
				})
		},
		allBill(context, id){
			axios.get('/counter/order/'+id+'/preview')
				.then((response)=>{
					context.commit('billes', response.data.bills)
				})
		},
		allBarBill(context, id){
			axios.get('/counter/order/'+id+'/preview/bar')
				.then((response)=>{
					context.commit('barbilles', response.data.bills)
				})
		},
		allReviewBill(context, id){
			axios.get('/counter/review/'+id+'/preview')
				.then((response)=>{
					context.commit('reviewbilles', response.data.reviewbills)
				})
		},
		allBefReviewBill(context, id){
			axios.get('/counter/befreview/'+id+'/preview')
				.then((response)=>{
					context.commit('befreviewbilles', response.data.befreviewbills)
				})
		},
		allConfirmBill(context, id){
			axios.get('/counter/confirm/'+id+'/preview')
				.then((response)=>{
					context.commit('confirmbilles', response.data.bills)
				})
		},
		allStock(context, params){
			axios.get("/counter/stock?page="+params[0]+"&search="+params[1]+"&category_id="+params[2])
				.then((response)=>{
					context.commit('stocks', [response.data.stocks.data,response.data.pagination])
				})
		},
		allBuyerSelect(context){
			axios.get('/counter/buyerList')
				.then((response)=>{
					context.commit('buyerSelects', response.data.buyerSelect)
				})
		},
		allBuyerCategorySelect(context){
			axios.get('/counter/buyercategoryList')
				.then((response)=>{
					context.commit('buyercategorySelects', response.data.buyercategorySelect)
				})
		},
		allBuyerCategorySelectAll(context){
			axios.get('/counter/buyercategoryListAll')
				.then((response)=>{
					context.commit('buyercategorySelectsAll', response.data.buyercategorySelectAll)
				})
		},
		allPackage(context, params){
			axios.get("/counter/package?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('packages', [response.data.packages.data,response.data.pagination])
				})
		},
		allPackageSelect(context){
			axios.get('/counter/packageList')
				.then((response)=>{
					context.commit('packageSelects', response.data.packageSelect)
				})
		},
		allUserSalarySelect(context){
			axios.get('/counter/userSalaryList')
				.then((response)=>{
					context.commit('userSalarySelects', response.data.userSalarySelect)
				})
		}
		,
		allMonth(context){
			axios.get('/counter/month')
				.then((response)=>{
					context.commit('months', response.data.months)
				})
		},
		allSalary(context, params){
			axios.get("/counter/salary?page="+params[0]+"&search="+params[1]+"&month_id="+params[2])
				.then((response)=>{
					context.commit('salaries', [response.data.salaries.data,response.data.pagination])
				})
		},
		allSpecialUserPackage(context, user_id){
			axios.get('/counter/spcialuserpackage' + (typeof user_id=="undefined"?"":"?user=" + user_id))
				.then((response)=>{
					context.commit('spcialuserpackages', response.data.spcialuserpackage)
				})
		},
		allUserSalary(context, params){
			axios.get("/counter/salary/"+params[0])
				.then((response)=>{
					context.commit('usersalaries', response.data)
				})
		},
		allOrderdetail(context, params){
			// console.log(params)
			axios.get("/counter/confirm?page="+params[0]+"&search="+params[1]+"&user_type="+params[2]+"&table_id="+params[3]+"&date="+params[4])
				.then((response)=>{
					// console.log(response);
					context.commit('orderdetails', [response.data.orderdetails.data,response.data.pagination])
				})
		},
		allCustomerOrderdetail(context, params){
			axios.get("/counter/checkout/confirm?page="+params[0]+"&checkin_id="+params[1])
				.then((response)=>{
					// console.log(response);
					context.commit('customerorderdetails', [response.data.customerorderdetails.data,
															response.data.pagination,
															response.data.day_of_stay,
															response.data.room_price,
															response.data.sum,
															// response.data.due,
															response.data.remaining_total,
															response.data.grand_sum,
															response.data.user_id,
															response.data.status,
															])
				})
		},
		allOrderReviewdetail(context, params){
			axios.get("/counter/review?page="+params[0]+"&search="+params[1]+"&user_type="+params[2]+"&table_id="+params[3]+"&date="+params[4])
				.then((response)=>{
					context.commit('orderreviewdetails', [response.data.orderreviewdetails.data,response.data.pagination])
				})
		},
		allConfirmOrderdetail(context, params){
			axios.get("/counter/report/sales?page="+params[0]+"&search="+params[1]+"&user_type="+params[2]+"&table_id="+params[3]+"&bill_type="+params[4]+"&date1="+params[5]+"&date2="+params[6])
				.then((response)=>{
					context.commit('confirmorderdetails', [response.data,response.data.pagination])
				})
		},
		allConfirmOrder(context, params){
			axios.get("/counter/report/items?page="+params[0]+"&category_id="+params[1]+"&item_id="+params[2]+"&date1="+params[3]+"&date2="+params[4])
				.then((response)=>{
					context.commit('confirmorders', [response.data,response.data.pagination])
				})
		},
		allUserOrderdetail(context, params){
			axios.get("/counter/report/customer?page="+params[0]+"&user_id="+params[1])
				.then((response)=>{
					context.commit('userorderdetails', [response.data,response.data.pagination])
				})
		},
		allUserPaydetail(context, params){
			axios.get("/counter/report/customer/pay?page="+params[0]+"&user_id="+params[1])
				.then((response)=>{
					context.commit('userpaydetails', [response.data,response.data.pagination])
				})
		},
		allUserOrderSummarydetail(context, params){
			axios.get("/counter/report/customer/seller?page="+params[0]+"&user_id="+params[1]+"&receive_type="+params[2]+"&bill_type="+params[3]+"&date1="+params[4]+"&date2="+params[5])
				.then((response)=>{
					context.commit('userordersummarydetails', [response.data,response.data.pagination])
				})
		},
		allUserOrderOVeralldetail(context, params){
			axios.get("/counter/report/overall?page="+params[0]+"&receive_type="+params[1]+"&bill_type="+params[2]+"&date1="+params[3]+"&date2="+params[4])
				.then((response)=>{
					context.commit('userorderoveralldetails', [response.data,response.data.pagination])
				})
		},
		allCheckIn(context, params){
			axios.get("/counter/checkin?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('checkins', [response.data.checkins.data,response.data.pagination])
				})
		},
		allCustomerSelect(context){
			axios.get('/counter/customerList')
				.then((response)=>{
					// console.log(response);
					context.commit('customerSelects', response.data.customerSelects)
				})
		},
		allRoomSelect(context, params){
			axios.get("/counter/roomList")
				.then((response)=>{
					// console.log(response);
					context.commit('roomSelects', response.data.roomSelects)
				})
		}
	},
	mutations:{
		dashboards(state, payload){
			return state.dashboard = payload
		},
		billsettings(state,data){
			return state.billsetting = data
		},
		allusertype(state, payload){
			return state.usertype = payload
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
		billes(state,data){
			return state.bill = data
		},
		barbilles(state,data){
			return state.barbill = data
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
		stocks(state, data){
			return state.stock = data
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
		customerorderdetails(state, data){
			return state.customerorderdetail = data
		},
		orderreviewdetails(state, data){
			return state.orderreviewdetail = data
		},
		confirmorderdetails(state, data){
			return state.confirmorderdetail = data
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
		checkins(state, data){
			return state.checkin = data
		},
		customerSelects(state, data){
			return state.customerSelect = data
		},
		roomSelects(state, data){
			return state.roomSelect = data
		}
	}
}