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
		orderbill:[],
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
		// confirmorderdetail:[],
		// confirmorder:[],
		// userorderdetail:[],
		// userpaydetail:[],
		// userordersummarydetail:[],
		// userorderoveralldetail:[],
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
		getOrderBill(state){
			return state.orderbill
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
		getOrderReviewdetail(state){
			return state.orderreviewdetail
		},
		// getConfirmOrderdetail(state){
		// 	return state.confirmorderdetail
		// },
		// getConfirmOrder(state){
		// 	return state.confirmorder
		// },
		// getUserOrderdetail(state){
		// 	return state.userorderdetail
		// },
		// getUserPaydetail(state){
		// 	return state.userpaydetail
		// },
		// getUserOrderSummarydetail(state){
		// 	return state.userordersummarydetail
		// },
		// getUserOrderOVeralldetail(state){
		// 	return state.userorderoveralldetail
		// }
	},
	actions:{
		allDashboard(context){
			axios.get("/bar/dashboard")
				.then((response)=>{
					context.commit('dashboards', [response.data])
				})
		},
		allBillSetting(context){
			axios.get("/bar/billsetting")
				.then((response)=>{
					context.commit('billsettings', response.data.settings)
				})
		},
		getAllUserType(context, params){
			axios.post('/bar/user-type/search',{
				search: params[0],
				page: params[1]
			})
			.then((response)=>{
				context.commit('allusertype', response.data)
			})
		},
		allUser(context, params){
			axios.get('/bar/customer?page='+params[0]+'&search='+params[1]+"&type="+params[2])
				.then((response)=>{
					context.commit('useres', [response.data,response.data.pagination])
				})
		},
		allUsertypeSelect(context){
			axios.get('/bar/usertypeList')
				.then((response)=>{
					context.commit('usertypeSelects', response.data.usertypeSelect)
				})
		},
		allSellerUsertypeSelect(context){
			axios.get('/bar/sellerusertypeList')
				.then((response)=>{
					context.commit('sellerusertypeSelects', response.data.sellerusertypeSelect)
				})
		},
		allBuyingCategory(context, params){
			axios.get("/bar/category/buying?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('buyingcategories', [response.data.buyingcategories.data,response.data.pagination])
				})
		},
		allSellingCategory(context, params){
			axios.get("/bar/category/selling?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('sellingcategories', [response.data.sellingcategories.data,response.data.pagination])
				})
		},
		allTestCategory(context, params){
			axios.get("/bar/testcategory")
				.then((response)=>{
					context.commit('testcategories', [response.data.categories.data,response.data.pagination])
				})
		},
		allUnit(context, params){
			axios.get("/bar/unit?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('units', [response.data.units.data,response.data.pagination])
				})
		},
		allTable(context, params){
			axios.get("/bar/table?page="+params[0])
				.then((response)=>{
					context.commit('tables', [response.data.tables.data,response.data.pagination])
				})
		},
		allItem(context, params){
			axios.get("/bar/item?page="+params[0]+"&search="+params[1]+"&category_id="+params[2])
				.then((response)=>{
					context.commit('items', [response.data.items.data,response.data.pagination])
				})
		},
		allCategorySelect(context){
			axios.get('/bar/categoryList')
				.then((response)=>{
					context.commit('categorySelects', response.data.categorySelect)
				})
		},
		allUnitSelect(context){
			axios.get('/bar/unitList')
				.then((response)=>{
					context.commit('unitSelects', response.data.unitSelect)
				})
		},
		allUserSelect(context, type_id){
			axios.get('/bar/userList' + (typeof type_id=="undefined"?"":"?type=" + type_id))
				.then((response)=>{
					context.commit('userSelects', response.data.userSelect)
				})
		},
		allItemSelect(context){
			axios.get('/bar/itemList')
				.then((response)=>{
					context.commit('itemSelects', response.data.itemSelect)
				})
		},
		allItemSelectReady(context){
			axios.get('/bar/itemListReady') //web.php ln 155 ma update gareko
				.then((response)=>{
					context.commit('itemSelectsReady', response.data.itemSelectReady)
				})
		},
		allTableSelect(context){
			axios.get('/bar/tableList')
				.then((response)=>{
					context.commit('tableSelects', response.data.tableSelect)
				})
		},
		// allConfirmBill(context, id){
		// 	axios.get('/bar/confirm/'+id+'/preview')
		// 		.then((response)=>{
		// 			context.commit('confirmbilles', response.data.bills)
		// 		})
		// },
		allOrderBill(context, id){
			axios.get('/bar/confirm/'+id+'/show')
				.then((response)=>{
					context.commit('orderbilles', response.data.bills)
				})
		},
		allStock(context, params){
			axios.get("/bar/stock?page="+params[0]+"&search="+params[1]+"&category_id="+params[2])
				.then((response)=>{
					context.commit('stocks', [response.data.stocks.data,response.data.pagination])
				})
		},
		allBuyerSelect(context){
			axios.get('/bar/buyerList')
				.then((response)=>{
					context.commit('buyerSelects', response.data.buyerSelect)
				})
		},
		allBuyerCategorySelect(context){
			axios.get('/bar/buyercategoryList')
				.then((response)=>{
					context.commit('buyercategorySelects', response.data.buyercategorySelect)
				})
		},
		allBuyerCategorySelectAll(context){
			axios.get('/bar/buyercategoryListAll')
				.then((response)=>{
					context.commit('buyercategorySelectsAll', response.data.buyercategorySelectAll)
				})
		},
		allPackage(context, params){
			axios.get("/bar/package?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('packages', [response.data.packages.data,response.data.pagination])
				})
		},
		allPackageSelect(context){
			axios.get('/bar/packageList')
				.then((response)=>{
					context.commit('packageSelects', response.data.packageSelect)
				})
		},
		allUserSalarySelect(context){
			axios.get('/bar/userSalaryList')
				.then((response)=>{
					context.commit('userSalarySelects', response.data.userSalarySelect)
				})
		}
		,
		allMonth(context){
			axios.get('/bar/month')
				.then((response)=>{
					context.commit('months', response.data.months)
				})
		},
		allSalary(context, params){
			axios.get("/bar/salary?page="+params[0]+"&search="+params[1]+"&month_id="+params[2])
				.then((response)=>{
					context.commit('salaries', [response.data.salaries.data,response.data.pagination])
				})
		},
		allSpecialUserPackage(context, user_id){
			axios.get('/bar/spcialuserpackage' + (typeof user_id=="undefined"?"":"?user=" + user_id))
				.then((response)=>{
					context.commit('spcialuserpackages', response.data.spcialuserpackage)
				})
		},
		allUserSalary(context, params){
			axios.get("/bar/salary/"+params[0])
				.then((response)=>{
					context.commit('usersalaries', response.data)
				})
		},
		allOrderdetail(context, params){
			axios.get("/bar/confirm?page="+params[0]+"&search="+params[1]+"&user_type="+params[2]+"&table_id="+params[3]+"&date="+params[4])
				.then((response)=>{
					context.commit('orderdetails', [response.data.orderdetails.data,response.data.pagination])
				})
		},
		allOrderReviewdetail(context, params){
			axios.get("/bar/review?page="+params[0]+"&search="+params[1]+"&user_type="+params[2]+"&table_id="+params[3]+"&date="+params[4])
				.then((response)=>{
					context.commit('orderreviewdetails', [response.data.orderreviewdetails.data,response.data.pagination])
				})
		},
		// allConfirmOrderdetail(context, params){
		// 	axios.get("/bar/report/sales?page="+params[0]+"&search="+params[1]+"&user_type="+params[2]+"&table_id="+params[3]+"&bill_type="+params[4]+"&date1="+params[5]+"&date2="+params[6])
		// 		.then((response)=>{
		// 			context.commit('confirmorderdetails', [response.data,response.data.pagination])
		// 		})
		// },
		// allConfirmOrder(context, params){
		// 	axios.get("/bar/report/items?page="+params[0]+"&category_id="+params[1]+"&item_id="+params[2]+"&date1="+params[3]+"&date2="+params[4])
		// 		.then((response)=>{
		// 			context.commit('confirmorders', [response.data,response.data.pagination])
		// 		})
		// },
		// allUserOrderdetail(context, params){
		// 	axios.get("/bar/report/customer?page="+params[0]+"&user_id="+params[1])
		// 		.then((response)=>{
		// 			context.commit('userorderdetails', [response.data,response.data.pagination])
		// 		})
		// },
		// allUserPaydetail(context, params){
		// 	axios.get("/bar/report/customer/pay?page="+params[0]+"&user_id="+params[1])
		// 		.then((response)=>{
		// 			context.commit('userpaydetails', [response.data,response.data.pagination])
		// 		})
		// },
		// allUserOrderSummarydetail(context, params){
		// 	axios.get("/bar/report/customer/seller?page="+params[0]+"&user_id="+params[1]+"&receive_type="+params[2]+"&bill_type="+params[3]+"&date1="+params[4]+"&date2="+params[5])
		// 		.then((response)=>{
		// 			context.commit('userordersummarydetails', [response.data,response.data.pagination])
		// 		})
		// },
		// allUserOrderOVeralldetail(context, params){
		// 	axios.get("/bar/report/overall?page="+params[0]+"&receive_type="+params[1]+"&bill_type="+params[2]+"&date1="+params[3]+"&date2="+params[4])
		// 		.then((response)=>{
		// 			context.commit('userorderoveralldetails', [response.data,response.data.pagination])
		// 		})
		// }
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
		orderbilles(state,data){
			return state.orderbill = data
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
		orderreviewdetails(state, data){
			return state.orderreviewdetail = data
		},
		// confirmorderdetails(state, data){
		// 	return state.confirmorderdetail = data
		// },
		// confirmorders(state, data){
		// 	return state.confirmorder = data
		// },
		// userorderdetails(state, data){
		// 	return state.userorderdetail = data
		// },
		// userpaydetails(state, data){
		// 	return state.userpaydetail = data
		// },
		// userordersummarydetails(state, data){
		// 	return state.userordersummarydetail = data
		// },
		// userorderoveralldetails(state, data){
		// 	return state.userorderoveralldetail = data
		// }
	}
}