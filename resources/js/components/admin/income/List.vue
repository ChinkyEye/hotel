<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
           <p class="text-danger m-0">Income</p>
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
                    <router-link to="/income/create" class="btn btn-flat btn-danger btn-block" style="color:#fff"> Add Income <i class="fas fa-plus fa-fw"></i></i></router-link>
                  </div>
                  <div class="col-md-10">
                    <input type="text" class="form-control" @keyup="searchCategory" v-model="search" placeholder="Search by name">
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover">
                    <thead class="table-primary">                  
                      <tr>
                        <th>SN</th>
                        <th>Topic</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Created At</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(income,index) in getAllIncome" :key="income.id">
                        <td>{{index+1}}</td>
                        <td>{{income.get_topic.name}}</td>
                        <td>{{income.description}}</td>
                        <td>{{income.amount}}</td>
                        <td>{{income.iedate}}</td>
                        <td>{{income.created_at | timeformat}} <span class="badge badge-warning"><span class="text-primary">{{income.created_at  | formatDate}}</span></span></td>
                        <td>
                          <div class="btn-group">
                          <router-link :to="`/income/${income.id}/edit`" class="btn btn-sm btn-flat btn-outline-primary"><i class="fas fa-pencil-alt" title="Click to edit"></i></router-link> 
                          <a href="" @click.prevent="deleteIncome(income.id)" class="btn btn-sm btn-flat btn-outline-danger"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
                          </div>
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
          search:''
        }
    },
		mounted(){
      this.fetchPosts();
		},
		computed:{
			getAllIncome(){
        this.$Progress.start()
				var avar = this.$store.getters.getIncome;
        if(avar.length==2)
          this.pagination = avar[1];
        this.$Progress.finish()
        return avar[0];
			}
		},
		methods:{
      fetchPosts() {
        this.$store.dispatch("allIncome",[this.pagination.current_page,0]);
      },
      deleteIncome(id){
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
                axios.delete('/home/income/'+id)
                .then((response)=>{
                    Toast.fire({
                      icon: 'success',
                      title: 'Income Deleted successfully'
                  })
                    that.$store.dispatch("allIncome", [0,0]);
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
                  title: 'Income not Deleted'
              })
            }
        })
    },
    pagechange(){
      this.$store.dispatch("allIncome", [this.pagination.current_page,this.search]);
    },
    searchCategory(){
      this.pagechange();
    }
		}
	}
</script>

<style scoped>
</style>