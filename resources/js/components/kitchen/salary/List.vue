<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Salary List</h1>
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
                  <div class="col-md-2">
                    <router-link to="/salary/create" class="btn btn-primary btn-block" style="color:#fff"> Add Salary <i class="fas fa-user-plus fa-fw"></i></router-link>
                  </div>
                  <div class="col-md-5">
                    <select class="form-control" v-model="search" @change="changeStaff"> 
                      <option value="0">Select Name</option>
                      <option :value="user.id" v-for="user in getAllUserSalarySelect">{{user.user_code}} ({{user.name}})</option>
                    </select>
                  </div>
                  <div class="col-md-5">
                    <select class="form-control" id="user_type_id" v-model="month" @change="changeMonth"> 
                      <option value="0">Select Month</option>
                      <option :value="month.id" v-for="month in getAllMonth">{{month.name}}</option>
                    </select>
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover">
                    <thead class="table-primary">                  
                      <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Vat</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Issued</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(salary,index) in getAllSalary" :key="salary.id"  :class="customerStatus(salary.is_active)">
                        <td>{{index+1}}</td>
                        <td>{{salary.user.user_code}} ({{salary.user.name}})</td>
                        <td>{{salary.month.name}}</td>
                        <td>{{salary.amount}}</td>
                        <td>{{salary.vat}}</td>
                        <td>{{salary.total}}</td>
                        <td v-if="salary.type == '1'">Monthly <a href="javascript:void(0)" title="Monthly"></a></td>
                        <td v-else-if="salary.type == '0'">Advance <a href="javascript:void(0)" title="Monthly"></a></td>
                        <td v-else>Advance Ded<a href="javascript:void(0)" title="Advance Ded"></a></td>
                        <td>{{salary.created_at | timeformat}} <span class="badge badge-warning"><span class="text-success">{{salary.created_at  | formatDate}}</span></span></td>
                        <td>
                          <router-link :to="`/salary/${salary.id}/edit`"><i class="fas fa-pencil-alt" title="Click to edit"></i></router-link> 
                          | 
                          <a href="" @click.prevent="deleteSalary(salary.id)"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
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
	export default{
		name: "List",
    components: {
      pagination,
    },
    data(){
      return{
        pagination: {
            'current_page': 1
          },
          search:0,
          month:0,
        }
    },
		mounted(){
      this.fetchPosts();
		},
		computed:{
      getAllUserSalarySelect(){
        var auser = this.$store.getters.getUserSalarySelect
        this.$Progress.finish();
        return auser;
      },
			getAllSalary(){
        this.$Progress.start()
				var avar = this.$store.getters.getSalary;
        if(avar.length==2)
          this.pagination = avar[1];
        this.$Progress.finish()
        return avar[0];
			},
      getAllMonth(){
          return this.$store.getters.getMonth
      },
		},
		methods:{
      fetchPosts() {
        this.$store.dispatch("allSalary",[this.pagination.current_page,this.search,this.month]);
        this.$store.dispatch("allUserSalarySelect")
        this.$store.dispatch("allMonth")
      },
      customerStatus(id){
        return {
            'table-danger':!id,
            'table-default': id
        }
      },
      deleteSalary(id){
        var that = this;
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            buttonsStyling: true
        }).then(function (isConfirm) {
            if(isConfirm.value === true) {
                axios.delete('/kitchen/salary/'+id)
                .then((response)=>{
                    Toast.fire({
                      icon: 'success',
                      title: 'Salary Deleted successfully'
                  })
                    that.$store.dispatch("allSalary", [0,0,0]);
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
                  title: 'Salary not Deleted'
              })
            }
        })
    },
    userShow(clkid, show){
        axios.get('/kitchen/salary/status/'+clkid+'/'+show)
        .then(()=>{
            this.$store.dispatch("allSalary", [0,0,0]);
            Toast.fire({
                icon: 'success',
                title: 'Status changed successfully'
            })
        })
        .catch(()=>{
      })
    },
    pagechange(){
      this.$store.dispatch("allSalary", [this.pagination.current_page,this.search,this.month]);
    },
    changeStaff(){
      this.pagechange();
    },
    changeMonth(){
      this.pagechange();
    }
		}
	}
</script>

<style scoped>
</style>