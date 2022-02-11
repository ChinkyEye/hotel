<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Income-Expenditure Report</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- main page load here-->
            <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print"></i> Print</button>
            <!-- <button @click.prevent="itemReportExport()" class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button> -->
            <div class="card rounded-bottom">
              <div class="card-header">
                <div class="row">
                  <div class="form-group col-sm-5 pb-0">
                    <date-picker mode='range' v-model="date" lang="en" format="YYYY-MM-dd" v-on:input="dateChange" :max-date='new Date()' is-range>
                      <template v-slot="{ inputValue, inputEvents }">
                        <div class="flex justify-center items-center">
                          <input
                            :value="inputValue.start"
                            v-on="inputEvents.start"
                            class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
                          /><i class="fas fa-arrow-right fa-fw"></i>
                          <input
                            :value="inputValue.end"
                            v-on="inputEvents.end"
                            class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
                          />
                        </div>
                      </template>
                    </date-picker>
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                  <div id="printMe">
                    <div class="row">
                     <div class="table-responsive col-sm-6">
                      <table class="table table-bordered table-hover table-sm m-0">
                        <thead class="table-primary">                  
                          <tr>
                            <th>Income</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Income</td>
                            <td>{{income}}</td>
                          </tr>
                          <tr>
                            <td>Restaurant Sales</td>
                            <td>{{restaurant_sales}}</td>
                          </tr>
                          <tr>
                            <td>Hotel Sales</td>
                            <td>{{hotel_sales}}</td>
                          </tr>
                          <tr v-if="money">
                            <td>Hotel Room Charges Income</td>
                            <td>{{ totalOrders(money) }}</td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td><span class="text-info">Grand Total:</span></td>
                            <td v-if="money">{{total1 + totalOrders(money) }}</td>
                            <td v-else>{{total1}}</td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <div class="table-responsive col-sm-6">
                      <table class="table table-bordered table-hover table-sm m-0">
                        <thead class="table-primary">                  
                          <tr>
                            <th>Expenditure</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Deposited in Bank</td>
                            <td>{{bank_balance}}</td>
                          </tr>
                          <tr>
                            <td>Purchase Expenses + other expenses</td>
                            <td>{{purchase_expense}}</td>
                          </tr>
                          <tr>
                            <td><span class="">Cash Balance:</span></td>
                            <td v-if="money">{{cash_balance + totalOrders(money)}}</td>
                            <td v-else>{{cash_balance}}</td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td><span class="text-info">Grand Total:</span></td>
                            <td v-if="money">{{grandtotal2 + totalOrders(money)}}</td>
                            <td v-else>{{grandtotal2}}</td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    </div>
                  </div>
                  <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
</template>
<script>
  import pagination from '../../../../components/PaginationComponent.vue';
  import DatePicker from 'v-calendar/lib/components/date-picker.umd';
  import moment from 'moment'
  export default{
    name: "List",
    components: {
      pagination,
      DatePicker,
    },
    data(){
      return{
        pagination: {
            'current_page': 1
          },
          defaultSelected: {
            label: "-- Please Select --",
            value: ''
          },
          category_id:'',
          item_id:'',
          total:'',
          date:{
            start: moment().subtract(1,'months')._d, // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          },
          bank_balance:'',
          purchase_expense:'',
          income:'',
          cash_balance:'',
          hotel_sales:'',
          restaurant_sales:'',
          total1:'',
          grandtotal2:'',
          money:'',

        }
    },
    mounted(){
      this.$Progress.start()
      this.fetchPosts();
      this.$Progress.finish()

    },
    computed:{
      getAllBankBalance(){
        this.$Progress.start()
        var bvar = this.$store.getters.getBankBalanceReport;
        if(bvar.length == 0) return [];
        var avar = bvar[0].bankbalancereports.data;
        this.total = bvar[2];
        if(bvar.length==2)
          this.pagination = bvar[1];
        this.$Progress.finish()
        return avar;
      },
    },
    methods:{
      fetchPosts() {
        this.pagechange();
      },
      customerStatus(id){
        return {
            'table-danger':!id,
            'table-default': id
        }
      },
      totalOrders: function (values) {
        // console.log(values.get_check_in);
         return values.reduce((acc, val) => {
          // console.log(val.get_check_in.days_stay);
          return acc + parseInt(val.get_room.price) * val.get_check_in.days_stay;
        }, 0);
      },
    pagechange(){
      // this.$store.dispatch("allBankBalanceReport", [this.pagination.current_page,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD')]);
      axios.get(`/manager/report/totalbankbalance/${moment(this.date.start).format('YYYY-MM-DD')}/${moment(this.date.end).format('YYYY-MM-DD')}`)
        .then((response)=>{
          this.money = response.data.hotel_checkout;
          this.bank_balance = response.data.totalbankbalance;
          this.purchase_expense = response.data.purchase_expense + response.data.expenditure;
          this.income = response.data.income;
          this.hotel_sales = response.data.hotel_sales;
          this.restaurant_sales = response.data.restaurant_sales;
          // this.cash_balance = (this.income + this.hotel_sales + this.restaurant_sales) - (this.bank_balance + this.purchase_expense);
          this.cash_balance = (this.income + this.hotel_sales + this.restaurant_sales) - (this.bank_balance + this.purchase_expense);
          this.total1 = this.income + this.hotel_sales + this.restaurant_sales;
          this.grandtotal2 = this.bank_balance + this.purchase_expense + (this.cash_balance);
      })
    },
    dateChange(){
      this.pagechange();
    },
    print () {
      // Pass the element id here
      this.$htmlToPaper('printMe');
    },
    itemReportExport(){
      location.href = '/manager/report/bankbalance/export?start_date='+moment(this.date.start).format('YYYY-MM-DD')+'&end_date='+moment(this.date.end).format('YYYY-MM-DD');
    }
    }
  }
</script>

<style scoped>
.vs__selected-options{
  min-width:150px;
  min-height: 30px;
}
</style>