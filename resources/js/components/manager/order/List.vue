<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Order</h1>
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
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                  <form>
                    <div class="form-group">
                      <label for="user_t_id">Customer Category <span class="text-danger">*</span></label>
                      <select class="form-control" id="user_t_id" v-model="form.user_t_id" name="user_t_id" :class="{ 'is-invalid': form.errors.has('user_t_id') }" @change="user_type_change"> 
                        <option disabled value="">Select one</option>
                        <option :value="usertype.id" v-for="usertype in getAllUsertypeSelect">{{usertype.name}}</option>
                      </select>
                      <has-error :form="form" field="user_t_id"></has-error>
                    </div>
                    <div class="form-group">
                      <label for="user_id">Name <span class="text-danger">*</span></label>
                      <a href="javascript:void(0)" class="float-right" data-toggle="modal" data-target="#addNew" @click="openModalWindow">Add New User</a>
                      <v-select id="user_id" name="user_id" :class="{ 'is-invalid': form.errors.has('user_id') }" :options="getAllUserSelect" v-on:input="custChange" v-model="customerSelected"> 
                      </v-select>
                      <input type="hidden" v-model="form.user_id">
                      <!-- <select class="form-control" id="user_id" v-model="form.user_id" name="user_id" :class="{ 'is-invalid': form.errors.has('user_id') }" @change="userChange">  -->
                      <!-- <option disabled value="">Select one</option> -->
                      <!-- <option :value="user.id" v-for="user in getAllUserSelect">{{user.user_code}} ({{user.name}})</option> -->
                      <!-- </select> -->
                      <has-error :form="form" field="user_id"></has-error>
                    </div>
                    <div class="form-group">
                      <div class="checkbox" v-for="(pack,index) in getSpecialPackage" :key="pack.id">
                      <label>
                        {{pack.get_user_package.name}}({{pack.get_user_package.days}})
                      </label>
                      <label>
                        {{pack.effective}}
                      </label>
                      <label>
                        {{pack.end_effective}}
                      </label>
                      </div>
                      <!-- <label for="package">Package Name</label><span id="rem"></span>
                      <input type="text" class="form-control" id="package" placeholder="Package Name" v-model="getSpecialPackage" name="package" disabled> -->
                    </div>
                    <div class="form-group">
                      <label for="table_id">Table <span class="text-danger">*</span></label>
                      <select class="form-control" id="table_id" v-model="form.table_id" name="table_id" :class="{ 'is-invalid': form.errors.has('table_id') }"> 
                        <option :value="table.id" v-for="table in getAllTableSelect">{{table.name}}</option>
                      </select>
                      <has-error :form="form" field="table_id"></has-error>
                    </div>
                    <div class="form-group">
                      <label for="item_id">Menu Item <span class="text-danger">*</span></label>
                      <v-select id="item_id" name="item_id" :class="{ 'is-invalid': form.errors.has('item_id') }" :options="getAllItem" v-on:input="postChange" v-model="defaultSelected"> 
                      </v-select>
                      <has-error :form="form" field="item_id"></has-error>
                    </div>
                    <!-- /.card-body -->
                    <button class="btn btn-primary btn-block" :disabled="state.isSending" @click.prevent="appendList()">{{state.isSending ? "Please wait..." : "Click to continue>>"}}</button>
                  </form>
                </div>
                <div class="col-md-9 p-0 bg-light">
                  <form role="form" @submit.prevent="addOrder()">
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead class="thead-light">                  
                          <tr>
                            <th>SN</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(order,index) in orders" :key="order.id">
                            <td class="py-3">{{index+1}}</td>
                            <td>
                              <input type="hidden" class="form-control" name="id[]" v-model="order.id">
                              <input type="text" class="form-control" v-model="order.name" readonly="true">
                            </td>
                            <td><input type="text" class="form-control" name="quantity[]" v-on:change="quantityChange(order)" v-model="order.quantity"></td>
                            <td>
                              <input type="text" class="form-control" v-model="order.unit.name" readonly="true">
                            </td>
                            <td><input type="text" class="form-control" v-model="order.price" readonly="true"></td>
                            <td><input type="text" class="form-control" v-model="order.sub_total" readonly="true"></td>
                            <td class="py-3"><span v-on:click="remove(index)"><i class="fas fa-times-circle"></i></span></td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="5"></td>
                            <td>
                              <button type="submit" class="btn btn-success btn-block float-right" :disabled="state.isOrdering">{{state.isOrdering ? "Please wait..." : "Save Order"}}</button>
                            </td>
                            <td></td>
                          </tr>
                        </tfoot>
                        </table>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
          </div>
          <!-- Modal -->
          <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addNewLabel">Add New User</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form @submit.prevent="createUser()">
                  <div class="modal-body">
                    <div class="row">
                      <div class="form-group col-md-6 col-md-6">
                        <label for="user_type">Select User</label>
                        <select class="form-control" id="user_type" v-model="form_add.user_type" name="user_type" :class="{ 'is-invalid': form_add.errors.has('user_type') }"> 
                          <option disabled value="">Select one</option>
                          <option :value="usertype.id" v-for="usertype in getAllUsertypeSelect">{{usertype.name}}</option>
                        </select>
                        <has-error :form="form_add" field="user_type"></has-error>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="nameID">Name</label>
                        <input type="text" class="form-control" id="nameID" placeholder="Add New Name" v-model="form_add.name" name="name" :class="{ 'is-invalid': form_add.errors.has('name') }">
                        <has-error :form="form_add" field="name"></has-error>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="emailID">Email</label>
                        <input type="text" class="form-control" id="emailID" placeholder="Add New Email" v-model="form_add.email" name="email" :class="{ 'is-invalid': form_add.errors.has('email') }">
                        <has-error :form="form_add" field="email"></has-error>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" placeholder="Add New Phone" v-model="form_add.phone" name="phone" :class="{ 'is-invalid': form_add.errors.has('phone') }">
                        <has-error :form="form_add" field="phone"></has-error>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Add New Address" v-model="form_add.address" name="address" :class="{ 'is-invalid': form_add.errors.has('address') }">
                        <has-error :form="form_add" field="address"></has-error>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="date_of_join">Date Of Join</label>
                        <input type="text" class="form-control" id="date_of_join" placeholder="Add Date of Join" v-model="form.date_of_join" name="date_of_join" :class="{ 'is-invalid': form.errors.has('date_of_join') }" autocomplete="off">
                        <has-error :form="form" field="date_of_join"></has-error>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- Modal ends -->
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
  import moment from 'moment';
	export default{
		name: "List",
    data(){
      return{
          form: new Form({
                user_t_id:'',
                table_id:1,
                user_id:'',
                item_id:'',
            }),
          form_add: new Form({
                user_type:'',
                name:'',
                email:'',
                phone:'',
                address:'',
                date_of_join:'',
            }),
                // gtotal:0,
                // mdiscount:0,
                // grand:0,
                // type_id:1,
                orders: [],
              state: {
                isSending: true,
                isOrdering: true,
            },
                defaultSelected: {
                  label: "-- Please Select --",
                  value: 0
                },
                customerSelected: {
                  label: "-- Please Select --",
                  value: 0
                },
        }
    },
		mounted(){
      this.fetchPosts();
      // document.body.classList.add('sidebar-collapse')
		},
		computed:{
      // getRem:{
      //   get(){
      //     console.log('1');
      //     return moment().format('YYYY-MM-DD'); 
      //   }
      // },
			getAllItem(){
        var that = this;
        this.$Progress.start()
				var avar = this.$store.getters.getItemSelect;
        this.$Progress.finish()
        var items = avar.filter(function(p){
          return that.orders.filter((o) => (p.id == o.id)).length == 0; 
        }).map(function(p){
            return {label: p.name, value: p.id};
        });
        return items;
			},
      getAllUsertypeSelect(){
          return this.$store.getters.getSellerUsertypeSelect
      },
      getAllUserSelect(){
        this.$Progress.start()
        var auser = this.$store.getters.getUserSelect
        this.$Progress.finish()
        return auser.map(function(p){
            return {label: (p.user_code + ' (' +p.name+')'), value: p.id};
        });
      },
      getAllTableSelect(){
          this.$Progress.finish()
          return this.$store.getters.getTableSelect
      },
      getSpecialPackage(){
        this.$Progress.finish()
          var cpackage = this.$store.getters.getSpecialUserPackageSelect;
          // effective_date = cpackage[0].effective;
          // console.log(cpackage.get_user_package.name);
          // cpackage = cpackage?cpackage:'N/A';
          return cpackage.map(function(cp){
            var today = moment().format("YYYY-MM-DD");
            var end_effective = moment(cp.effective).add(cp.get_user_package.days, 'days').format("YYYY-MM-DD");
            if(today > end_effective){
              cp.end_effective = "expired";
            }
            else{
              cp.end_effective = "Rem Days:"+moment(end_effective).diff(today)/86400000;
              // cp.end_effective = end_effective;
            }
            return cp;
          });
      },
		},
		methods:{
      openModalWindow(){
        this.form_add.reset();
        this.form_add.user_type = this.form.user_t_id;
        $('#addNew').modal('show');
      },
      postChange(post){
        // console.log(this,post);
        this.state.isSending = false;
        this.$Progress.start()
        this.form.item_id = post.value;
        this.$Progress.finish()
      },
      custChange(post){
        // console.log(this,post);
        this.state.isSending = false;
        this.$Progress.start()
        this.form.user_id = post.value;
        this.$store.dispatch("allSpecialUserPackage",this.form.user_id);
        this.$Progress.finish()
      },
      mdiscountChange(){
        this.$Progress.start()
          this.gtotal = this.orders.reduce(function(sum, order){
              return sum += order.sub_total;
          },0);
          this.grand = this.gtotal-this.mdiscount;
          this.$Progress.finish()
      },
      appendList(){
        this.state.isSending = true;
        this.state.isOrdering = false;
        var that = this;
        this.$Progress.start()
          axios.get('/manager/order/'+this.form.item_id)
          .then((response)=>{
            // this.state.isSending = false;
              Toast.fire({
                  icon: 'success',
                  title: 'Order append successfully'
              });
              response.data.posts.sub_total = response.data.posts.quantity * (response.data.posts.price);
              response.data.posts.org_price = response.data.posts.price;
              this.orders.push(response.data.posts);
              this.$Progress.finish()
              this.mdiscountChange();
              // that.form.item_id = '';
          })
      },
      addOrder(){
        this.state.isOrdering = true;
          axios.post('/manager/order',{
              data: this.orders,
              // mdiscount:this.mdiscount,
              user_id:this.form.user_id,
              table_id:this.form.table_id,
              user_t_id:this.form.user_t_id,
              // type_id:this.type_id
          })
          .then((response)=>{
              this.$router.push('/order/'+response.data.bill_id+'/preview')
            this.state.isOrdering = false;
              Toast.fire({
                  icon: 'success',
                  title: 'Ordered successfully'
              })
          })
          .catch(()=>{
            this.state.isOrdering = false;
          });
      },
      fetchPosts() {
        this.$store.dispatch("allSellerUsertypeSelect")
        // this.$store.dispatch("allUserSelect")
        this.$store.dispatch("allItemSelect")
        this.$store.dispatch("allTableSelect")
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
                axios.delete('/manager/item/'+id)
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
    addNewItem(){
      this.state.isSending = true;
          this.form.post('/manager/item')
          .then((response)=>{
              Toast.fire({
                  icon: 'success',
                  title: 'Item Added successfully'
              })
              this.state.isSending = false;
          })
          .catch(()=>{
              this.state.isSending = false;
          })
          this.fetchPosts();
          this.resetForm(); //clear form automatically after successful request
      },
      customerStatus(id){
        return {
            'table-danger':!id,
            'table-default': id
        }
      },
      userShow(clkid, show){
        axios.get('/manager/item/status/'+clkid+'/'+show)
        .then(()=>{
            Toast.fire({
                icon: 'success',
                title: 'Status changed successfully'
            })
        })
        .catch(()=>{
      })
        this.fetchPosts();
    },
    resetForm() {
        this.form.reset();
      },
    quantityChange(order){
      this.$Progress.start();
              order.sub_total = order.quantity * order.org_price;
              order.price = order.quantity * order.org_price;
      this.$Progress.finish()
              this.mdiscountChange();
          },
    remove(index) {
              this.orders.splice(index, 1);
              this.mdiscountChange();
              if(this.orders.length == 0){
                this.state.isOrdering = true;
              }
          },
    user_type_change(){
            this.$Progress.start()
            this.$store.dispatch("allUserSelect",this.form.user_t_id);
          },
    createUser(){
      var that = this;
      this.$Progress.start()
      this.form_add.post('/manager/customer')
      .then((response) => {
        this.$store.dispatch("allUserSelect",this.form.user_t_id);
        that.form.user_t_id = response.data.user_type_id;
        that.customerSelected = response.data.user_code+' ('+response.data.name+')';
        that.form.user_id = response.data.id;
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
           this.state.isOrdering = false;
       })
      this.$store.dispatch('allUserSelect',this.form.user_t_id)
    },
    userChange(){
      this.$Progress.start()
      this.$store.dispatch("allSpecialUserPackage",this.form.user_id);
      //this.getSpecialPackage();
    },
		},
    // watch:{
    //   document.querySelector('body').classList.add('sidebar-collapse');
    // }
	}
</script>

<style scoped>
</style>