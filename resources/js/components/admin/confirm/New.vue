<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <p class="text-danger m-0">Order List</p>
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
                  <div class="form-group col-md pb-0">
                    <date-picker v-model="date" v-on:input="dateChange">
                      <template v-slot="{ inputValue, inputEvents }">
                        <input
                          class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300 form-control"
                          :value="inputValue"
                          v-on="inputEvents"
                        />
                      </template>
                    </date-picker>
                  </div>
                  <div class="form-group col-md pb-0">
                    <input type="text" class="form-control" @keyup="searchOrderdetail" v-model="search" placeholder="Search by bill ID">
                  </div>
                  <div class="form-group col-md pb-0">
                    <select class="form-control" id="user_t_id" v-model="user_t_id" @change="userChange"> 
                      <option value="0">Select All User Type</option>
                      <option :value="usertype.id" v-for="usertype in getAllUsertypeSelect">{{usertype.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-md pb-0">
                    <select class="form-control" id="table_id" v-model="table_id" @change="tableChange"> 
                      <option value="0">Select All Table</option>
                      <option :value="table.id" v-for="table in getAllTableSelect">{{table.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-md pb-0">
                    <select class="form-control" id="status_id" v-model="status_id" @change="statusChange"> 
                      <option value="">All</option>
                      <option value="1">Confirmed</option>
                      <option value="0">Not Confirmed</option>
                    </select>
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover">
                    <thead class="thead-dark">                  
                      <tr>
                        <th>SN</th>
                        <th>Customer Info</th>
                        <th>Type</th>
                        <th>Bill ID</th>
                        <th>Table</th>
                        <th>Status</th>
                        <th>Active</th>
                        <th>Issued</th>
                        <th>Issued By</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr v-for="(orderdetail,index) in getAllOrderdetail" :key="orderdetail.id"  :class="customerStatus(orderdetail.is_active)">
                        <td>{{index+1}}</td>
                        <td class="text-left">{{orderdetail.customer.name}}, {{orderdetail.customer.phone}}, {{orderdetail.customer.user_code}}</td>
                        <td>{{orderdetail.usertype.name}}</td>
                        <td>{{orderdetail.bill_id}}({{orderdetail.count_count}})</td>
                        <td>{{orderdetail.table.name}}</td>
                        <td v-if="orderdetail.is_confirmed == '0'">Not Confirmed <i class="nav-icon fas fa-times-circle"></i></td>
                        <td v-else>Confirm <i class="nav-icon fas fa-check-circle"></i></td>
                        <td v-if="orderdetail.is_active == '0'">Removed <i class="nav-icon fas fa-times-circle"></i></td>
                        <td v-else>Active <i class="nav-icon fas fa-check-circle"></i></td>
                        <td><span class="badge badge-warning"><span class="text-info">{{orderdetail.created_at  | formatDate}}</span></span></td>
                        <td>{{orderdetail.created_user.name}}</td>
                        <td v-if="orderdetail.is_confirmed == '1'">
                          <router-link :to="`/confirm/${orderdetail.bill_id}/preview`" class="btn btn-sm btn-flat btn-outline-primary"><i class="fas fa-eye" title="Click to show"></i></router-link>
                        </td>
                        <td v-else>
                          <router-link :to="`/confirm/${orderdetail.bill_id}/show`" class="btn btn-sm btn-flat btn-outline-primary"><i class="fas fa-eye" title="Click to show"></i></router-link>
                         <!--  | 
                          <a href="" @click.prevent="deleteOrderdetail(orderdetail.id)"><i class="fas fa-trash-alt" title="Click to delete"></i></a> -->
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
          date: new Date(),
          user_t_id:0,
          table_id:0,
          status_id:'',
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      getAllOrderdetail(){
        this.$Progress.start()
        var avar = this.$store.getters.getOrderdetail;
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
        this.$store.dispatch("allOrderdetail",[this.pagination.current_page,0,moment(this.date).format('YYYY-MM-DD'),0,0,'']);
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
      this.$store.dispatch("allOrderdetail", [this.pagination.current_page,this.search,moment(this.date).format('YYYY-MM-DD'),this.user_t_id, this.table_id, this.status_id]);
    },
    searchOrderdetail(){
      this.pagechange();
    },
    dateChange(){
      this.pagechange();
    },
    userChange(){
      this.pagechange();
    },
    tableChange(){
      this.pagechange();
    },
    statusChange(){
      this.pagechange();
    }
    }
  }
</script>

<style scoped>
</style>