<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <p class="text-danger m-0">Stock</p>
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
                  <div class="form-group col-3">
                    <select class="form-control w-100" v-model="category_idSearch"  @change="categoryChange">  
                      <option value="0">Please select All</option> 
                      <option :value="category.id" v-for="category in getAllCategoryAll">{{category.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-3">
                    <input type="text" class="form-control w-100" @keyup="searchStock" v-model="search" placeholder="Search by name">
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <!-- <div class="col-md-3 border-right">
                    <form role="form" enctype="multipart/form-data" @submit.prevent="addNewStock()">
                      <div class="form-group">
                        <label for="category_id">Category <span class="text-danger">*</span></label>
                        <select class="form-control" id="category_id" v-model="form.category_id" name="category_id" :class="{ 'is-invalid': form.errors.has('category_id') }"> 
                          <option disabled value="">Select one</option>
                          <option :value="category.id" v-for="category in getAllCategory">{{category.name}}</option>
                        </select>
                        <has-error :form="form" field="category_id"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="buyer_id">Bought User <span class="text-danger">*</span></label>
                        <select class="form-control" id="buyer_id" v-model="form.buyer_id" name="buyer_id" :class="{ 'is-invalid': form.errors.has('buyer_id') }"> 
                          <option disabled value="">Select one</option>
                          <option :value="buyer.id" v-for="buyer in getAllBuyer">{{buyer.user_code}} ({{buyer.name}})</option>
                        </select>
                        <has-error :form="form" field="buyer_id"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="name">Stock Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" placeholder="Add New Name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="off">
                        <has-error :form="form" field="name"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="price">Price <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price" placeholder="Add Price" v-model="form.price" name="price" :class="{ 'is-invalid': form.errors.has('price') }" autocomplete="off">
                        <has-error :form="form" field="price"></has-error>
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
                      <button type="submit" class="btn btn-primary btn-block" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Stock"}}</button>
                    </form>
                  </div> -->
                  <div class="col-md-9">
                    <div class="table-responsive">
                      <table class="table table-sm table-bordered table-hover">
                        <thead class="thead-dark">                  
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
	export default{
		name: "List",
    components: {
      pagination,
    },
    data(){
      return{
        pagination: {
            'current_page': 1
          },
          form: new Form({
                category_id:'',
                buyer_id:'',
                unit_id:'',
                name:'',
                price:'',
                quantity:'',
            }),
              state: {
                isSending: false
            },
            search:'',
            category_idSearch:0
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
        this.$store.dispatch("allStock",[this.pagination.current_page, this.search, this.category_idSearch]);
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
                axios.delete('/bar/stock/'+id)
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
          this.form.post('/bar/stock')
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
      console.log(this.category_idSearch);
      this.$store.dispatch("allStock", [this.pagination.current_page,this.search,this.category_idSearch]);
    },
    searchStock(){
      this.pagechange();
    },
    categoryChange(){
      this.pagechange();
    }
		},

      
	}
</script>

<style scoped>
</style>