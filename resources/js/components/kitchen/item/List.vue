<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <p class="text-danger m-0">Menu</p>
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
                  <div class="col-3">
                    <select class="form-control w-100" v-model="category_idSearch"  @change="categoryChange">  
                      <option value="0">Select Category</option> 
                      <option :value="category.id" v-for="category in getAllCategory">{{category.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-3">
                    <input type="text" class="form-control w-100" @keyup="searchStock" v-model="search" placeholder="Search by name">
                  </div>
                  <div class="form-group col-3">
                    <button @click.prevent="salesReportExport()" class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button>
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-9">
                    <div class="table-responsive">
                      <table class="table table-sm table-bordered table-hover">
                        <thead class="thead-dark">                  
                          <tr>
                            <th>SN</th>
                            <th>Category</th>
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
                            <td class="text-left" v-if="item.is_active == '0'">
                              <a href="javascript:void(0)" @click.prevent="userShow(item.id, item.is_active)" title="Make Active">
                                <i class="nav-icon fas fa-times-circle"></i>
                              </a> 
                              {{item.name}} 
                            </td>
                            <td class="text-left" v-else>
                              <a href="javascript:void(0)" @click.prevent="userShow(item.id, item.is_active)" title="Make InActive"><i class="nav-icon fas fa-check-circle"></i></a> {{item.name}}
                            </td>
                            <td class="text-left">Rs: {{item.price}}</td>
                            <td>{{item.quantity}}</td>
                            <td>{{item.unit.name}}</td>
                            <td v-if="item.item_type_id == '1'"> Ready Made </td>
                            <td v-else-if="item.item_type_id == '2'"> Kitchen </td>
                            <td v-else>Bar</td>
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
              </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addNewLabel">Add New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form @submit.prevent="addNewCategory()">
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="nameID">Name</label>
                        <input type="text" class="form-control" id="nameID" placeholder="Add New Name" v-model="form_add.name" name="name" :class="{ 'is-invalid': form_add.errors.has('name') }">
                        <has-error :form="form_add" field="name"></has-error>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" :disabled="state.isSendingO">{{state.isSendingO ? "Loading..." : "Add Category"}}</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- Modal ends -->
            <!-- Modal -->
            <div class="modal fade" id="addNewUnit" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addNewLabel">Add New Uniy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form @submit.prevent="addNewUnit()">
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="nameID">Name</label>
                        <input type="text" class="form-control" id="nameID" placeholder="Add New Unit" v-model="form_unit.name" name="name" :class="{ 'is-invalid': form_add.errors.has('name') }">
                        <has-error :form="form_add" field="name"></has-error>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" :disabled="state.isSendingU">{{state.isSendingU ? "Loading..." : "Add Unit"}}</button>
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
              unit_id:'',
              name:'',
              price:'',
              quantity:1,
              item_type_id: 1,
          }),
          form_add:new Form({
              name:'',
              type_id:2,
          }),
          form_unit:new Form({
              name:'',
          }),
            state: {
              isSending: false,
              isSendingO: false,
              isSendingU: false,
          },
            search:'',
            category_idSearch:0,
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
          // console.log(this.form.category_id);
            return this.$store.getters.getCategorySelect
        },
        getAllUnit(){
            return this.$store.getters.getUnitSelect
        }
		},
		methods:{
      fetchPosts() {
        this.$store.dispatch("allItem",[this.pagination.current_page, this.search, this.category_idSearch]);
        this.$store.dispatch("allCategorySelect")
        this.$store.dispatch("allUnitSelect")
      },
      openModalWindow(){
        // this.form.reset();
        $('#addNew').modal('show');
      },
      openModalWindowUnit(){
        // this.form.reset();
        $('#addNewUnit').modal('show');
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
                axios.delete('/kitchen/item/'+id)
                .then((response)=>{
                    Toast.fire({
                      icon: 'success',
                      title: 'Item Deleted successfully'
                  })
                that.$store.dispatch("allItem",[0,0]);
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
      var that = this;
          this.state.isSending = true;
          this.form.post('/kitchen/item')
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
          that.fetchPosts();
          that.resetForm(); //clear form automatically after successful request
      },
      addNewCategory(){
        var that = this;
          this.state.isSendingO = true;
          this.form_add.post('/kitchen/category')
          .then((response)=>{
            that.$store.dispatch("allCategorySelect")
            that.form.category_id = response.data.id;
            // console.log(response)
            Toast.fire({
                icon: 'success',
                title: 'Category Added successfully'
            })
        })
          .catch(()=>{
              this.state.isSendingO = false;
          })
          // this.$store.dispatch("allCategorySelect")
          this.$Progress.finish()
          $('#addNew').modal('hide');
      },
      addNewUnit(){
        var that = this;
          this.state.isSendingU = true;
          this.form_unit.post('/kitchen/unit')
          .then((response)=>{
            that.$store.dispatch("allUnitSelect")
            that.form.unit_id = response.data.id;
            // console.log(response)
            Toast.fire({
                icon: 'success',
                title: 'Unit Added successfully'
            })
        })
          .catch(()=>{
              this.state.isSendingU = false;
          })
          // this.$store.dispatch("allUnitSelect")
          this.$Progress.finish()
          $('#addNewUnit').modal('hide');
      },
      customerStatus(id){
        return {
            'table-danger':!id,
            'table-default': id
        }
      },
      userShow(clkid, show){
        axios.get('/kitchen/item/status/'+clkid+'/'+show)
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
      this.$store.dispatch("allItem", [0,this.search,this.category_idSearch]);
    },
    searchStock(){
      this.pagechange();
    },
    categoryChange(){
      this.pagechange();
    },
      salesReportExport(){
        location.href = '/kitchen/item/export?search='+this.search+'&category_id='+this.category_idSearch;
      }
		},

      
	}
</script>

<style scoped>
</style>