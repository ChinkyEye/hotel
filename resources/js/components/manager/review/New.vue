<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Review List</h1>
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
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="form-group mb-0 col-md-3">
                    <label for="bill_id">Bill ID</label>
                    <input type="text" id="bill_id" class="form-control" @keyup="searchOrderdetail" v-model="search" placeholder="Search by bill ID">
                  </div>
                  <div class="form-group mb-0 col-md-3">
                    <label for="user_t_id">User Type</label>
                    <select class="form-control" id="user_t_id" v-model="user_t_id" @change="userChange"> 
                      <option value="0">Select All User Type</option>
                      <option :value="usertype.id" v-for="usertype in getAllUsertypeSelect">{{usertype.name}}</option>
                    </select>
                  </div>
                  <div class="form-group mb-0 col-md-3">
                    <label for="table_id">Table</label>
                    <select class="form-control" id="table_id" v-model="table_id" @change="tableChange"> 
                      <option value="0">Select All Table</option>
                      <option :value="table.id" v-for="table in getAllTableSelect">{{table.name}}</option>
                    </select>
                  </div>
                  <div class="form-group mb-0 col-md-3">
                    <label for="date col-md-3">Date</label>
                    <date-picker v-model="date" v-on:input="dateChange">
                      <template v-slot="{ inputValue, inputEvents }">
                        <input
                          class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300"
                          :value="inputValue"
                          v-on="inputEvents"
                        />
                      </template>
                    </date-picker>
                    <!-- <date-picker v-model="date" lang="en" id="date" type="date" format="YYYY-MM-dd" v-on:input="dateChange" :max-date='new Date()'></date-picker> -->
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover">
                    <thead class="table-primary">                  
                      <tr>
                        <th>SN</th>
                        <th>Customer Info</th>
                        <th>Customer Type</th>
                        <th>Bill ID</th>
                        <th>Table</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(orderdetail,index) in getAllOrderdetail" :key="orderdetail.id"  :class="customerStatus(orderdetail.is_active)">
                        <td>{{index+1}}</td>
                        <td>{{orderdetail.customer.name}}, {{orderdetail.customer.phone}}, {{orderdetail.customer.user_code}}</td>
                        <td>{{orderdetail.usertype.name}}</td>
                        <td>{{orderdetail.bill_id}}({{orderdetail.count_count}})</td>
                        <td>{{orderdetail.table.name}}</td>
                        <td v-if="orderdetail.is_confirmed == '0'">Not Confirmed </td>
                        <td v-else>Active </td>
                        <td><span class="badge badge-warning"><span class="text-info">{{orderdetail.created_at  | formatDate}}</span></span></td>
                        <td>
                          <router-link :to="`/review/${orderdetail.id}/show`"><i class="fas fa-eye" title="Click to show"></i></router-link> 
                        </td>
                      </tr>
                    </tbody>
                  </table>
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
  import pagination from '../../../components/PaginationComponent.vue';
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
        user_t_id:0,
        table_id:0,
        date: new Date(),
    }
},
mounted(){
  this.fetchPosts();
},
computed:{
    getAllOrderdetail(){
        this.$Progress.start()
        var avar = this.$store.getters.getOrderReviewdetail;
        if(avar.length==2)
          this.pagination = avar[1];
      this.$Progress.finish()
      return avar[0];
    },
    getAllUsertypeSelect(){
      return this.$store.getters.getSellerUsertypeSelect
    },
    getAllTableSelect(){
      this.$Progress.finish()
      return this.$store.getters.getTableSelect
    }
},
methods:{
  fetchPosts() {
    this.$store.dispatch("allOrderReviewdetail",[this.pagination.current_page,0,0,0,moment(this.date).format('YYYY-MM-DD')]);
    this.$store.dispatch("allSellerUsertypeSelect")
    this.$store.dispatch("allTableSelect")
},
customerStatus(id){
    return {
        'table-danger':!id,
        'table-default': id
    }
},
pagechange(){
  this.$store.dispatch("allOrderReviewdetail", [this.pagination.current_page,this.search, this.user_t_id, this.table_id,moment(this.date).format('YYYY-MM-DD')]);
},
searchOrderdetail(){
  this.pagechange();
},
userChange(){
  this.pagechange();
},
dateChange(){
  this.pagechange();
},
tableChange(){
  this.pagechange();
},
}
}
</script>

<style scoped>
</style>