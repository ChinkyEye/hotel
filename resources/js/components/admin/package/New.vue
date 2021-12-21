<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Package</h1>
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
                    <router-link to="/package">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addNewPackage()">
                    <div class="card-body">
                      <div class="form-group">
                        <label for="nameID">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nameID" placeholder="Add New Name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="rate">Rate <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="rate" placeholder="Add New Rate" v-model="form.rate" name="rate" :class="{ 'is-invalid': form.errors.has('rate') }">
                        <has-error :form="form" field="rate"></has-error>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Package"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Name : {{form.name}}</h5>
                      <h5>Rate : {{form.rate}}</h5>
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
                rate:'',
            }),
              state: {
                isSending: false
            }
        }
    },
    mounted(){
        // this.$store.dispatch("allPackagetypeSelect")
    },
    computed:{
        getAllPackagetype(){
            // return this.$store.getters.getPackagetypeSelect
        }
    },
    methods:{
         addNewPackage(){
          this.state.isSending = true;
          this.form.post('/home/package')
          .then((response)=>{
            this.$router.push('/package')
            Toast.fire({
                icon: 'success',
                title: 'Package Added successfully'
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