<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <p class="text-danger m-0">Purchase List</p>
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
                  <div class="col-md-3 border-right">
                    <form role="form" enctype="multipart/form-data" @submit.prevent="addNewStock()">
                      <div class="form-group">
                        <input type="hidden" class="form-control" id="price" placeholder="Add Price" v-model="form.vendor_id" name="vendor_id">
                        <label for="category_id">Category <span class="text-danger">*</span></label>
                        <select class="form-control" id="category_id" v-model="form.category_id" name="category_id" :class="{ 'is-invalid': form.errors.has('category_id') }"> 
                          <option disabled value="">Select one</option>
                          <option :value="category.id" v-for="category in getAllCategory">{{category.name}}</option>
                        </select>
                        <has-error :form="form" field="category_id"></has-error>
                      </div>
                      <!-- <div class="form-group">
                        <label for="buyer_id">Bought User <span class="text-danger">*</span></label>
                        <select class="form-control" id="buyer_id" v-model="form.buyer_id" name="buyer_id" :class="{ 'is-invalid': form.errors.has('buyer_id') }"> 
                          <option disabled value="">Select one</option>
                          <option :value="buyer.id" v-for="buyer in getAllBuyer">{{buyer.user_code}} ({{buyer.name}})</option>
                        </select>
                        <has-error :form="form" field="buyer_id"></has-error>
                      </div> -->
                      <div class="form-group">
                        <label for="name">Stock Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" placeholder="Add New Name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="off">
                        <has-error :form="form" field="name"></has-error>
                      </div>
                      
                      <div class="form-group">
                        <label for="quantity">Quantity <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="quantity" placeholder="Add Quantity" v-model="form.quantity" name="quantity" :class="{ 'is-invalid': form.errors.has('quantity') }" autocomplete="off">
                        <has-error :form="form" field="quantity"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="unit_id">Unit <span class="text-danger">*</span></label>
                        <select class="form-control" id="unit_id" v-model="form.unit_id" name="unit_id" :class="{ 'is-invalid': form.errors.has('unit_id') }"> 
                          <option disabled value="">Select one</option>
                          <option :value="category.id" v-for="category in getAllUnit">{{category.name}}</option>
                        </select>
                        <has-error :form="form" field="unit_id"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="rate">Rate <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="rate" placeholder="Add Rate" v-model="form.rate" name="rate" :class="{ 'is-invalid': form.errors.has('rate') }" autocomplete="off">
                        <has-error :form="form" field="rate"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="vat">VAT </label>
                        <input type="text" class="form-control" id="vat" placeholder="Add Vat" v-model="form.vat" name="vat" :class="{ 'is-invalid': form.errors.has('vat') }" autocomplete="off" @keypress="isNumber($event)" @keydown="calcNetPrice($event)">
                      </div>
                      <div class="form-group">
                        <label for="price">Total Price <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price" placeholder="Add Price" v-model="form.price" name="price" readonly="true">
                        <has-error :form="form" field="price"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="nameID" class="d-block">Type</label>
                        <input type="radio" id="one" value="1" v-model="form.type">
                        <label for="one" class="mr-3">Ready made</label>
                        <input type="radio" id="two" value="2" v-model="form.type">
                        <label for="two">Kitchen</label>
                        <input type="radio" id="three" value="3" v-model="form.type">
                        <label for="three">Bar</label>
                        <has-error :form="form" field="type"></has-error>
                      </div>
                      <!-- /.card-body -->
                      <button type="submit" class="btn btn-primary btn-block" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Stock"}}</button>
                    </form>
                  </div>
                  <div class="col-md-9">
                    <form role="form" class="form-inline">
                      <div class="row">
                        <div class="form-group col-2 mb-1">
                          <select class="form-control w-100" v-model="category_idSearch"  @change="categoryChange">  
                            <option value="0">Please select All</option> 
                            <option :value="category.id" v-for="category in getAllCategoryAll">{{category.name}}</option>
                          </select>
                        </div>
                        <div class="form-group col-2 mb-1">
                          <input type="text" class="form-control w-100" @keyup="searchStock" v-model="search" placeholder="Search by name">
                        </div>
                        <div class="form-group col-3 mb-1">
                          <select name="type" v-model="type"  @change="typeChange" class="form-control">
                              <option>--- Select Type ---</option>
                              <option value="1">Ready Made</option>
                              <option value="2">Kitchen</option>
                              <option value="3">Bar</option>
                           </select>
                        </div>
                        <div class="form-group mb-1 col-3">
                          <!-- <label for="date">Date</label> -->
                          <date-picker v-model="date" v-on:input="dateChange">
                            <template v-slot="{ inputValue, inputEvents }">
                              <input
                                class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300 form-control"
                                :value="inputValue"
                                v-on="inputEvents"
                              />
                            </template>
                          </date-picker>
                        </div>
                      </div>
                    </form>
                    <div class="table-responsive">
                      <table class="table table-sm table-bordered table-hover">
                        <thead class="table-primary text-center">                  
                          <tr>
                            <th>SN</th>
                            <th class="text-left">Category</th>
                            <th class="text-left">Name</th>
                            <th class="text-left">Price</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Type</th>
                            <th>From</th>
                            <th>Issued</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="text-center">
                          <tr v-for="(stock,index) in getAllStock" :key="stock.id">
                            <td>{{index+1}}</td>
                            <td class="text-left">{{stock.category.name}}</td>
                            <td class="text-left">{{stock.name}}</td>
                            <td class="text-left">Rs: {{stock.price}}</td>
                            <td>{{stock.quantity}}</td>
                            <td>{{stock.unit.name}}</td>
                            <td v-if="stock.type == '1'"> Ready Made </td>
                            <td v-else-if="stock.type == '2'"> Kitchen </td>
                            <td v-else>Bar</td>
                            <td>{{stock.bought.name}} <span class="badge badge-info">{{stock.bought.user_code}}</span></td>
                            <td><span class="badge badge-warning"><span class="text-success">{{stock.created_at  | formatDate}}</span></span></td>
                            <td>
                              <router-link :to="`/stock/${stock.id}/edit`"><i class="fas fa-pencil-alt" title="Click to edit"></i></router-link> 
                              | 
                              <a href="" @click.prevent="deleteStock(stock.id)"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination>
                    </div>
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
        pagination: {
            'current_page': 1
          },
          form: new Form({
                vendor_id:this.$route.params.vendorid,
                category_id:'',
                buyer_id:'',
                unit_id:'',
                name:'',
                price:'',
                quantity:'',
                rate:'',
                vat:0,
                type: 1,

            }),
              state: {
                isSending: false
            },
            search:'',
            category_idSearch:0,
            type:'',
            date: new Date(),
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
        getAllStock(){
          this.$Progress.start()
          var avar = this.$store.getters.getStock;
          if(avar.length==2)
            this.pagination = avar[1];
          this.$Progress.finish()
          return avar[0];
        },
        getAllCategory(){
            return this.$store.getters.getBuyerCategorySelect
        },
        getAllCategoryAll(){
            return this.$store.getters.getBuyerCategorySelectAll
        },
        getAllUnit(){
            return this.$store.getters.getUnitSelect
        },
        getAllBuyer(){
            return this.$store.getters.getBuyerSelect
        }
    },
    methods:{
      fetchPosts() {
        this.$store.dispatch("allStock",[this.pagination.current_page, this.search, this.category_idSearch,this.$route.params.vendorid,this.type,this.date.toISOString().split('T')[0]]);
        this.$store.dispatch("allBuyerCategorySelect")
        this.$store.dispatch("allBuyerCategorySelectAll")
        this.$store.dispatch("allUnitSelect")
        this.$store.dispatch("allBuyerSelect")
      },
      deleteStock(id){
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
                axios.delete('/manager/stock/'+id)
                .then((response)=>{
                    Toast.fire({
                      icon: 'success',
                      title: 'Stock Deleted successfully'
                  })
                that.$store.dispatch("allStock",[0,0,0]);
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
                  title: 'Stock not Deleted'
              })
            }
        })
    },
    addNewStock(){
          this.state.isSending = true;
          this.form.post('/manager/stock')
          .then((response)=>{
              Toast.fire({
                  icon: 'success',
                  title: 'Stock Added successfully'
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
    pagechange(){
      this.$store.dispatch("allStock", [this.pagination.current_page,this.search,this.category_idSearch,this.$route.params.vendorid,this.type,this.date.toISOString().split('T')[0]]);
    },
    searchStock(){
      this.pagechange();
    },
    categoryChange(){
      this.pagechange();
    },
    typeChange(){
      this.pagechange();
    },
    dateChange(){
      this.pagechange();
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
    calcNetPrice:function(evt){
      this.form.price = (parseFloat(this.form.rate) + parseFloat(this.form.vat)) * parseFloat(this.form.quantity);
    },

    },

      
  }
</script>

<style scoped>
</style>