<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Overall Report</h1>
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
            <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print"></i> Print</button>
            <button @click.prevent="overallReportExport()" class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button>
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="form-group col-md pb-0">
                    <select class="form-control" id="counter_id" v-model="counter_id" @change="counterChange"> 
                      <option value="0">Select All Counter</option>
                      <option :value="counter.id" v-for="counter in getAllCounterSelect">{{counter.name}}</option>
                    </select>
                  </div>
                  
                  <div class="form-group col-md pb-0">
                    <select class="form-control" id="receive_type" v-model="receive_type" name="receive_type" @change="receivetypeChange"> 
                      <option value="">Select one</option>
                      <option value="0">Order</option>
                      <option value="1">Paid</option>
                    </select>
                  </div>
                  <div class="form-group col-md pb-0" v-if="receive_type==0">
                    <select class="form-control" id="bill_type" v-model="bill_type" name="bill_type" @change="billtypeChange"> 
                      <option value="">Select one</option>
                      <option value="0">Paid</option>
                      <option value="1">Due</option>
                    </select>
                  </div>
                  <div class="form-group col-sm-4 pb-0">
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
                          <th>Customer</th>
                          <th>Type</th>
                          <th>Bill ID</th>
                          <th>Table</th>
                          <th>Total(Rs)</th>
                          <th>Discount(Rs)</th>
                          <th>Received(Rs)</th>
                          <th>Due(Rs)</th>
                          <th>Status</th>
                          <th>Issued</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(orderdetail,index) in getAllOrderOveralldetail" :key="orderdetail.id">
                          <td>{{index+1}}</td>
                          <td>{{orderdetail.customer.name}}</td>
                          <td>{{orderdetail.usertype.name}}</td>
                          <td><router-link :to="`/confirm/${orderdetail.bill_id}/preview`" target="_blank">{{orderdetail.bill_id}}</router-link></td>
                          <td v-if="orderdetail.bill_type != '2'">{{orderdetail.table.name}}</td>
                          <td v-else>-</td>
                          <td v-if="orderdetail.bill_type != '2'">{{orderdetail.total}}</td>
                          <td v-else>-</td>
                          <td v-if="orderdetail.bill_type != '2'">{{orderdetail.discount}}</td>
                          <td v-else>-</td>
                          <td>{{orderdetail.received}}</td>
                          <td v-if="orderdetail.bill_type != '2'">{{orderdetail.grand_total - orderdetail.received}}</td>
                          <td v-else>-</td>
                          <td>
                            <span v-if="orderdetail.bill_type == '0'">Paid</span> 
                            <span v-else-if="orderdetail.bill_type == '1'">Due</span> 
                            <span v-else>Receive</span> 
                            <i class="nav-icon fas fa-check-circle"></i></td>
                            <td><!-- {{orderdetail.created_at | timeformat}} --><span class="badge badge-info"><span class="text-danger">{{orderdetail.created_user.name}}</span></span>
                              <span class="badge badge-warning"><span class="text-info">{{orderdetail.created_at  | formatDate}}</span></span></td>
                            </tr>
                          </tbody>
                          <tfoot v-if="receive_type==0">
                            <tr>
                              <td colspan="5">Total:</td>
                              <td>{{total}}</td>
                              <td>{{discount}}</td>
                              <td>{{received}}</td>
                              <td>{{totdue}}</td>
                              <td>{{parseFloat(received) - parseFloat(grand_total)}}</td>
                            </tr>
                          </tfoot>
                          <tfoot v-else>
                            <tr>
                              <td colspan="7">Total:</td>
                              <td>{{received}}</td>
                            </tr>
                          </tfoot>
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
      DatePicker,
    },
    data(){
      return{
        pagination: {
            'current_page': 1
          },
          bill_type:'',
          receive_type:'',
          counter_id:'',
          total:'',
          discount:'',
          grand_total:'',
          received:'',
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
      getAllOrderOveralldetail(){
        this.$Progress.start()
        var bvar = this.$store.getters.getUserOrderOVeralldetail;
        if(bvar.length == 0) return [];
        var avar = bvar[0].userorderoveralldetails.data;
        this.total = bvar[0].total;
        this.discount = bvar[0].discount;
        this.grand_total = bvar[0].grand_total;
        this.received = bvar[0].received;
        if(bvar.length==2)
          this.pagination = bvar[1];
        this.$Progress.finish()
        return avar;
      },
      getAllCounterSelect(){
          return this.$store.getters.getCounterSelect
      },
      totdue(){
        return (parseFloat(this.total) - (parseFloat(this.received) + parseFloat(this.discount)));
      }
    },
    methods:{
      fetchPosts(){
        this.$store.dispatch("allUserOrderOVeralldetail", [this.pagination.current_page,this.receive_type,this.bill_type,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD'),this.counter_id]);
        this.$store.dispatch("allCounterSelect")
      },
      billtypeChange(){
        this.fetchPosts();
      },
      receivetypeChange(){
        this.fetchPosts();
      },
      dateChange(){
        this.fetchPosts();
      },
      counterChange(){
        this.fetchPosts();
      },
      print () {
        // Pass the element id here
        this.$htmlToPaper('printMe');
      },
      overallReportExport(){
        location.href = '/home/report/overall/export?counter_id='+this.counter_id+'&receive_type='+this.receive_type+'&bill_type='+this.bill_type+'&start_date='+moment(this.date.start).format('YYYY-MM-DD')+'&end_date='+moment(this.date.end).format('YYYY-MM-DD');
      }
    }
  }
</script>

<style scoped>
</style>