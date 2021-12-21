<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
           <p class="text-danger m-0">Check In</p>
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
                    <router-link to="/checkin/create" class="btn btn-flat btn-danger btn-block" style="color:#fff"> Add <i class="fas fa-plus fa-fw"></i></i></router-link>
                  </div>
                  <div class="col-md-10">
                    <input type="text" class="form-control" v-model="search" placeholder="">
                    <!-- <input type="text" class="form-control" @keyup="searchBar" v-model="search" placeholder=""> -->
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover">
                    <thead class="thead-dark">                  
                      <tr>
                        <th>SN</th>
                        <th>Customer Name</th>
                        <th>Check-in Date</th>
                        <th>Check-out Date</th>
                        <th>Status</th>
                        <!-- <th>Issued</th> -->
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(data,index) in getAllCheckIn" :key="data.id"  :class="customerStatus(data.is_active)">
                        <td>{{index+1}}</td>
                        <td>{{data.get_user.name}}</td>
                        <td><span class="badge badge-warning">{{data.check_in_date}}</span></td>
                        <td><span class="badge badge-warning">{{data.check_out_date}}</span>

                         <a href="javascript:void(0)" class="btn btn-sm btn-flat btn-outline-primary" title="Check Out Date" @click="openModalWindow(data.id)" v-if="data.is_check_out == '0'"> 
                          <i class="fas fa-plus"></i>
                        </a>

                        </td>
                        <td>
                          <span v-if="data.is_check_out == '1'" class="badge badge-danger">checked-out</span>
                          <span v-else class="badge badge-info">checked-In</span>
                        </td>
                       <!--  <td v-if="data.is_active == '0'">Inactive <a href="javascript:void(0)" @click.prevent="data.is_check_out == 1 ? '' : userShow(data.id, data.is_active)" title="Make Active"><i class="nav-icon fas fa-times-circle"></i></a>
                          <span v-if="data.is_check_out == '1'">checked-out</span>
                          <span v-else></span>
                        </td>
                        <td v-else>Active <a href="javascript:void(0)" @click.prevent="data.is_check_out == 1 ? '' : userShow(data.id, data.is_active)" title="Make InActive"><i class="nav-icon fas fa-check-circle"></i></a>
                          <span class="badge badge-danger" v-if="data.is_check_out == '1'">checked-out</span>
                          <span v-else></span>
                        </td> -->
                        <td>
                            <a href="" @click.prevent="deleteCheckIn(data.id)" class="btn btn-sm btn-flat btn-outline-danger" v-if="data.is_check_out == '0'"><i class="fas fa-trash-alt" title="Click to delete" ></i></a>

                            <router-link :to="`/checkin/customer/${data.id}`" class="btn btn-xs btn-outline-info"><i class="fas fa-eye" title="Click to view detail"></i></router-link> 
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
              <h5 class="modal-title" id="addNewLabel">Check Out Date</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="createUser()">
              <div class="modal-body">
                <input type="hidden" v-model="form.checkin_id" name="checkin_id" >
                <div class="form-group col-md">
                <label for="check_out_date">Check-out Date<span class="text-danger">*</span></label>
                <date-picker v-model="form.date2" v-on:input="dateChange">
                  <template v-slot="{ inputValue, inputEvents }">
                    <input
                    class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300 form-control"
                    :value="inputValue"
                    v-on="inputEvents"
                    />
                  </template>
                </date-picker>
                <has-error :form="form" field="check_out_date"></has-error>
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
      DatePicker
    },
    data(){
      return{
        form: new Form({
          checkin_id:'',
          date2:moment(new Date()).format('YYYY-MM-DD'),
        }),
        id:'',
        pagination: {
            'current_page': 1
          },
          search:'',
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      getAllCheckIn(){
        this.$Progress.start()
        var avar = this.$store.getters.getCheckIn;
        if(avar.length==2)
          this.pagination = avar[1];
        this.$Progress.finish()
        return avar[0];
      }
    },
    methods:{
      fetchPosts() {
        this.$store.dispatch("allCheckIn",[this.pagination.current_page,0]);
      },
      customerStatus(id){
        return {
            'table-danger':!id,
            'table-default': id
        }
      },
      openModalWindow($id){
        // this.form.reset();
        this.form.checkin_id = $id;
        $('#addNew').modal('show');
      },
      createUser(){
        var that = this;
        this.$Progress.start()
        this.form.date2 = moment(this.form.date2).format('YYYY-MM-DD');
        this.form.post('/counter/checkin/checkout')
        .then(() => {
            // Fire.$emit('AfterCreatedUserLoadIt'); //custom events
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
        that.form.amount = '';
        this.fetchPosts();
      },
      dateChange(){
        this.pagechange();
      },
      deleteCheckIn(id){
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
                axios.delete('/counter/checkin/'+id)
                .then((response)=>{
                    Toast.fire({
                      icon: 'success',
                      title: 'CheckIn Deleted successfully'
                  })
                    that.$store.dispatch("allCheckIn", [0,0]);
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
                  title: 'CheckIn not Deleted'
              })
            }
        })
    },
    userShow(clkid, show){
        axios.get('/counter/checkin/status/'+clkid+'/'+show)
        .then(()=>{
            this.$store.dispatch("allCheckIn", [0,0]);
            Toast.fire({
                icon: 'success',
                title: 'Status changed successfully'
            })
        })
        .catch(()=>{
      })
    },
    pagechange(){
      this.$store.dispatch("allCheckIn", [this.pagination.current_page,this.search]);
    },
    searchBar(){
      this.pagechange();
    }
    }
  }
</script>

<style scoped>
</style>