<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit User</h1>
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
                    <router-link :to="`/customer/${this.$route.params.userid}`">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addNewUser()">
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-6 pb-0">
                          <label for="user_type_id">Select User</label>
                          <select class="form-control" id="user_type_id" v-model="form.user_type_id" name="user_type_id" :class="{ 'is-invalid': form.errors.has('user_type_id') }"> 
                            <option disabled value="">Select one</option>
                            <option :value="category.id" v-for="category in getAllUsertype">{{category.name}}</option>
                          </select>
                          <has-error :form="form" field="user_type_id"></has-error>
                        </div>
                        <div class="form-group col-md-6 pb-0">
                          <label for="nameID">Name</label>
                          <input type="text" class="form-control" id="nameID" placeholder="Add New Name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group col-md-6 pb-0">
                          <label for="emailID">Email</label>
                          <input type="text" class="form-control" id="emailID" placeholder="Add New Email" v-model="form.email" name="email" :class="{ 'is-invalid': form.errors.has('email') }">
                          <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group col-md-6 pb-0">
                          <label for="phone">Phone</label>
                          <input type="text" class="form-control" id="phone" placeholder="Add New Phone" v-model="form.phone" name="phone" :class="{ 'is-invalid': form.errors.has('phone') }">
                          <has-error :form="form" field="phone"></has-error>
                        </div>
                        <div class="form-group col-md-6 pb-0">
                          <label for="address">Address</label>
                          <input type="text" class="form-control" id="address" placeholder="Add New Address" v-model="form.address" name="address" :class="{ 'is-invalid': form.errors.has('address') }">
                          <has-error :form="form" field="address"></has-error>
                        </div>
                        <div class="form-group col-md-6 pb-0">
                          <label for="date_of_join">Date Of Join</label>
                          <input type="text" class="form-control" id="date_of_join" placeholder="Add Date of Join" v-model="form.date_of_join" name="date_of_join" :class="{ 'is-invalid': form.errors.has('date_of_join') }">
                          <has-error :form="form" field="date_of_join"></has-error>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Update User"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Name : {{form.name}}</h5>
                      <h5>Email : {{form.email}}</h5>
                      <h5>Phone : {{form.phone}}</h5>
                      <h5>Address : {{form.address}}</h5>
                      <h5>Date Of Join : {{form.date_of_join}}</h5>
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
                email:'',
                user_type_id:'',
                phone:'',
                address:'',
                date_of_join:'',
            }),
              state: {
                isSending: false
            }
        }
    },
    mounted(){
        this.$store.dispatch("allUsertypeSelect")
    },
    created(){
          axios.get(`/home/customer/${this.$route.params.userid}/edit`)
            .then((response)=>{
              this.form.fill(response.data.users)
            })
        },
    computed:{
        getAllUsertype(){
            return this.$store.getters.getUsertypeSelect
        }
    },
    methods:{
         addNewUser(){
          this.state.isSending = true;
          this.form.put(`/home/customer/${this.$route.params.userid}`)
          .then((response)=>{
            this.$router.push(`/customer/${this.$route.params.userid}`)
            Toast.fire({
                icon: 'success',
                title: 'User Added successfully'
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