<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Bank Balance Report</h1>
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
            <button @click.prevent="itemReportExport()" class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button>
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
                <div class="table-responsive">
                  <div id="printMe">
                    <!-- <div class="row"> -->
                      <table class="table table-sm table-bordered table-hover">
                        <thead class="table-primary">                  
                          <tr>
                            <th width="10">SN</th>
                            <th>Bank</th>
                            <th>Account</th>
                            <th>Date</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(data,index) in getAllBankBalance" :key="data.id"  :class="customerStatus(data.is_active)">
                            <td>{{index+1}}</td>
                            <td>{{data.bank_name}}</td>
                            <td>{{data.account_no}}</td>
                            <td>
                              {{data.date_np}} 
                              <span class="badge badge-warning text-danger">{{data.created_at  | formatDate}}</span>
                            </td>
                            <td>{{data.amount}}</td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="4">Total:</td>
                            <td>{{total}}</td>
                          </tr>
                        </tfoot>
                      </table>
                    <!-- </div> -->
                  </div>
                  <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination>
                </div>
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
          }
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      getAllBankBalance(){
        this.$Progress.start()
        var bvar = this.$store.getters.getBankBalanceReport;
        if(bvar.length == 0) return [];
        var avar = bvar[0].bankbalancereports.data;
        // console.log(bvar[3]);
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
    pagechange(){
      this.$store.dispatch("allBankBalanceReport", [this.pagination.current_page,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD')]);
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