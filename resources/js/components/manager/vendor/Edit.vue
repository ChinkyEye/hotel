<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Bill</h1>
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
                    <router-link to="/vendor">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addNewItem()">
                    <div class="card-body">
                      <div class="row">
                        
                        <div class="form-group mb-0 col-md-6">
                          <label for="bought_user_id">Bought User <span class="text-danger">*</span></label>
                          <select class="form-control" id="bought_user_id" v-model="form.bought_user_id" name="bought_user_id" :class="{ 'is-invalid': form.errors.has('bought_user_id') }"> 
                            <option disabled value="">Select one</option>
                            <option :value="buyer.id" v-for="buyer in getAllBuyer">{{buyer.user_code}} ({{buyer.name}})</option>
                          </select>
                          <has-error :form="form" field="bought_user_id"></has-error>
                        </div>
                        <div class="form-group mb-0 col-md-6">
                          <label for="bill_id">Billid <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="bill_id" placeholder="Add Quantity" v-model="form.bill_id" name="bill_id" :class="{ 'is-invalid': form.errors.has('bill_id') }" autocomplete="off">
                          <has-error :form="form" field="bill_id"></has-error>
                        </div>
                        
                        <div class="form-group mb-0 col-md-6">
                          <label for="date">Date <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="date" placeholder="Add Quantity" v-model="form.date" name="date" :class="{ 'is-invalid': form.errors.has('date') }" autocomplete="off">
                          <has-error :form="form" field="date"></has-error>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Update Bill"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h4>Name : {{form.name}}</h4>
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
                bill_id:'',
                bought_user_id:'',
                date:'',
            }),
              state: {
                isSending: false
            }
        }
    },
    mounted(){
        this.fetchPosts();
    },
    created(){
          axios.get(`/manager/vendor/${this.$route.params.vendorid}/edit`)
            .then((response)=>{
              this.form.fill(response.data.vendors)
            })
        },
    computed:{
        getAllCategory(){
            return this.$store.getters.getBuyerCategorySelect
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
        this.$store.dispatch("allBuyerCategorySelect")
        this.$store.dispatch("allUnitSelect")
        this.$store.dispatch("allBuyerSelect")
      },
         addNewItem(){
          this.state.isSending = true;
          this.form.put(`/manager/vendor/${this.$route.params.vendorid}`)
          .then((response)=>{
            this.$router.push('/vendor')
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