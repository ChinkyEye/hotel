<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <p class="text-danger m-0">Buyer Category List</p>
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
                    <router-link to="/category/buying/create" class="btn btn-flat btn-danger btn-block" style="color:#fff"> Add Category <i class="fas fa-plus fa-fw"></i></router-link>
                  </div>
                  <div class="col-md-10">
                    <input type="text" class="form-control" @keyup="searchCategory" v-model="search" placeholder="Search by name">
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover">
                    <thead class="thead-dark">                  
                      <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Issued</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(category,index) in getAllCategory" :key="category.id"  :class="customerStatus(category.is_active)">
                        <td>{{index+1}}</td>
                        <td>{{category.name}}</td>
                        <td v-if="category.is_active == '0'">Inactive <a href="javascript:void(0)" @click.prevent="userShow(category.id, category.is_active)" title="Make Active"><i class="nav-icon fas fa-times-circle"></i></a></td>
                        <td v-else>Active <a href="javascript:void(0)" @click.prevent="userShow(category.id, category.is_active)" title="Make InActive"><i class="nav-icon fas fa-check-circle"></i></a></td>
                        <td>{{category.created_at | timeformat}} <span class="badge badge-warning"><span class="text-success">{{category.created_at  | formatDate}}</span></span></td>
                        <td>
                          <div class="btn-group">
                            <router-link :to="`/category/buying/${category.id}/edit`" class="btn btn-sm btn-flat btn-outline-primary"><i class="fas fa-pencil-alt" title="Click to edit"></i></router-link> 
                            <a href="" @click.prevent="deleteCategory(category.id)" class="btn btn-sm btn-flat btn-outline-danger"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
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
			getAllCategory(){
        this.$Progress.start()
				var avar = this.$store.getters.getBuyingCategory;
        if(avar.length==2)
          this.pagination = avar[1];
        this.$Progress.finish()
        return avar[0];
			}
		},
		methods:{
      fetchPosts() {
        this.$store.dispatch("allBuyingCategory",[this.pagination.current_page,0]);
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
                axios.delete('/home/category/buying/'+id)
                .then((response)=>{
                    Toast.fire({
                      icon: 'success',
                      title: 'Category Deleted successfully'
                  })
                    that.$store.dispatch("allBuyingCategory", [0,0]);
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
        axios.get('/home/category/buying/status/'+clkid+'/'+show)
        .then(()=>{
            this.$store.dispatch("allBuyingCategory", [0,0]);
            Toast.fire({
                icon: 'success',
                title: 'Status changed successfully'
            })
        })
        .catch(()=>{
      })
    },
    pagechange(){
      this.$store.dispatch("allBuyingCategory", [this.pagination.current_page,this.search]);
    },
    searchCategory(){
      this.pagechange();
    }
		}
	}
</script>

<style scoped>
</style>