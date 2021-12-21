<template>
<div>
    <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Visitor Order</h1>
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
              <label for="nameID">Name</label>
              <input type="text" class="form-control" id="nameID" placeholder="Add New Name" v-model="form_add.name" name="name" :class="{ 'is-invalid': form_add.errors.has('name') }">
              <has-error :form="form_add" field="name"></has-error>
          </div>
          <div class="form-group">
              <label for="emailID">Email</label>
              <input type="text" class="form-control" id="emailID" placeholder="Add New Email" v-model="form_add.email" name="email" :class="{ 'is-invalid': form_add.errors.has('email') }">
              <has-error :form="form_add" field="email"></has-error>
          </div>
          <div class="form-group">
              <label for="phone">Phone</label>
              <input type="text" class="form-control" id="phone" placeholder="Add New Phone" v-model="form_add.phone" name="phone" :class="{ 'is-invalid': form_add.errors.has('phone') }">
              <has-error :form="form_add" field="phone"></has-error>
          </div>
          <div class="form-group">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="address" placeholder="Add New Address" v-model="form_add.address" name="address" :class="{ 'is-invalid': form_add.errors.has('address') }">
              <has-error :form="form_add" field="address"></has-error>
          </div>
          <div class="form-group">
            <label for="table_id">Table</label>
            <select class="form-control" id="table_id" v-model="form.table_id" name="table_id" :class="{ 'is-invalid': form.errors.has('table_id') }"> 
                  <option disabled value="">Select one</option>
                  <option :value="table.id" v-for="table in getAllTableSelect">{{table.name}}</option>
                </select>
                <has-error :form="form" field="table_id"></has-error>
          </div>
          <div class="form-group">
            <label for="item_id">Item</label>
            <v-select id="item_id" name="item_id" :class="{ 'is-invalid': form.errors.has('item_id') }" :options="getAllItem" v-on:input="postChange"> 
                </v-select>
                <has-error :form="form" field="item_id"></has-error>
          </div>
        <!-- /.card-body -->
        <button class="btn btn-primary" :disabled="state.isSending" @click.prevent="appendList()">{{state.isSending ? "Loading..." : "Click to continue>>"}}</button>
      </form>
    </div>
    <div class="col-md-9 bg-light">
    <form role="form" @submit.prevent="addOrder()">
      <div class="table-responsive">
      <table class="table table-hover">
      <thead class="thead-light">                  
          <tr>
              <th>SN</th>
              <th>Item</th>
              <th>Quantity</th>
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
            <input type="hidden" class="form-control" name="id[]" v-model="order.id">
            <input type="text" class="form-control" v-model="order.name" readonly="true"></td>
            <td><input type="text" class="form-control" name="quantity[]" v-on:change="quantityChange(order)" v-model="order.quantity"></td>
            <td>
                <input type="text" class="form-control" v-model="order.unit.name" readonly="true"></td>
                <td><input type="text" class="form-control" v-model="order.price" readonly="true"></td>
                <td><input type="text" class="form-control" v-model="order.sub_total" readonly="true"></td>
                <td><span v-on:click="remove(index)"><i class="fas fa-times-circle"></i></span></td>
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
          <td>Discount:</td>
          <td><input type="text" class="form-control" name="mdiscount" placeholder="Enter Discount" v-on:change="mdiscountChange" v-model="mdiscount" >
          </td>
        </tr>
        <tr>
          <td colspan="4"></td>
          <td>Total:</td>
          <td><input type="text" class="form-control" v-model="grand" placeholder="Grand Total" readonly="true"></td>
        </tr>
        <tr>
          <td colspan="5"></td>
          <td>
          <button type="submit" class="btn btn-success" :disabled="state.isOrdering">{{state.isOrdering ? "Loading..." : "Save Order"}}</button>
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
                table_id:'',
                item_id:'',
            }),
          form_add: new Form({
                name:'',
                email:'',
                phone:'',
                address:'',
            }),
                gtotal:0,
                mdiscount:0,
                grand:0,
                type_id:1,
                orders: [],
              state: {
                isSending: false,
                isOrdering: false
            }
        }
    },
		mounted(){
      this.fetchPosts();
		},
		computed:{
			getAllItem(){
        this.$Progress.start()
				var avar = this.$store.getters.getItemSelect;
        this.$Progress.finish()
        return avar.map(function(p){
            return {label: p.name, value: p.id};
        });
			},
      getAllTableSelect(){
          this.$Progress.finish()
          return this.$store.getters.getTableSelect
      },
		},
		methods:{
      postChange(post){
        this.$Progress.start()
        this.form.item_id = post.value;
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
        this.$Progress.start()
          axios.get('/home/order/'+this.form.item_id)
          .then((response)=>{
              Toast.fire({
                  icon: 'success',
                  title: 'Order append successfully'
              });
              response.data.posts.sub_total = response.data.posts.quantity * (response.data.posts.price);
              response.data.posts.org_price = response.data.posts.price;
              this.orders.push(response.data.posts);
              this.$Progress.finish()
              this.mdiscountChange();
          })
      },
      addOrder(){
        this.state.isOrdering = true;
          axios.post('/home/visitor-order',{
              data: this.orders,
              mdiscount:this.mdiscount,
              user_id:this.form.user_id,
              table_id:this.form.table_id,
          })
          .then((response)=>{
              this.$router.push('/visitor-order/'+response.data.bill_id+'/preview')
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
        this.$store.dispatch("allItemSelect")
        this.$store.dispatch("allTableSelect")
      },
    addNewItem(){
      this.state.isSending = true;
          this.form.post('/home/item')
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
            },
		}


      
	}
</script>

<style scoped>
</style>