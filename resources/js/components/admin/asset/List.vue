<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <p class="text-danger m-0">Asset List</p>
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
                  <div class="form-group col-md">
                    <input type="text" class="form-control" @keyup="searchAsset" v-model="search" placeholder="Search by name">
                  </div>
                  <div class="form-group col-md">
                    <select class="form-control" v-model="category_idSearch"  @change="categoryChange">  
                      <option value="0">Please select All Category</option> 
                      <option :value="category.id" v-for="category in getAllCategoryAll">{{category.name}}</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover">
                    <thead class="thead-dark">                  
                      <tr>
                        <th>SN</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>VAT</th>
                        <th>Rate</th>
                        <th>Total</th>
                        <th>Unit</th>
                        <th>From</th>
                        <th>Issued</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(asset,index) in getAllAsset" :key="asset.id">
                        <td>{{index+1}}</td>
                        <td>{{asset.category.name}}</td>
                        <td>{{asset.name}}</td>
                        <td>Rs: {{asset.price}}</td>
                        <td>{{asset.quantity}}</td>
                        <td>{{asset.vat}}</td>
                        <td>{{asset.rate}}</td>
                        <td>{{asset.total}}</td>
                        <td>{{asset.unit.name}}</td>
                        <td>{{asset.bought.name}} <span class="badge badge-info">{{asset.bought.user_code}}</span></td>
                        <td><span class="badge badge-warning"><span class="text-success">{{asset.created_at  | formatDate}}</span></span></td>
                        <td>
                          <div class="btn-group">
                            <router-link :to="`/asset/${asset.id}/edit`" class="btn btn-sm btn-flat btn-outline-primary"><i class="fas fa-pencil-alt" title="Click to edit"></i></router-link> 
                            <a href="" @click.prevent="deleteAsset(asset.id)" class="btn btn-sm btn-flat btn-outline-danger"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
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
  import moment from 'moment'
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
            search:'',
            category_idSearch:0,
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
        getAllAsset(){
          this.$Progress.start()
          var avar = this.$store.getters.getAsset;
          if(avar.length==2)
            this.pagination = avar[1];
          this.$Progress.finish()
          return avar[0];
        },
        getAllCategoryAll(){
            return this.$store.getters.getBuyerCategorySelectAll
        },
    },
    methods:{
      fetchPosts() {
        this.$store.dispatch("allAsset",[this.pagination.current_page, this.search, this.category_idSearch]);
        this.$store.dispatch("allBuyerCategorySelectAll")
      },
      deleteAsset(id){
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
                axios.delete('/home/asset/'+id)
                .then((response)=>{
                    Toast.fire({
                      icon: 'success',
                      title: 'Asset Deleted successfully'
                  })
                that.$store.dispatch("allAsset",[0,0,0]);
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
                  title: 'Asset not Deleted'
              })
            }
        })
    },
    pagechange(){
      this.$store.dispatch("allAsset", [this.pagination.current_page,this.search,this.category_idSearch]);
    },
    searchAsset(){
      this.pagechange();
    },
    categoryChange(){
      this.pagechange();
    },
    },

      
  }
</script>

<style scoped>
</style>