<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <p class="text-danger m-0">Menu List</p>
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
                  <div class="form-group col-md pb-0">
                    <input type="text" class="form-control" @keyup="searchStock" v-model="search" placeholder="Search by name">
                  </div>
                  <div class="form-group col-md pb-0">
                    <select class="form-control" v-model="category_idSearch"  @change="categoryChange">  
                      <option value="0">Please select All Category</option> 
                      <option :value="category.id" v-for="category in getAllCategory">{{category.name}}</option>
                    </select>
                  </div>
                  <!-- <div class="form-group col-md pb-0"> -->
                    <!-- <date-picker v-model='date' /> -->
                    <!-- <date-picker v-model="date" lang="en" type="date" format="YYYY-MM-dd" v-on:input="dateChange"></date-picker> -->
                    <!-- <date-picker v-model="date" v-on:input="dateChange">
                      <template v-slot="{ inputValue, inputEvents }">
                        <input
                          class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300"
                          :value="inputValue"
                          v-on="inputEvents"
                        />
                      </template>
                    </date-picker> -->
                  <!-- </div> -->
                </div>
              </div>
              <div class="card-body">
          <!-- <div class="col-md-3">
            <form role="form" enctype="multipart/form-data" @submit.prevent="addNewItem()">
                <div class="form-group">
                  <label for="category_id">Category</label>
                  <select class="form-control" id="category_id" v-model="form.category_id" name="category_id" :class="{ 'is-invalid': form.errors.has('category_id') }"> 
                        <option disabled value="">Select one</option>
                        <option :value="category.id" v-for="category in getAllCategory">{{category.name}}</option>
                      </select>
                      <has-error :form="form" field="category_id"></has-error>
                </div>
                <div class="form-group">
                  <label for="name">Item Name</label>
                  <input type="text" class="form-control" id="name" placeholder="Add New Name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <label for="price">Price</label>
                  <input type="text" class="form-control" id="price" placeholder="Add Price" v-model="form.price" name="price" :class="{ 'is-invalid': form.errors.has('price') }">
                  <has-error :form="form" field="price"></has-error>
                </div>
                <div class="form-group">
                  <label for="quantity">Quantity</label>
                  <input type="text" class="form-control" id="quantity" placeholder="Add Quantity" v-model="form.quantity" name="quantity" :class="{ 'is-invalid': form.errors.has('quantity') }">
                  <has-error :form="form" field="quantity"></has-error>
                </div>
                <div class="form-group">
                  <label for="unit_id">Unit</label>
                  <select class="form-control" id="unit_id" v-model="form.unit_id" name="unit_id" :class="{ 'is-invalid': form.errors.has('unit_id') }"> 
                        <option disabled value="">Select one</option>
                        <option :value="category.id" v-for="category in getAllUnit">{{category.name}}</option>
                      </select>
                      <has-error :form="form" field="unit_id"></has-error>
                </div>
              <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Item"}}</button>
            </form>
          </div> -->
          <div class="table-responsive">
            <table class="table table-sm table-bordered table-hover">
              <thead class="thead-dark">                  
                <tr>
                  <th>SN</th>
                  <th>Category</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Unit</th>
                  <th>Type</th>
                  <th>Issued</th>
                  <!-- <th>Action</th> -->
                </tr>
              </thead>
              <tbody class="text-center">
                <tr v-for="(item,index) in getAllItem" :key="item.id" :class="customerStatus(item.is_active)">
                  <td>{{index+1}}</td>
                  <td class="text-left">{{item.category.name}}</td>
                  <td class="text-center"><img :src="productImage(item.image_enc)" width="50" height="50"></td>
                  <td class="text-left" v-if="item.is_active == '0'"><a href="javascript:void(0)" @click.prevent="userShow(item.id, item.is_active)" title="Make Active"><i class="nav-icon fas fa-times-circle"></i></a> {{item.name}} </td>
                  <td class="text-left" v-else><a href="javascript:void(0)" @click.prevent="userShow(item.id, item.is_active)" title="Make InActive"><i class="nav-icon fas fa-check-circle"></i></a> {{item.name}}</td>
                  <td>Rs: {{item.price}}</td>
                  <td>{{item.quantity}}</td>
                  <td>{{item.unit.name}}</td>
                  <td v-if="item.item_type_id == '1'"> Ready Made </td>
                  <td v-else>Kitchen</td>
                  <td><span class="badge badge-warning"><span class="text-success">{{item.created_at  | formatDate}}</span></span></td>
                  <!-- <td>
                  <router-link :to="`/item/${item.id}/edit`"><i class="fas fa-pencil-alt" title="Click to edit"></i></router-link> 
                    | 
                    <a href="" @click.prevent="deleteItem(item.id)"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
                  </td> -->
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
</section>
</div>
</template>
<script>
  import pagination from '../../../components/PaginationComponent.vue';
  // import DatePicker from 'v-calendar/lib/components/date-picker.umd';
  import moment from 'moment'
	export default{
		name: "List",
    components: {
      pagination,
      // DatePicker
    },
    data(){
      return{
        pagination: {
            'current_page': 1
          },
          form: new Form({
                category_id:'',
                unit_id:'',
                name:'',
                price:'',
                quantity:1,
            }),
              state: {
                isSending: false
            },
            search:'',
            category_idSearch:0,
            // date: new Date(),
        }
    },
		mounted(){
      this.fetchPosts();
		},
		computed:{
			getAllItem(){
        this.$Progress.start()
				var avar = this.$store.getters.getItem;
        if(avar.length==2)
          this.pagination = avar[1];
        this.$Progress.finish()
        return avar[0];
			},
        getAllCategory(){
            return this.$store.getters.getCategorySelect
        },
        getAllUnit(){
            return this.$store.getters.getUnitSelect
        }
		},
		methods:{
      fetchPosts() {
        this.$store.dispatch("allItem",[this.pagination.current_page, 0, 0]);
        this.$store.dispatch("allCategorySelect")
        this.$store.dispatch("allUnitSelect")
      },
      productImage(img){
        // console.log(this);
        if(img){
          return "image/item/"+img;
        }
        else{
          return "image/logo.png";
        }
      },
    //   deleteItem(id){
    //     var that = this;
    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: "You won't be able to revert this!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes, delete it!',
    //         cancelButtonText: 'No, cancel!',
    //         buttonsStyling: true
    //     }).then(function (isConfirm) {
    //         if(isConfirm.value === true) {
    //             axios.delete('/home/item/'+id)
    //             .then((response)=>{
    //                 Toast.fire({
    //                   icon: 'success',
    //                   title: 'Item Deleted successfully'
    //               })
    //             that.$store.dispatch("allItem",[0,0]);
    //             })
    //             .catch((response)=>{
    //                 Toast.fire({
    //                   icon: 'error',
    //                   title: 'Something went wrong'
    //               })
    //             })
    //         }
    //         else{
    //             Toast.fire({
    //               icon: 'error',
    //               title: 'Item not Deleted'
    //           })
    //         }
    //     })
    // },
    // addNewItem(){
    //       this.state.isSending = true;
    //       this.form.post('/home/item')
    //       .then((response)=>{
    //           Toast.fire({
    //               icon: 'success',
    //               title: 'Item Added successfully'
    //           })
    //           this.state.isSending = false;
    //       })
    //       .catch(()=>{
    //           this.state.isSending = false;
    //       })
    //       this.fetchPosts();
    //       this.resetForm(); //clear form automatically after successful request
    //   },
      customerStatus(id){
        return {
            'table-danger':!id,
            'table-default': id
        }
      },
      userShow(clkid, show){
        axios.get('/home/item/status/'+clkid+'/'+show)
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
    pagechange(){
      this.$store.dispatch("allItem", [this.pagination.current_page,this.search,this.category_idSearch]);
    },
    searchStock(){
      this.pagechange();
    },
    categoryChange(){
      this.pagechange();
    },
    dateChange(){
      this.pagechange();
    }
		},

      
	}
</script>

<style scoped>
</style>