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
                  <div class="col-md-3">
                    <router-link :to="`/customer/${this.$route.params.userid}/create`"  class="btn btn-primary btn-block" style="color:#fff"> Add {{user_type_name}} <i class="fas fa-user-plus fa-fw"></i></router-link>
                  </div>
                  <div class="col-md-6">
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
                        <th>Data</th>
                        <th>Created At</th>
                        <th>Action</th>
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
                        <td v-if="user.usertype.type_id != '1'">
                          <span v-if="user.usertype.is_salary != '1'">
                            {{(user.userpackage.length==0?"N/A":user.userpackage[0]['name'])}}
                            <a href="javascript:void(0)" title="Add Package" @click="openModalWindow(user)"> 
                              <i class="fas fa-user-plus"></i>
                            </a> 
                          </span>
                          <span v-if="user.usertype.is_salary == '1'">Rs: {{(user.get_salary==null?"N/A":user.get_salary.salary)}}
                            <a href="javascript:void(0)" title="Add Salary" @click="openSalaryModalWindow(user)"> <i class="fas fa-user-plus"></i>
                            </a>
                          </span>
                        </td>
                        <td v-else>-</td>
                        <td>{{user.created_at | timeformat}} <span class="badge badge-warning"><span class="text-success">{{user.created_at  | formatDate}}</span></span></td>
                        <td><router-link :to="`/customer/${user.id}/edit`"><i class="fas fa-pencil-alt" title="Click to edit"></i></router-link> 
                          | 
                          <a href="" @click.prevent="deleteUser(user.id)"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
                          |
                          <!-- <router-link v-if="user.type_id == '1'" :to="`/customer/buyer/${user.id}`"><i class="fas fa-eye" title="Click to view detail"></i></router-link> -->
                          <router-link v-if="user.type_id == '2'" :to="`/customer/seller/${user.id}`"><i class="fas fa-eye" title="Click to view detail"></i></router-link> 
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
      <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addNewLabel">Edit User Package</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="createUser()">
              <div class="modal-body">
                <div class="form-group">
                  <label>User</label>
                  <input type="text" class="form-control" placeholder="Add New Name" v-model="form.user_name" disabled>
                  <input type="hidden" v-model="form.user_id" name="user_id" >
                </div>
                <div class="form-group">
                  <label for="package_id">Select Package</label>
                  <select class="form-control" id="package_id" v-model="form.package_id" name="package_id" :class="{ 'is-invalid': form.errors.has('package_id') }"> 
                    <option disabled value="">Select one</option>
                    <option :value="upackage.id" v-for="upackage in getAllPackageSelect">{{upackage.name}} ({{upackage.days}} Days)</option>
                  </select>
                  <has-error :form="form" field="package_id"></has-error>
                </div>
                <div class="form-group">
                  <label>Effective from Date</label>
                  <date-picker v-model="form.date" lang="en" name="date" type="date" :class="{ 'is-invalid': form.errors.has('date') }" :max-date='new Date()'></date-picker>
                  <has-error :form="form" field="name"></has-error>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="addSalaryNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addNewLabel">Edit User Salary</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="createUserSalary()">
              <div class="modal-body">
                <div class="form-group">
                  <label>User</label>
                  <input type="text" class="form-control" placeholder="Add New Name" v-model="form.user_name" disabled>
                  <input type="hidden" v-model="form.user_id" name="user_id" >
                </div>
                <div class="form-group">
                  <label for="salary">Salary</label>
                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text">Rs:</div>
                    </div>
                    <input type="text" class="form-control" id="salary" placeholder="Add Salary" v-model="form.salary" name="salary" :class="{ 'is-invalid': form.errors.has('salary') }">
                  </div>
                  <has-error :form="form" field="salary"></has-error>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
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
      openModalWindow(user){
        // this.form.reset();
        this.form.user_id = user.id;
        this.form.user_name = user.name;
        if(user.userpackage.length>0){
          // console.log(user.get_pack.effective);
          this.form.package_id = user.userpackage[0].id;
          this.form.date = moment(user.get_pack.effective).toDate();
        }
        $('#addNew').modal('show');
      },
      openSalaryModalWindow(user){
        // this.form.reset();
        this.form.user_id = user.id;
        this.form.user_name = user.name;
        if(user.get_salary != null){
          this.form.salary = user.get_salary.salary;
        }
        $('#addSalaryNew').modal('show');
      },
      fetchPosts() {
        this.$store.dispatch("allUser",[this.pagination.current_page,this.search,this.$route.params.userid]);
        this.$store.dispatch("allPackageSelect")
        this.$store.dispatch("allUsertypeSelect")
      },
      deleteUser(id){
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
                axios.delete('/kitchen/customer/'+id)
                .then((response)=>{
                    Toast.fire({
                      icon: 'success',
                      title: 'User Deleted successfully'
                  })
                    that.$store.dispatch("allUser", [0,0]);
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
                  title: 'User not Deleted'
              })
            }
        })
    },
    createUser(){
      // console.log(this.form);
        this.$Progress.start()
        this.form.fdate = moment(this.form.date).format("YYYY-MM-DD");
        this.form.post('/kitchen/user/package')
        .then(() => {
            Fire.$emit('AfterCreatedUserLoadIt'); //custom events
            Toast.fire({
                icon: 'success',
                title: 'User created successfully'
          })
            this.$Progress.finish()
            $('#addNew').modal('hide');
        })
        .catch(() => {
             console.log("Error......")
         })
        this.$store.dispatch('allUser',[this.pagination.current_page,this.search,this.$route.params.userid])
    },
    createUserSalary(){
      this.$Progress.start()
        this.form.post('/kitchen/user/salary')
        .then(() => {
            Fire.$emit('AfterCreatedUserLoadIt'); //custom events
            Toast.fire({
                icon: 'success',
                title: 'User created successfully'
          })
            this.$Progress.finish()
            $('#addSalaryNew').modal('hide');
        })
        .catch(() => {
             console.log("Error......")
         })
        this.$store.dispatch('allUser',[this.pagination.current_page,this.search,this.$route.params.userid])
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