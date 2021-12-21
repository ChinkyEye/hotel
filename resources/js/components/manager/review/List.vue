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
                  <div class="col-md-3">
                    <form>
                      <div class="form-group">
                        <label for="bill_id">Bill ID </label>
                        <input type="text" class="form-control" id="bill_id" v-model="form.bill_id" name="bill_id" :class="{ 'is-invalid': form.errors.has('bill_id') }" readonly="true">
                        <has-error :form="form" field="bill_id"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="item_id">Item <span class="text-danger">*</span></label>
                        <v-select id="item_id" name="item_id" :class="{ 'is-invalid': form.errors.has('item_id') }" :options="getAllItem" v-on:input="postChange" v-model="defaultSelected"> 
                        </v-select>
                        <has-error :form="form" field="item_id"></has-error>
                      </div>
                      <!-- /.card-body -->
                      <button class="btn btn-primary btn-block" :disabled="state.isSending" @click.prevent="appendList()">{{state.isSending ? "Loading..." : "Click to continue>>"}}</button>
                    </form>
                  </div>
                  <div class="col-md-9 p-0 bg-light">
                    <form role="form" @submit.prevent="addOrder()">
                      <div class="table-responsive">
                        <table class="table table-hover">
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
                              <td class="py-3">{{index+1}}</td>
                              <td>
                                <input type="hidden" class="form-control" name="item_id[]" v-model="order.item.id">
                                <input type="text" class="form-control" v-model="order.item.name" readonly="true">
                              </td>
                              <td><input type="text" class="form-control" name="quantity[]" v-on:change="quantityChange(order)" v-model="order.quantity"></td>
                              <td>
                                <input type="text" class="form-control" v-model="order.unit.name" readonly="true">
                              </td>
                              <td><input type="text" class="form-control" v-model="order.item.price" readonly="true"></td>
                              <td><input type="text" class="form-control" v-model="order.sub_total" readonly="true"></td>
                              <td class="py-3"><span @click.prevent="deleteItem(order.id)"><i class="fas fa-times-circle"></i></span></td>
                            </tr>
                          </tbody>
                          <tfoot>
                            <!-- <tr>
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
                              <td colspan="4"></td>
                              <td>Type:</td>
                              <td>
                                <input type="radio" id="one" value="1" v-model="type_id">
                                <label for="one">Paid</label>
                                <input type="radio" id="two" value="2" v-model="type_id">
                                <label for="two">Due</label>
                              </td>
                            </tr> -->
                            <tr>
                              <td colspan="4"></td>
                              <td colspan="2">
                                <button type="submit" class="btn btn-success btn-block" :disabled="state.isOrdering">{{state.isOrdering ? "Loading..." : "Update Order"}}</button>
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
                bill_id:'',
                item_id:'',
            }),
                // gtotal:0,
                // mdiscount:0,
                // grand:0,
                // type_id:1,
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
        }
    },
		mounted(){
      this.fetchPosts();
		},
		computed:{
			getAllItem(){
        var that = this;
        this.$Progress.start()
				var avar = this.$store.getters.getItemSelect;
        this.$Progress.finish()
        var items = avar.filter(function(p){
          return that.orders.filter((o) => (p.id == o.item.id)).length == 0; 
        }).map(function(p){
            return {label: p.name, value: p.id};
        });
        return items;
			}
		},
		methods:{
      postChange(post){
        this.state.isSending = false;
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
        this.state.isSending = true;
        this.$Progress.start()
          axios.get('/manager/order/'+this.form.item_id)
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
              // this.mdiscountChange();
          })
      },
      addOrder(){
        // console.log(this);
        this.state.isOrdering = true;
          axios.post('/manager/review',{
              data: this.orders,
              bill_id:this.form.bill_id
          })
          .then((response)=>{
            this.$router.push('/review/'+response.data.bill_id+'/preview')
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
        this.$store.dispatch("allItemSelect")
          axios.get(`/manager/confirm/${this.$route.params.billid}`)
            .then((response)=>{
              // console.log(response.data);
              this.customer = (typeof response.data.notconfirmbills.customer)=="undefined"?[]:response.data.notconfirmbills.customer;
              this.form.bill_id = response.data.notconfirmbills.bill_id;
              this.orders = response.data.notconfirmbills.order;
              this.orders = this.orders.map(function(ord){
                ord.sub_total = ord.quantity * (ord.item.price);
                ord.org_price = ord.item.price;
                return ord;
              })
              that.mdiscountChange();
              // context.commit('notconfirmbilles', response.data.notconfirmbills)
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
                axios.delete('/manager/review/'+id)
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
            }
		}


      
	}
</script>

<style scoped>
</style>