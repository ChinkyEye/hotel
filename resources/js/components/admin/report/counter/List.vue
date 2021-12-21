<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Counter Report</h1>
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
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <!-- <div class="form-group">
                    <label for="bill_id">Bill ID</label>
                    <input type="text" id="bill_id" class="form-control" @keyup="searchOrderdetail" v-model="search" placeholder="Search by bill ID">
                  </div> -->
                  <div class="form-group col-md pb-0">
                    <select class="form-control" id="counter_id" v-model="counter_id" @change="counterChange"> 
                      <option value="0">Select All Counter</option>
                      <option :value="counter.id" v-for="counter in getAllCounterSelect">{{counter.name}}</option>
                    </select>
                  </div>
                  <!-- <div class="form-group col-md pb-0">
                    <label for="user_t_id">User Type</label>
                    <select class="form-control" id="user_t_id" v-model="user_t_id" @change="user_type_change"> 
                      <option value="0">Select All User Type</option>
                      <option :value="usertype.id" v-for="usertype in getAllUsertypeSelect">{{usertype.name}}</option>
                    </select>
                  </div> -->
                  <!-- <div class="form-group col-md pb-0">
                    <label for="table_id">Table</label>
                    <select class="form-control" id="table_id" v-model="table_id" @change="tableChange"> 
                      <option value="0">Select All Table</option>
                      <option :value="table.id" v-for="table in getAllTableSelect">{{table.name}}</option>
                    </select>
                  </div> -->
                  <div class="form-group col-sm-6 pb-0">
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
                    <!-- <date-picker v-model="date" lang="en" type="date" format="YYYY-MM-dd" v-on:input="dateChange"  :max-date='new Date()'></date-picker> -->
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div id="printMe" class="row">
                  <div class="col-xs-12 col-md-12">
                    <div class="table-responsive">
                      <table class="table table-sm table-bordered table-hover">
                        <thead class="table-primary">                  
                          <tr>
                            <th>Type</th>
                            <!-- <th>SN</th> -->
                            <!--<th>Customer Type</th>-->
                            <!-- <th>Bill ID</th> -->
                            <!-- <th>Table</th> -->
                            <th>Total (Rs)</th>
                            <th>Discount (Rs)</th>
                            <th>Received (Rs)</th>
                            <th>Due (Rs)</th>
                            <!-- <th>Status</th> -->
                            <!--<th>Created</th> -->
                          </tr>
                        </thead>
                        <tbody v-for="(udetail,index) in getAllOrderdetail" :key="udetail.uid" >
                          <tr>
                            <th colspan="5" class="text-center">Counter: {{udetail.uname}}</th>
                          </tr>
                          <tr v-for="(orderdetail,idx) in udetail.fdata">
                            <!-- <td>{{idx+1}}</td> -->
                            <!-- <td>aa</td> -->
                            <!-- <td>{{orderdetail.bill_id}}({{orderdetail.count_count}})</td> -->
                            <!-- <td>{{orderdetail.table.name}}</td> -->
                            <td v-if="orderdetail.ort == '0'">Counter</td>
                            <td v-else>Received</td>
                            <td>{{orderdetail.odt}}</td>
                            <td>{{orderdetail.odd}}</td>
                            <td>{{orderdetail.odr}}</td>
                            <td v-if="orderdetail.ort == '1'">-</td>
                            <td v-else>{{parseFloat(orderdetail.odt) - (parseFloat(orderdetail.odr)+parseFloat(orderdetail.odd))}}</td>
                            <!-- <td>
                              <span v-if="orderdetail.bill_type == '1'">Paid</span> 
                              <span v-else>Due</span> 
                              <i class="nav-icon fas fa-check-circle"></i>
                            </td> -->
                            <!-- <td>
                              <span class="badge badge-warning">{{orderdetail.name}}</span>
                            </td> -->
                          </tr>
                          <tr>
                            <td colspan="1"> Total:</td>
                            <td>{{udetail.total}}</td>
                            <td>{{udetail.discount}}</td>
                            <td>{{udetail.received}}</td>
                          </tr>
                        </tbody>
                        <br>
                        <tfoot>
                          <tr>
                            <td colspan="1">Grand Total:</td>
                            <td>{{totalall}}</td>
                            <td>{{discountall}}</td>
                            <td>{{receivedall}}</td>
                            <td>{{totdue}}</td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
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
  import DatePicker from 'v-calendar/lib/components/date-picker.umd';
  import moment from 'moment'
  export default{
    name: "List",
    components: {
      DatePicker
    },
    data(){
      return{
          search:'',
          counter_id:'',
          totalall:'',
          discountall:'',
          grand_totalall:'',
          receivedall:'',
          // user_t_id:'',
          // table_id:'',
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
        var bvar = this.$store.getters.getCounterOrderdetail;
        // console.log(bvar);
        if(bvar.length == 0) return [];
        var avar = bvar[0].counterorderdetails;
        var users = avar.map(av => av.odcb).filter((v,i,s) => s.indexOf(v)===i);

        this.totalall = bvar[0].total;
        this.discountall = bvar[0].discount;
        this.grand_totalall = bvar[0].grand_total;
        this.receivedall = bvar[0].received;
        if(bvar.length==2)
          this.pagination = bvar[1];
        this.$Progress.finish()
        return users.map(function(u){
          var fdata = avar.filter(av => av.odcb==u);
          return {
            uid: u,
            uname: fdata[0].name,
            fdata: fdata,
            total: fdata.reduce(function(sum, fd){ return parseFloat(sum) + parseFloat(fd.odt);},0),
            discount: fdata.reduce(function(sum, fd){ return parseFloat(sum) + parseFloat(fd.odd);},0),
            received: fdata.reduce(function(sum, fd){ return parseFloat(sum) + parseFloat(fd.odr);},0),
          };
        });
      },
      getAllUsertypeSelect(){
          return this.$store.getters.getSellerUsertypeSelect
      },
      getAllTableSelect(){
          this.$Progress.finish()
          return this.$store.getters.getTableSelect
      },
      getAllCounterSelect(){
          return this.$store.getters.getCounterSelect
      },
      totdue(){
        return parseFloat(this.totalall) - (parseFloat(this.receivedall) + parseFloat(this.discountall));
      }
    },
    methods:{
      fetchPosts() {
      this.$store.dispatch("allCounterOrderdetail",[0,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD')]);
      this.$store.dispatch("allSellerUsertypeSelect")
      this.$store.dispatch("allTableSelect")
      this.$store.dispatch("allCounterSelect")
      },
      customerStatus(id){
        return {
            'table-danger':!id,
            'table-default': id
        }
      },
    pagechange(){
      this.$store.dispatch("allCounterOrderdetail", [this.counter_id,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD')]);
      this.$store.dispatch("allUsertypeSelect")
      this.$store.dispatch("allCounterSelect")
    },
    searchOrderdetail(){
      this.pagechange();
    },
    user_type_change(){
      this.pagechange();
    },
    dateChange(){
      this.pagechange();
    },
    tableChange(){
      this.pagechange();
    },
    counterChange(){
      this.pagechange();
    },
    print () {
      // Pass the element id here
      this.$htmlToPaper('printMe');
    }
    }
  }
</script>

<style scoped>
</style>