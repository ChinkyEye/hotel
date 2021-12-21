<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <p class="text-danger m-0">CheckOut 
                  <span class="text-primary float-right">{{name}} ,{{check_in_date}},
                    <span v-if="is_checked == 1">Checked Out</span>
                    <span v-else>Checked In</span>
                  </span>

                  <!-- <span>{{name}} {{check_in_date}}</span> -->
                </p>
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
                <div class="col-md-12 p-0 bg-light">
                  <form role="form" @submit.prevent="addOrder()">
                    <div class="table-responsive">
                      <table class="table table-sm table-hover">
                        <thead class="thead-light">
                          <tr>
                            <td colspan="4" class="text-center">Fooding Detail</td>
                          </tr>        
                          <tr>
                            <th>SN</th>
                            <th>BillId</th>
                            <th>Total</th>
                            <th>Paid Amount</th>
                            <th>Due</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(order,index) in getAllOrderDetail" :key="order.id">
                            <td>{{index+1}}</td>
                            <td>
                              <a href="">{{order.bill_id}}</a>
                            </td>
                            <td>{{order.grand_total}}</td>
                            <td>{{order.received}}</td>
                            <td>{{order.grand_total - order.received}}</td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="6" class="text-center">Housing Detail</td>
                          </tr>
                            <tr>
                              <td colspan="3"></td>
                              <td>Roome Price/Rate:</td>
                              <td>
                                <span v-for="(order,index) in form.room" :key="order.id">
                                 <span v-for="(data,index) in order.get_check_in_room" :key="data.id">
                                   {{data.get_room.price}}({{data.get_room.room_type}}),
                                 </span>
                                </span>
                              </td>
                              <td></td>
                            </tr>
                            <tr>
                              <td colspan="3"></td>
                              <td>Stay Day:</td>
                              <td><input type="text" class="form-control" v-model="form.day_of_stay" placeholder="Days of stay" >
                              </td>
                              <td></td>
                            </tr>
                            <tr>
                              <td colspan="3"></td>
                              <td>Total Due:</td>
                              <td><input type="text" class="form-control" v-model="form.due_total" placeholder="Grand Total" ></td>
                              <td></td>
                            </tr>
                            <tr>
                              <td colspan="3"></td>
                              <td>Total:</td>
                              <td><input type="text" class="form-control" v-model="form.sum" placeholder="Grand Total" ></td>
                              <td></td>
                            </tr>
                            <tr>
                              <td colspan="3"></td>
                              <td class="text-danger">Grand Total:</td>
                              <td><input type="text" class="form-control" v-model="form.grand_total2" placeholder="Grand Total" ></td>
                              <td></td>
                            </tr>
                            <tr v-if="form.status == '0'">
                              <td colspan="4"></td>
                              <td>
                                <button type="submit" class="btn btn-success btn-block"> Print and Save</button>
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
                day_of_stay:'',
                room:[],
                sum:'',
                due_total:'',
                grand_total2:'',
                user_t_id:'',
                table_id:1,
                user_id:'',
                status:'',
                item_id:'',
                
            }),
          check_in_date:'',
          name:'',
          is_checked:'',
          form_add: new Form({
                user_type:'',
                name:'',
                email:'',
                phone:'',
                address:'',
                date_of_join:'',
            }),
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
		},
    created(){
      axios.get(`/counter/checkin/${this.$route.params.checkinid}/edit`)
      .then((response)=>{
        console.log(response.data.checkins);
        this.check_in_date = response.data.checkins.check_in_date;
        this.name = response.data.checkins.get_user.name;
        this.is_checked = response.data.checkins.is_check_out;
        // this.form.fill(response.data.units)
      })
    },
		computed:{
      getAllOrderDetail()
      {
        this.$Progress.start()
        var avar = this.$store.getters.getCustomerOrderdetail;
        if(avar.length==2)
          this.pagination = avar[1];
        this.form.day_of_stay = avar[2];
        this.form.room = avar[3];
        this.form.sum = avar[4];
        this.form.due_total = avar[5],
        this.form.grand_total2 = avar[6],
        this.form.user_id = avar[7],
        // console.log(this.form.user_id);
        this.form.status = avar[8],
        this.$Progress.finish()
        // console.log(avar[0]);
        return avar[0];
      },
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
          return cpackage.map(function(cp){
            var today = moment().format("YYYY-MM-DD");
            var end_effective = moment(cp.effective).add(cp.get_user_package.days, 'days').format("YYYY-MM-DD");
            if(today > end_effective){
              cp.end_effective = "expired";
            }
            else{
              cp.end_effective = "Rem Days:"+moment(end_effective).diff(today)/86400000;
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
        this.state.isSending = false;
        this.$Progress.start()
        this.form.item_id = post.value;
        this.$Progress.finish()
      },
      custChange(post){
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
          axios.get('/counter/order/'+this.form.item_id)
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
          axios.post('/counter/checkout/savedetail',{
              total:this.form.due_total,
              id:this.form.user_id, 

          })
          .then((response)=>{
            // this.$router.push('/order/'+response.data.bill_id+'/preview')
            this.$router.push('/checkin')
            this.state.isOrdering = false;
              Toast.fire({
                  icon: 'success',
                  title: 'Checkout successfully'
              })
          })
          .catch(()=>{
            this.state.isOrdering = false;
          });
      },
      fetchPosts() {
        this.$store.dispatch("allSellerUsertypeSelect")
        // this.$store.dispatch("allCustomerOrderdetail",this.$route.params.checkinid)
        this.$store.dispatch("allCustomerOrderdetail",[0,this.$route.params.checkinid])
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
                axios.delete('/counter/item/'+id)
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
          this.form.post('/counter/item')
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
        axios.get('/counter/item/status/'+clkid+'/'+show)
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
      this.form_add.post('/counter/customer')
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