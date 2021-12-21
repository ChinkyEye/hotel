<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <p class="text-danger m-0">Unit</p>
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
                  <div class="col-md-4">
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
                        <th>Created At</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(unit,index) in getAllUnit" :key="unit.id">
                        <td>{{index+1}}</td>
                        <td>{{unit.name}}</td>
                        <td>{{unit.created_at | timeformat}} <span class="badge badge-warning"><span class="text-success">{{unit.created_at  | formatDate}}</span></span></td>
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
			getAllUnit(){
        this.$Progress.start()
				var avar = this.$store.getters.getUnit;
        if(avar.length==2)
          this.pagination = avar[1];
        this.$Progress.finish()
        return avar[0];
			}
		},
		methods:{
      fetchPosts() {
        this.$store.dispatch("allUnit",[this.pagination.current_page,0]);
      },
      deleteUnit(id){
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
                axios.delete('/counter/unit/'+id)
                .then((response)=>{
                    Toast.fire({
                      icon: 'success',
                      title: 'Unit Deleted successfully'
                  })
                    that.$store.dispatch("allUnit", [0,0]);
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
                  title: 'Unit not Deleted'
              })
            }
        })
    },
    pagechange(){
      this.$store.dispatch("allUnit", [this.pagination.current_page,this.search]);
    },
    searchCategory(){
      this.pagechange();
    }
		}
	}
</script>

<style scoped>
</style>