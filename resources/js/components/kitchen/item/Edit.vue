<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Item</h1>
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
            <div class="row">
              <div class="col-8">
                <div class="card card-primary">
                  <div class="card-header">
                    <router-link to="/item">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- <form role="form" enctype="multipart/form-data" @submit.prevent="addNewItem()">
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label for="category_id">Category <span class="text-danger">*</span></label>
                          <select class="form-control" id="category_id" v-model="form.category_id" name="category_id" :class="{ 'is-invalid': form.errors.has('category_id') }"> 
                            <option disabled value="">Select one</option>
                            <option :value="category.id" v-for="category in getAllCategory">{{category.name}}</option>
                          </select>
                          <has-error :form="form" field="category_id"></has-error>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="name">Item Name <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="name" placeholder="Add New Name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="off">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="price">Price <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="price" placeholder="Add Price" v-model="form.price" name="price" :class="{ 'is-invalid': form.errors.has('price') }" autocomplete="off">
                          <has-error :form="form" field="price"></has-error>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="quantity">Quantity <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="quantity" placeholder="Add Quantity" v-model="form.quantity" name="quantity" :class="{ 'is-invalid': form.errors.has('quantity') }" autocomplete="off">
                          <has-error :form="form" field="quantity"></has-error>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="unit_id">Unit <span class="text-danger">*</span></label>
                          <select class="form-control" id="unit_id" v-model="form.unit_id" name="unit_id" :class="{ 'is-invalid': form.errors.has('unit_id') }"> 
                            <option disabled value="">Select one</option>
                            <option :value="category.id" v-for="category in getAllUnit">{{category.name}}</option>
                          </select>
                          <has-error :form="form" field="unit_id"></has-error>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="nameID" class="mr-md-4 mr-sm-3">Type <span class="text-danger">*</span></label>
                          <input type="radio" id="one" value="1" v-model="form.item_type_id">
                          <label for="one" class="mr-md-4 mr-sm-3">Ready made</label>
                          <input type="radio" id="two" value="2" v-model="form.item_type_id">
                          <label for="two">Kitchen</label>
                          <has-error :form="form" field="item_type_id"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Update Item"}}</button>
                    </div>
                  </form> -->
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h4>Name : {{form.name}}</h4>
                      <h4>Price : {{form.prie}}</h4>
                      <h4>Quantity : {{form.quantity}}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets soritem)-->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
</template>

<script>
    export default {
        name: "New",
        data(){
            return {
              form: new Form({
                category_id:'',
                name:'',
                price:'',
                quantity:'',
                unit_id:'',
                item_type_id:''
            }),
              state: {
                isSending: false
            }
        }
    },
    mounted(){
      this.fetchPosts();
        // this.$store.dispatch("allItemtypeSelect")
    },
    created(){
          axios.get(`/kitchen/item/${this.$route.params.itemid}/edit`)
            .then((response)=>{
              this.form.fill(response.data.items)
            })
        },
    computed:{
        getAllItemtype(){
            return this.$store.getters.getItemtypeSelect
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
        this.$store.dispatch("allCategorySelect")
        this.$store.dispatch("allUnitSelect")

      },
         addNewItem(){
          this.state.isSending = true;
          this.form.put(`/kitchen/item/${this.$route.params.itemid}`)
          .then((response)=>{
            this.$router.push('/item')
            Toast.fire({
                icon: 'success',
                title: 'Item Added successfully'
            })
        })
          .catch(()=>{
              this.state.isSending = false;
          })
      }
    }
  }
</script>

<style scoped>

</style>