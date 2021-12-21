<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Salary</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                <router-link to="/salary" class="btn btn-primary" style="color:#fff"> View Salary <i class="fas fa-eye fa-fw"></i></router-link>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <form role="form" @submit.prevent="addSalary()">
                      <div class="form-group">
                        <label for="user_id">Name</label>
                        <select class="form-control" id="user_id" v-model="form.user_id" name="user_id" :class="{ 'is-invalid': form.errors.has('user_id') }" @change="userChange"> 
                          <option disabled value="">Select one user</option>
                          <option :value="user.id" v-for="user in getAllUserSalarySelect">{{user.user_code}} ({{user.name}})</option>
                        </select>
                        <has-error :form="form" field="user_id"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="month_id">Month</label>
                        <select class="form-control" id="month_id" v-model="form.month_id" name="month_id" :class="{ 'is-invalid': form.errors.has('month_id') }"> 
                          <option disabled value="">Select one month</option>
                          <option :value="item.id" v-for="item in getAllMonth">{{item.name}}</option>
                        </select>
                        <has-error :form="form" field="month_id"></has-error>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="salary">Salary</label>
                          <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Rs:</div>
                            </div>
                            <input type="text" class="form-control" id="salary" placeholder="User Salary" v-model="form.usersalary" name="salary" disabled>
                          </div>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="salary">Advance</label>
                          <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Rs:</div>
                            </div>
                            <input type="text" class="form-control" id="salary" placeholder="User Advance" v-model="form.deduct" name="salary" disabled>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" class="form-control" id="amount" placeholder="Add New Amount" v-model="form.amount" name="amount" :class="{ 'is-invalid': form.errors.has('amount') }" v-on:keyup="amountpress" v-on:change="amountpress">
                        <has-error :form="form" field="amount"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="vat">TDS</label>
                        <input type="text" class="form-control" id="vat" placeholder="Add New TDS" v-model="form.vat" name="vat" :class="{ 'is-invalid': form.errors.has('vat') }" v-on:change="vatChange">
                        <has-error :form="form" field="vat"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="total">Total</label>
                        <input type="text" class="form-control" id="total" placeholder="Add New Total" v-model="form.total" name="total" :class="{ 'is-invalid': form.errors.has('total') }" disabled>
                        <has-error :form="form" field="total"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="nameID" class="d-block">Type</label>
                        <div>
                          <input type="radio" id="three" value="0" v-model="form.type">
                          <label for="three">Monthly</label>
                        </div>
                        <div>
                          <input type="radio" id="one" value="1" v-model="form.type" :disabled="advance_disabled">
                          <label for="one">Advance</label>
                        </div>
                        <div>
                          <input type="radio" id="two" value="2" v-model="form.type" :disabled="deduct_disabled">
                          <label for="two">Deduct from Advance</label>
                        </div>
                      </div>
                      <!-- /.card-body -->
                      <button class="btn btn-primary btn-block" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Salary"}}</button>
                    </form>
                  </div>
                  <div class="col-md-8 p-0 bg-light">
                    <form>
                      <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover">
                          <thead class="table-primary">                  
                            <tr>
                              <th>SN</th>
                              <th>Month</th>
                              <th>Amount</th>
                              <th>TDS</th>
                              <th>Total</th>
                              <th>Status</th>
                              <th>Issued</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(salary,index) in getAllSalary" :key="salary.id"  :class="customerStatus(salary.is_active)">
                              <td>{{index+1}}</td>
                              <td>{{salary.month.name}}</td>
                              <td>{{salary.amount}}</td>
                              <td>{{salary.vat}}</td>
                              <td>{{salary.total}}</td>
                              <td v-if="salary.type == '0'">Monthly <a href="javascript:void(0)" title="Monthly"></a></td>
                              <td v-else-if="salary.type == '1'">Advance <a href="javascript:void(0)" title="Monthly"></a></td>
                              <td v-else>Advance Ded<a href="javascript:void(0)" title="Advance Ded"></a></td>
                              <td>
                                {{salary.created_at | timeformat}} 
                                <!-- <span class="badge badge-warning text-success">{{salary.created_at  | formatDate}}</span> -->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </form>
                  </div>
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
	export default{
		name: "List",
    data(){
      return{
          deduct_disabled: false,
          advance_disabled: false,
          form: new Form({
                user_id:'',
                month_id:'',
                usersalary:'',
                deduct:'',
                amount:'',
                vat:'',
                total:'',
                type:0,
            }),
              state: {
                isSending: false
            }
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
        getAllMonth(){
            return this.$store.getters.getMonth
        },
        getAllSalary(){
        this.$Progress.start()
        var avar = this.$store.getters.getUserSalary;
        if(avar ==null){
          this.$Progress.finish();
          return [];
        }
        Toast.fire({
            icon: 'success',
            title: 'Salary append successfully'
        });
        
        this.form.deduct = avar.deduct;
        this.form.usersalary = avar.usersalary;
        this.$Progress.finish();
        return avar.salaries;
      }
		},
		methods:{
      fetchPosts() {
        this.$store.dispatch("allUserSalarySelect")
        this.$store.dispatch("allMonth")
      },
      vatChange(){
        this.$Progress.start()
          this.form.total = this.form.amount-this.form.vat;
          this.$Progress.finish()
      },
      amountpress(){
        if(parseFloat(this.form.amount)>parseFloat(this.form.deduct)){
          this.deduct_disabled = true;
        } else {
          this.deduct_disabled = false;
        }
        if(parseFloat(this.form.amount)>parseFloat(this.form.usersalary)){
          this.advance_disabled = true;
        } else {
          this.advance_disabled = false;
        }
        this.vatChange();
      },
      resetForm() {
        this.form.reset();
      },
      customerStatus(id){
        return {
            'table-danger':!id,
            'table-default': id
        }
      },
      deleteItem(id){
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
                axios.delete('/bar/item/'+id)
                .then((response)=>{
                    Toast.fire({
                      icon: 'success',
                      title: 'Item Deleted successfully'
                  })
                that.$store.dispatch("allItem",[0]);
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
                  title: 'Item not Deleted'
              })
            }
        })
    },
      customerStatus(id){
        return {
            'table-danger':!id,
            'table-default': id
        }
      },
    resetForm() {
        this.form.reset();
      },
    addSalary(){
        this.state.isSending = true;
        this.$Progress.start()
        this.form.post('/bar/salary')
        .then(() => {
            this.state.isSending = false;
            Fire.$emit('AfterCreatedUserLoadIt'); //custom events
            Toast.fire({
                icon: 'success',
                title: 'Salary created successfully'
          })
            this.$Progress.finish()
            $('#addNew').modal('hide');
        })
        .catch(() => {
             console.log("Error......")
            this.state.isSending = false;
         })
        this.fetchPosts();
        this.resetForm(); //clear form automatically after successful request
    },
    userChange(){
      this.$Progress.start();
      this.$store.dispatch("allUserSalary",[this.form.user_id]);
      this.$Progress.finish();
    },
		}


      
	}
</script>

<style scoped>
</style>