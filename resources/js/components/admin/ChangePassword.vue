<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add User</h1>
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
                    <router-link to="/#">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="changePassword()">
                    <div class="card-body">
                      <div class="form-group">
                        <label for="current_password">Old Password</label>
                        <input type="password" class="form-control" id="current_password" placeholder="Please enter old Password" v-model="form.current_password" name="current_password" :class="{ 'is-invalid': form.errors.has('current_password') }">
                        <has-error :form="form" field="current_password"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" placeholder="Please enter new Password" v-model="form.new_password" name="new_password" :class="{ 'is-invalid': form.errors.has('new_password') }">
                        <has-error :form="form" field="new_password"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input type="password" class="form-control" id="new_password_confirmation" placeholder="please enter same as new Password" v-model="form.new_password_confirmation" name="new_password_confirmation" :class="{ 'is-invalid': form.errors.has('new_password_confirmation') }">
                        <has-error :form="form" field="new_password_confirmation"></has-error>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add User"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
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
                current_password: '',
                new_password:'',
                new_password_confirmation:'',
              }),
              state: {
                    isSending: false
                }
            }
        },
        methods:{
            changePassword(){
                this.form.post('/Home/change-password/submit')
                    .then((response)=>{
                        location.reload();
                        toast.fire({
                            icon: 'success',
                            title: 'Password changed successfully'
                        })
                    })
                    .catch(()=>{

                    })
            }
        }
    }
</script>

<style scoped>

</style>