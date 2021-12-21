<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Counter</h1>
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
                    <router-link to="/counter">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addNewCounter()">
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-6 mb-0">
                          <label for="nameID">Name</label>
                          <input type="text" class="form-control" id="nameID" placeholder="Add New Name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                          <label for="email">Email</label>
                          <input type="text" class="form-control" id="email" placeholder="Add New Name" v-model="form.email" name="email" :class="{ 'is-invalid': form.errors.has('email') }">
                          <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                          <label for="address">Address</label>
                          <input type="text" class="form-control" id="address" placeholder="Add New Name" v-model="form.address" name="address" :class="{ 'is-invalid': form.errors.has('address') }">
                          <has-error :form="form" field="address"></has-error>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                          <label for="phone">Phone</label>
                          <input type="text" class="form-control" id="phone" placeholder="Add New Name" v-model="form.phone" name="phone" :class="{ 'is-invalid': form.errors.has('phone') }">
                          <has-error :form="form" field="phone"></has-error>
                        </div>
                      </div>
                      
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Update Counter"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h4>Name : {{form.name}}</h4>
                      <h4>Email : {{form.email}}</h4>
                      <h4>Address : {{form.address}}</h4>
                      <h4>Phone : {{form.phone}}</h4>
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
    export default {
        name: "New",
        data(){
            return {
              form: new Form({
                name:'',
                address:'',
                email:'',
                phone:'',
            }),
              state: {
                isSending: false
            }
        }
    },
    mounted(){
        // this.$store.dispatch("allManagertypeSelect")
    },
    created(){
          axios.get(`/manager/counter/${this.$route.params.counterid}/edit`)
            .then((response)=>{
              this.form.fill(response.data.counters)
            })
        },
    computed:{
        getAllManagertype(){
            return this.$store.getters.getManagertypeSelect
        }
    },
    methods:{
         addNewCounter(){
          this.state.isSending = true;
          this.form.put(`/manager/counter/${this.$route.params.counterid}`)
          .then((response)=>{
            this.$router.push('/counter')
            Toast.fire({
                icon: 'success',
                title: 'Manager Added successfully'
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