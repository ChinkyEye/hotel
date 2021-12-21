<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Order List</h1>
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
            <!-- <router-link class="btn btn-primary rounded-0" to="/order" style="color:#fff"> Add Order <i class="fas fa-plus fa-fw"></i></i></router-link> -->
            <!-- <router-link  class="btn btn-primary rounded-0"  to="/visitor-order" style="color:#fff"> Add Visitor Order <i class="fas fa-plus fa-fw"></i></i></router-link> -->
            <div class="card rounded-0">
              <div class="card-header rounded-0">
                <div class="row">
                  <div class="form-group mb-0 col-md-3">
                    <label for="bill_id">Bill ID</label>
                    <input type="text" id="bill_id" class="form-control" @keyup="searchOrderdetail" v-model="search" placeholder="Search by bill ID">
                  </div>
                  <div class="form-group mb-0 col-md-3">
                    <label for="user_t_id">Customer Type</label>
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
                    <label for="date">Date</label>
                    <date-picker v-model="date" v-on:input="dateChange">
                      <template v-slot="{ inputValue, inputEvents }">
                        <input
                          class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300 form-control"
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
                    <thead class="table-primary text-center">                  
                      <tr>
                        <th>SN</th>
                        <th class="text-left">Customer Info</th>
                        <th>Type</th>
                        <th>Bill ID</th>
                        <th>Table</th>
                        <th>Status</th>
                        <th>Active</th>
                        <th>Issued</th>
                        <th>Issued By</th>
                        <th>Action</th>
                        <th>Print</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr v-for="(orderdetail,index) in getAllOrderdetail" :key="orderdetail.id"  :class="customerStatus(orderdetail.is_active)">
                        <td>{{index+1}}</td>
                        <td class="text-left">{{orderdetail.customer.name}}, {{orderdetail.customer.phone}}, {{orderdetail.customer.user_code}}</td>
                        <td>{{orderdetail.usertype.name}}</td>
                        <td>{{orderdetail.bill_id}}({{orderdetail.count_count}})</td>
                        <td>{{orderdetail.table.name}}</td>
                        <td v-if="orderdetail.is_confirmed == '0'"><i class="nav-icon fas fa-times-circle"></i>Not Confirmed</td>
                        <td v-else><i class="nav-icon fas fa-check"></i>Confirmed</td>
                        <td v-if="orderdetail.is_active == '0'"><i class="nav-icon fas fa-times-circle"></i>Removed </td>
                        <td v-else>
                          <a title="Active"><i class="nav-icon fas fa-check"></i></a> Active
                        </td>
                        <td><span class="badge badge-warning"><span class="text-info">{{orderdetail.created_at  | formatDate}}</span></span></td>
                        <td>{{orderdetail.created_user.name}}</td>
                        <td v-if="orderdetail.is_confirmed == '1'">
                          <router-link :to="`/confirm/${orderdetail.bill_id}/preview`"><i class="fas fa-eye" title="Click to show"></i></router-link>
                        </td>
                        <td v-else>
                          <router-link :to="`/confirm/${orderdetail.bill_id}/show`"><i class="fas fa-eye" title="Click to show"></i></router-link>
                        </td>
                        <td>
                          <router-link :to="`/order/${orderdetail.bill_id}/preview`">
                            <i class="far fa-folder-open" title="Click to view all KOT"></i>
                          </router-link> 
                          | 
                          <router-link :to="`/review/${orderdetail.bill_id}/preview`">
                            <i class="far fa-file-alt" title="Click to view review KOT"></i>
                          </router-link> 
                          | 
                          <router-link :to="`/befreview/${orderdetail.bill_id}/preview`">
                            <i class="fas fa-eye" title="Click to view review KOT"></i>
                          </router-link>
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
        this.$store.dispatch("allOrderdetail",[this.pagination.current_page,0,0,0,this.date.toISOString().split('T')[0]]);
        this.$store.dispatch("allSellerUsertypeSelect")
        this.$store.dispatch("allTableSelect")
      },
      customerStatus(id){
        return {
            'table-danger':!id,
            'table-default': id
        }
      },
      userShow(clkid){
        var that = this;
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'No, cancel!',
            buttonsStyling: true
        }).then(function (isConfirm) {
            if(isConfirm.value === true) {
                axios.get('/manager/confirm/status/'+clkid)
                .then((response)=>{
                    Toast.fire({
                      icon: 'success',
                      title: 'Orderdetail Deleted successfully'
                  })
                    that.$store.dispatch("allOrderdetail", [0,0]);
                })
                .catch((response)=>{
                    Toast.fire({
                      icon: 'error',
                      title: 'Something went wrong'
                  })
                })
            }
            else{
                Toast.fire({
                  icon: 'error',
                  title: 'Orderdetail not Deleted'
              })
            }
        })
    },
    // userShow(clkid, show){
    //     axios.get('/manager/confirm/status/'+clkid+'/'+show)
    //     .then(()=>{
    //         this.$store.dispatch("allOrderdetail", [0,0]);
    //         Toast.fire({
    //             icon: 'success',
    //             title: 'Status changed successfully'
    //         })
    //     })
    //     .catch(()=>{
    //   })
    // },
    pagechange(){
      this.$store.dispatch("allOrderdetail", [this.pagination.current_page,this.search, this.user_t_id, this.table_id,moment(this.date).format('YYYY-MM-D')]);
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