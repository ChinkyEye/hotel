<template>
<div>
    <div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">{{customer.name}} ({{customer.user_code}})</h1>
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
    <div class="col-md-4">
      <form>
          <div class="form-group">
            <label for="user_t_id">Customer Category<span class="text-danger">*</span></label>
            <select class="form-control" id="user_t_id" v-model="form.user_t_id" name="user_t_id" :class="{ 'is-invalid': form.errors.has('user_t_id') }" @change="user_type_change"> 
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
            <has-error :form="form" field="user_id"></has-error>
          </div>
          <div class="form-group">
            <label for="bill_id">Bill ID</label>
            <input type="text" class="form-control" id="bill_id" v-model="form.bill_id" name="bill_id" :class="{ 'is-invalid': form.errors.has('bill_id') }" readonly="true">
                <has-error :form="form" field="bill_id"></has-error>
          </div>
          <div class="form-group">
            <label for="item_id">Item</label>
            <v-select id="item_id" name="item_id" :class="{ 'is-invalid': form.errors.has('item_id') }" :options="getAllItem" v-on:input="postChange" v-model="defaultSelected"> 
            </v-select>
            <has-error :form="form" field="item_id"></has-error>
          </div>
        <!-- /.card-body -->
        <button class="btn btn-primary" :disabled="state.isSending" @click.prevent="appendList()">{{state.isSending ? "Please wait..." : "Click to continue>>"}}</button>
      </form>
    </div>
    <div class="col-md-8">
    <form role="form" @submit.prevent="addOrder()">
      <div class="table-responsive">
      <table class="table table-hover table-sm">
      <thead class="thead-light">                  
          <tr>
              <th>SN</th>
              <th width="30%">Item</th>
              <th>Qty</th>
              <th>Unit</th>
              <th>Price</th>
              <th>Total</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody>
        <tr v-for="(order,index) in orders" :key="order.id">
          <td>{{index+1}}</td>
          <td>
            <input type="hidden" class="form-control" name="item_id[]" v-model="order.item.id">
            <input type="text" class="form-control" v-model="order.item.name" readonly="true"></td>
            <td><input type="text" class="form-control" name="quantity[]" v-on:change="quantityChange(order)" v-model="order.quantity"></td>
            <td>
                <input type="text" class="form-control" v-model="order.unit.name" readonly="true"></td>
                <td><input type="text" class="form-control" v-model="order.item.price" readonly="true"></td>
                <td><input type="text" class="form-control" v-model="order.sub_total" readonly="true"></td>
                <td><span @click.prevent="deleteItem(order.id)"><i class="fas fa-times-circle"></i></span></td>
          </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4"></td>
          <td>Amount:</td>
          <td><input type="text" class="form-control" placeholder="Total Amount" v-model="gtotal" readonly="true">
          </td>
        </tr>
        <tr>
          <td colspan="4"></td>
          <td>Discount({{calc_discount}}%):</td>
          <td><input type="text" class="form-control" name="mdiscount" placeholder="Enter Discount" v-on:change="mdiscountChange" v-model="getDiscount" readonly>
          </td>
        </tr>
        <tr>
          <td colspan="4"></td>
          <td>Total:</td>
          <td><input type="text" class="form-control" v-model="grand" placeholder="Grand Total" readonly="true"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
          <td>Tender:</td>
          <td><input type="text" class="form-control" v-model="tender" @keydown.tab="tenderChange" placeholder="Enter Tender" @keypress="isNumber($event)"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
          <td>Change:</td>
          <td><input type="text" class="form-control" v-on:change="mreceiveChange" name="change" v-model="change" placeholder="Receive Amount" autocomplete="off"></td>
        </tr>
        <!-- <tr>
          <td colspan="4"></td>
          <td>Received:</td>
          <td><input type="text" class="form-control" v-on:change="mreceiveChange" name="reveive" v-model="receive" placeholder="Receive Amount" autocomplete="off"></td>
        </tr> -->
        <tr>
          <td colspan="4"></td>
          <td>Remaining:</td>
          <td><input type="text" class="form-control" v-model="remaining" placeholder="Remaining amount" readonly="true"></td>
        </tr>
        <!-- <tr>
          <td colspan="4"></td>
          <td>Remaining:</td>
          <td><input type="text" class="form-control" v-model="remaining" placeholder="Remaining amount" readonly="true"></td>
        </tr> -->
        <tr>
          <td colspan="1"></td>
          <td>
          <button type="submit" class="btn btn-success" :disabled="state.isOrdering">{{state.isOrdering ? "Please wait..." : "Save & Print"}}</button>
          </td>
        </tr>
      </tfoot>
      </table>
      </div>
    </form>
  </div>
  </div>
  </div>
  </div>
  <!-- /.card -->
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
          form: new Form({
                user_t_id:'',
                bill_id:'',
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
                gtotal:0,
                mdiscount:0,
                grand:0,
                receive:0,
                remaining:0,
                // type_id:1,
                usertype_id:'',
                calc_discount:'',
                tender:0,
                change:0,
                orders: [],
                customer:{},
              state: {
                isSending: true,
                isOrdering: false
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
		computed:{
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
			getAllItem(){
        var that = this;
        this.$Progress.start()
				var avar = this.$store.getters.getItemSelect;
        this.$Progress.finish()
        var items = avar.filter(function(p){
          return that.orders.filter((o) => (p.id == o.item_id)).length == 0; 
        }).map(function(p){
            return {label: p.name, value: p.id};
        });
        return items;
			},
      getDiscount:{
        get(){
          return parseFloat(this.gtotal * this.calc_discount / 100).toFixed(2); 
        }
      }
		},
		methods:{
      openModalWindow(){
        this.form_add.reset();
        this.form_add.user_type = this.form.user_t_id;
        $('#addNew').modal('show');
      },
      user_type_change(){
        var that = this;
        this.$store.dispatch("allUserSelect",this.form.user_t_id);
        var types = this.$store.getters.getSellerUsertypeSelect;
        var type = types.find((t)=>t.id==that.form.user_t_id);
        if(type != null){
          this.calc_discount = type.discount;
        }
        this.customerSelected = {
                  label: "-- Please Select --",
                  value: 0
                }
        this.form.user_id = '';
        this.mdiscountChange();
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
        this.$Progress.finish()
      },
      mdiscountChange(){
        this.$Progress.start()
          this.gtotal = this.orders.reduce(function(sum, order){
              return sum += order.sub_total;
          },0);
          this.grand = this.gtotal-this.getDiscount;
          this.$Progress.finish()
      },
      mreceiveChange(){
        this.remaining = parseFloat(this.grand-this.receive).toFixed(2);
      },
      appendList(){
        this.state.isSending = true;
        this.$Progress.start()
          axios.get('/counter/order/'+this.form.item_id)
          .then((response)=>{
              Toast.fire({
                  icon: 'success',
                  title: 'Order append successfully'
              });
              response.data.posts.item = JSON.parse(JSON.stringify(response.data.posts));
              response.data.posts.sub_total = response.data.posts.quantity * (response.data.posts.price);
              response.data.posts.org_price = response.data.posts.price;
              
              response.data.posts.item_id = response.data.posts.item.id;
              this.orders.push(response.data.posts);
              this.$Progress.finish()
              this.mdiscountChange();
          })
      },
      addOrder(){
        this.state.isOrdering = true;
          axios.post('/counter/confirm',{
              data: this.orders,
              mdiscount:this.mdiscount,
              user_id:this.form.user_id,
              // type_id:this.type_id,
              calc_discount:this.calc_discount,
              tender:this.tender,
              change:this.change,
              receive:this.receive,
              remaining:this.remaining,
              bill_id:this.form.bill_id
          })
          .then((response)=>{
            // console.log("here2");
            // this.$router.push('/confirm/'+response.data.bill_id+'/preview')
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
        var that = this;
        this.$store.dispatch("allSellerUsertypeSelect")
        this.$store.dispatch("allItemSelect")
        this.$store.dispatch("allUserSelect",[this.form.user_t_id])
          axios.get(`/counter/confirm/${this.$route.params.billid}`)
            .then((response)=>{
              this.customer = (typeof response.data.notconfirmbills.customer)=="undefined"?[]:response.data.notconfirmbills.customer;
              // console.log(this.customer);
              this.form.user_t_id = this.customer.user_type_id;
              this.form.user_id = this.customer.id;
              this.customerSelected = {
                label:this.customer.user_code+' ('+this.customer.name+')',
                value:this.customer.id
              }
              this.form.bill_id = response.data.notconfirmbills.bill_id;
              this.usertype_id = response.data.notconfirmbills.usertype_id;
              this.calc_discount = response.data.notconfirmbills.usertype.discount;
              this.orders = response.data.notconfirmbills.order;
              this.orders = this.orders.map(function(ord){
                ord.sub_total = ord.quantity * (ord.item.price);
                ord.org_price = ord.item.price;
                return ord;
              })
              that.mdiscountChange();
            })
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
                axios.delete('/counter/confirm/'+id)
                .then((response)=>{
                  that.fetchPosts();
                    Toast.fire({
                      icon: 'success',
                      title: 'Item Deleted successfully'
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
      isNumber: function(evt) {
          evt = (evt) ? evt : window.event;
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if ((charCode > 31 && (charCode < 48 || charCode > 57) ) && charCode !== 46
    ) {
            evt.preventDefault();
          } else {
            return true;
          }
        },
    tenderChange(){
      console.log('hello');
      // console.log(this.form.customer_id);
      this.$Progress.start()
      var cond = this.grand-this.tender;
      var cdue = this.grand-this.tender;
      var sign = (cond) > 0 ? 1 : -1;
      if(sign == '-1'){
          this.change = this.tender - this.grand;
          this.remaining = 0;
          this.state.isOrdering = false;
      }
      else{
          this.remaining = cdue;
          this.change = 0;
       
      }
      this.$Progress.finish()
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
            }
		}


      
	}
</script>

<style scoped>
</style>