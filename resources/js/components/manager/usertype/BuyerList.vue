<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="text-danger m-0">Buyer Customer List</p>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
                            <li class="breadcrumb-item active">User</li>
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
                                        <router-link to="/customer/buyer/create" class="btn btn-flat btn-danger btn-block" style="color:#fff"> Add Buyer <i class="fas fa-plus fa-fw"></i></i></router-link>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" @keyup="searchService" v-model="search" placeholder="Search Customer Category">
                                    </div>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover">
                                        <thead class="thead-dark">                  
                                            <tr>
                                                <th>SN</th>
                                                <th>Customer Category</th>
                                                <th>Status</th>
                                                <th>Issued</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(post,index) in allusertypes" :key="post.id" :class="customerStatus(post.is_active)">
                                                <td>{{index+1}}</td>
                                                <td>{{post.name}}</td>
                                                <td v-if="post.is_active == '0'">Inactive <a href="javascript:void(0)" @click.prevent="userShow(post.id, post.is_active)" title="Make Active"><i class="nav-icon fas fa-times-circle"></i></a></td>
                                                <td v-else>Active <a href="javascript:void(0)" @click.prevent="userShow(post.id, post.is_active)" title="Make InActive"><i class="nav-icon fas fa-check-circle"></i></a></td>
                                                <td>{{post.created_at | timeformat}} <span class="text-success badge badge-warning">{{post.created_at  | formatDate}}</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                    <router-link :to="`/customer/buyer/${post.id}/edit`" class="btn btn-sm btn-flat btn-outline-primary"><i class="fas fa-pencil-alt" title="Click to edit"></i></router-link> 
                                                    <a href="#" @click="deleteBuyerUser(post.id)" class="btn btn-sm btn-flat btn-outline-danger">
                                                        <i class="fa fa-trash red"></i>
                                                    </a>
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
export default {
    name: "List",
    components: {
        pagination,
    },
    data(){
        return {
            pagination: {
                'current_page': 1
              },
        search:'',
    }
},
mounted(){
    this.$Progress.start()
    this.fetchPosts()
    this.$Progress.finish()
},
computed:{
    allusertypes(){
        var avar = this.$store.getters.getBuyerType;
        if(avar.length==2)
          this.pagination = avar[1];
        return avar[0];
    }
},
methods:{
    fetchPosts() {
        this.$store.dispatch('getAllBuyerType', [this.pagination.current_page,0])
      },
    customerStatus(id){
        return {
            'table-danger':!id,
            'table-default': id
        }
    },
    deleteBuyerUser(id){
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
                axios.delete('/manager/customer/buyer/'+id)
                .then((response)=>{
                    that.$store.dispatch("getAllBuyerType", [that.search,0])
                    Toast.fire({
                      icon: 'success',
                      title: 'Customer Category Deleted successfully'
                  })
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
                  title: 'Service not Deleted'
              })
            }
        })
    },
    pagechange(){
        this.$store.dispatch("getAllBuyerType", [this.page,this.search]);
    },
    searchService(){
        this.page = 0;
        this.pagechange();
    },
    userShow(clkid, show){
        axios.get('/manager/customer/buyer/status/'+clkid+'/'+show)
        .then(()=>{
            this.$store.dispatch("getAllBuyerType", [this.pagination.current_page,0]);
            Toast.fire({
                icon: 'success',
                title: 'Status changed successfully'
            })
        })
        .catch(()=>{
      })
    },
    userSalary(clkid, show){
        axios.get('/manager/customer/buyer/salary/'+clkid+'/'+show)
        .then(()=>{
            this.$store.dispatch("getAllBuyerType", [this.pagination.current_page,0]);
            Toast.fire({
                icon: 'success',
                title: 'Status changed successfully'
            })
        })
        .catch(()=>{
      })
    }
},
watch:{
    page:function(val){
        this.pagechange();
    }
}
}
</script>

<style scoped>

</style>