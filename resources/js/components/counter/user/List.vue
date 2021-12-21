<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{user_type_name}} List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
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
                  
                  <div class="col-md-8">
                    <input type="text" class="form-control" @keyup="searchUser" v-model="search" placeholder="Search by user code">
                  </div>
                  <!-- <div class="col-md-3">
                    <select class="form-control" id="user_type_id" v-model="user_type" @change="user_type_change"> 
                      <option value="0">All</option>
                      <option :value="usertype.id" v-for="usertype in getAllUsertype">{{usertype.name}}</option>
                    </select>
                  </div> -->
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover">
                    <thead class="table-primary">                  
                      <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>DOJ</th>
                        <th>Category</th>
                        <th>Created At</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(user,index) in getAllUser" :key="user.id">
                        <td>{{index+1}}</td>
                        <td>{{user.name}}</td>
                        <td>{{user.user_code}}</td>
                        <td>{{user.phone}}</td>
                        <td>{{user.address}}</td>
                        <td v-if="user.usertype.is_salary == '1'">{{user.date_of_join}}</td>
                        <td v-else>-</td>
                        <td v-if="user.type_id == '1'">Buyer <a href="javascript:void(0)" title="Buyer"></a></td>
                        <td v-else>Seller <a href="javascript:void(0)" title="Seller"></a></td>
                        <td v-else>-</td>
                        <td>{{user.created_at | timeformat}} <span class="badge badge-warning"><span class="text-success">{{user.created_at  | formatDate}}</span></span></td>
                       
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
      DatePicker,
    },
    data(){
      return{
        form: new Form({
                package_id:'',
                user_id:'',
                user_name:'',
                date: new Date(),
                fdate: '',
            }),
        pagination: {
            'current_page': 1
          },
          search:'',
          user_type_name:''
        }
    },
		mounted(){
      this.fetchPosts();
		},
		computed:{
			getAllUser(){
        this.$Progress.start()
        var bvar = this.$store.getters.getUser;
        if(bvar.length == 0) return [];
        var avar = bvar[0].users.data;
        // console.log(avar);
        this.user_type_name = bvar[0].user_type_name;
        if(bvar.length==2)
          this.pagination = bvar[1];
        this.$Progress.finish()
        return avar;
			},
      getAllPackageSelect(){
            return this.$store.getters.getPackageSelect
      },
      getAllUsertype(){
          return this.$store.getters.getUsertypeSelect
      }
		},
		methods:{
   
 
      fetchPosts() {
        this.$store.dispatch("allUser",[this.pagination.current_page,this.search,this.$route.params.userid]);
        this.$store.dispatch("allPackageSelect")
        this.$store.dispatch("allUsertypeSelect")
      },
     
  
    pagechange(){
      this.$store.dispatch("allUser", [this.pagination.current_page,this.search,this.$route.params.userid]);
    },
    searchUser(){
      this.pagechange();
    },
    user_type_change(){
      this.pagechange();
    }
		},
    watch:{
      '$route.params.userid': function(id){
        this.pagechange();
      }
    }
	}
</script>

<style scoped>
</style>