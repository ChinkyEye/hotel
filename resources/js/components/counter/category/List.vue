<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark xyz">Category List</h1>
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
                    <router-link to="/category/create" class="btn btn-primary btn-block" style="color:#fff"> Add Category <i class="fas fa-user-plus fa-fw"></i></router-link>
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
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(category,index) in getAllCategory" :key="category.id"  :class="customerStatus(category.is_active)">
                        <td>{{index+1}}</td>
                        <td>{{category.name}}</td>
                        <td>{{category.slug}}</td>
                        <td v-if="category.type_id == '1'">Buyer <a href="javascript:void(0)" title="Buyer"></a></td>
                        <td v-else>Customer <a href="javascript:void(0)" title="Customer"></a></td>
                        <td v-if="category.is_active == '0'">Inactive <a href="javascript:void(0)" @click.prevent="userShow(category.id, category.is_active)" title="Make Active"><i class="nav-icon fas fa-times-circle"></i></a></td>
                        <td v-else>Active <a href="javascript:void(0)" @click.prevent="userShow(category.id, category.is_active)" title="Make InActive"><i class="nav-icon fas fa-check-circle"></i></a></td>
                        <td>{{category.created_at | timeformat}} <span class="badge badge-warning"><span class="text-success">{{category.created_at  | formatDate}}</span></span></td>
                        <td>
                          <router-link :to="`/category/${category.id}/edit`"><i class="fas fa-pencil-alt" title="Click to edit"></i></router-link> 
                          | 
                          <a href="" @click.prevent="deleteCategory(category.id)"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
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
			getAllCategory(){
        this.$Progress.start()
				var avar = this.$store.getters.getCategory;
        if(avar.length==2)
          this.pagination = avar[1];
        this.$Progress.finish()
        return avar[0];
			}
		},
		methods:{
      fetchPosts() {
        this.$store.dispatch("allCategory",[this.pagination.current_page,0]);
      },
      customerStatus(id){
        return {
            'table-danger':!id,
            'table-default': id
        }
      },
      deleteCategory(id){
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
                axios.delete('/counter/category/'+id)
                .then((response)=>{
                    Toast.fire({
                      icon: 'success',
                      title: 'Category Deleted successfully'
                  })
                    that.$store.dispatch("allCategory", [0,0]);
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
                  title: 'Category not Deleted'
              })
            }
        })
    },
    userShow(clkid, show){
        axios.get('/counter/category/status/'+clkid+'/'+show)
        .then(()=>{
            this.$store.dispatch("allCategory", [0,0]);
            Toast.fire({
                icon: 'success',
                title: 'Status changed successfully'
            })
        })
        .catch(()=>{
      })
    },
    pagechange(){
      this.$store.dispatch("allCategory", [0,this.search]);
    },
    searchCategory(){
      this.pagechange();
    }
		}
	}
</script>

<style scoped>
</style>