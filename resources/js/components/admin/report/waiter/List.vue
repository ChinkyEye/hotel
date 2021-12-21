<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Waiter Report</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Waiter</li>
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
            <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print">Print</i></button>
            <!-- main page load here-->
            <div class="card card-info card-outline">
              <div class="card-header">
                <div class="row">
                  <div class="form-group col-md-3">
                    <select class="form-control" id="waiter_id" v-model="waiter_id" name="waiter_id" @change="buyerChange"> 
                      <option disabled value="">Select one</option>
                      <option :value="buyer.id" v-for="buyer in getAllBuyer">{{buyer.user_code}} ({{buyer.name}})</option>
                    </select>
                    <!-- <has-error :form="form" field="buyer_id"></has-error> -->
                  </div>
                  <div class="col-md-3">
                  <date-picker v-model="date" format="YYYY-MM-dd" v-on:input="dateChange" :max-date='new Date()'>
                    <template v-slot="{ inputValue, inputEvents }">
                      <input
                        class="form-control bg-white border px-2 py-1 rounded"
                        :value="inputValue"
                        v-on="inputEvents"
                      />
                    </template>
                  </date-picker>
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
                          <th>Bill id</th>
                          <th>Item</th>
                          <th>Unit</th>
                          <th>Qty</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(order,index) in getAllOrder" :key="order.id"  :class="customerStatus(order.is_confirmed)">
                          <td>{{index+1}}</td>
                          <td>{{order.bill_id}}</td>
                          <td>{{order.item.name}}</td>
                          <td>{{order.unit.name}}</td>
                          <td>{{order.quantity}}</td>
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
          waiter_id:'',
          item_id:'',
          total:'',
          date: new Date(), 
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      getAllOrder(){
        this.$Progress.start()
        var bvar = this.$store.getters.getWaiterReport;
        if(bvar.length == 0) return [];
        var avar = bvar[0].waiterreports.data;
        this.total = bvar[0].total;
        if(bvar.length==2)
          this.pagination = bvar[1];
        this.$Progress.finish()
        return avar;
      },
      getAllBuyer(){
          return this.$store.getters.getWaiterSelect
      }
    },
    methods:{
      fetchPosts() {
        // this.$store.dispatch("allWaiterReport",[this.pagination.current_page,0,0,this.date.start.toISOString().split('T')[0],this.date.end.toISOString().split('T')[0]]);
        this.pagechange();
         this.$store.dispatch("allWaiterSelect")
      },
      customerStatus(id){
        return {
            'table-danger':!id,
            'table-default': id
        }
      },
      buyerChange(){
        this.pagechange();
      },
    pagechange(){
      this.$store.dispatch("allWaiterReport", [this.pagination.current_page, this.waiter_id,moment(this.date).format('YYYY-MM-DD')]);
    },
    categoryChange(){
      this.pagechange();
    },
    postChange(post){
      this.$Progress.start()
      this.item_id = post?post.value:0;
      this.pagechange();
      this.$Progress.finish()
    },
    dateChange(){
      this.pagechange();
    },
    print () {
      // Pass the element id here
      this.$htmlToPaper('printMe');
    },
    itemReportExport(){
      location.href = '/home/report/items/export?category_id='+this.category_id+'&item_id='+this.item_id+'&start_date='+moment(this.date.start).format('YYYY-MM-DD')+'&end_date='+moment(this.date.end).format('YYYY-MM-DD');
    }
    }
  }
</script>

<style scoped>
</style>