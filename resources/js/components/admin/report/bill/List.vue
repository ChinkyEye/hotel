<template>
<div>
    <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Bills Report</h1>
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
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-12 connectedSortable">
        <!-- main page load here-->
        <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print">Print</i></button>
        <button @click.prevent="salesReportExport()" class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button>
  <div class="card">
  <div class="card-header">
    <div class="row">
      <div class="form-group col-md">
        <input type="text" id="bill_id" class="form-control" @keyup="searchOrderdetail" v-model="search" placeholder="Search by bill ID">
      </div>
      <div class="form-group col-sm-5">
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
        <!-- <date-picker v-model="date" v-on:input="dateChange">
          <template v-slot="{ inputValue, inputEvents }">
            <input
              class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300 form-control"
              :value="inputValue"
              v-on="inputEvents"
            />
          </template>
        </date-picker> -->
        <!-- <date-picker mode='range' v-model="date" lang="en" type="date" format="YYYY-MM-dd" v-on:input="dateChange" :max-date='new Date()'></date-picker> -->
      </div>
  </div>
  </div><!-- /.card-header -->
  <div class="card-body">
    <div id="printMe">
    <div class="table-responsive">
    <table class="table table-sm table-bordered table-hover">
      <thead class="table-primary">                  
        <tr>
          <th>SN</th>
          <th>Bill ID</th>
          <th>Bill Sn</th>
          <th>IS Print</th>
          <th>Printed</th>
          <th>Created By</th>
          <th>Created At</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(orderdetail,index) in getAllOrderdetail" :key="orderdetail.id">
          <td>{{index+1}}</td>
          <td><router-link :to="`/confirm/${orderdetail.bill_id}/preview`" target="_blank">{{orderdetail.bill_id}}</router-link></td>
          <td>{{orderdetail.bill_sn}}</td>
          <td v-if="orderdetail.is_print == '0'">-</td>
          <td v-else>Yes</td>
          <td v-if="orderdetail.print_count == '0'">-</td>
          <td v-else>{{orderdetail.print_count}} times</td>
          <td>{{orderdetail.created_user.name}}</td>
          <td>{{orderdetail.created_at | timeformat}} / {{orderdetail.created_at_np}}<span class="badge badge-warning"><span class="text-info">{{orderdetail.created_at  | formatDate}}</span></span></td>
        </tr>
      </tbody>
    </table>
    <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination>
  </div>
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
      DatePicker
    },
    data(){
      return{
        pagination: {
            'current_page': 1
          },
          search:'',
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
      getAllOrderdetail(){
        this.$Progress.start()
        var bvar = this.$store.getters.getBillOrderdetail;
        if(bvar.length == 0) return [];
        var avar = bvar[0].confirmbilldetails.data;
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
      pagechange(){
        this.$store.dispatch("allBillOrderdetail", [this.pagination.current_page,this.search,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD')]);
      },
      searchOrderdetail(){
        this.pagechange();
      },
      dateChange(){
        this.pagechange();
      },
      print () {
        // Pass the element id here
        this.$htmlToPaper('printMe');
      },
      salesReportExport(){
        location.href = '/home/report/bill/export?bill_id='+this.search+'&start_date='+moment(this.date.start).format('YYYY-MM-DD')+'&end_date='+moment(this.date.end).format('YYYY-MM-DD');
      }
    }
  }
</script>

<style scoped>
</style>