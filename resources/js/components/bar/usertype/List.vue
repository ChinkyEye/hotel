<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Customer Category</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
                            <li class="breadcrumb-item active">User</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
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
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addNew" @click="openModalWindow">Add New <i class="fas fa-user-plus fa-fw"></i></button>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" @keyup="searchService" v-model="search" placeholder="Search Customer Category">
                                    </div>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover">
                                        <thead class="table-primary">                  
                                            <tr>
                                                <th>SN</th>
                                                <th>Customer Category</th>
                                                <th>Discount</th>
                                                <th>Category</th>
                                                <th>Salary</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(post,index) in allusertypes" :key="post.id" :class="customerStatus(post.is_active)">
                                                <td>{{index+1}}</td>
                                                <td>{{post.name}}</td>
                                                <td>{{post.discount}} %</td>
                                                <td v-if="post.type_id == '1'">Buyer <a href="javascript:void(0)" title="Buyer"></a></td>
                                                <td v-else>Customer <a href="javascript:void(0)" title="Customer"></a></td>
                                                <td v-if="post.is_salary == '0'">No <a href="javascript:void(0)" @click.prevent="userSalary(post.id, post.is_salary)" title="Make Salary"><i class="nav-icon fas fa-times-circle"></i></a></td>
                                                <td v-else>Yes <a href="javascript:void(0)" @click.prevent="userSalary(post.id, post.is_salary)" title="Make No"><i class="nav-icon fas fa-check-circle"></i></a></td>
                                                <td v-if="post.is_active == '0'">Inactive <a href="javascript:void(0)" @click.prevent="userShow(post.id, post.is_active)" title="Make Active"><i class="nav-icon fas fa-times-circle"></i></a></td>
                                                <td v-else>Active <a href="javascript:void(0)" @click.prevent="userShow(post.id, post.is_active)" title="Make InActive"><i class="nav-icon fas fa-check-circle"></i></a></td>
                                                <td>{{post.created_at | timeformat}} <span class="text-success badge badge-warning">{{post.created_at  | formatDate}}</span></td>
                                                <td>
                                                    <a href="#" data-id="post.id" @click="editModalWindow(post)">
                                                        <i class="fa fa-edit blue"></i>
                                                    </a>
                                                    |
                                                    <a href="#" @click="deleteUser(post.id)">
                                                        <i class="fa fa-trash red"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div>
                                        <input type="hidden" v-model="page">
                                        <span>Current page: {{page+1}} [{{totalFiltered}} | {{totalData}}]</span>
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <li v-bind:class="{'page-item':true, 'disabled':(!(pageCount>0 && page>0))}"><a class="page-link" href="#" @click.prevent="page=page-1">Previous</a></li>
                                                <li v-for="n in pageCount" v-bind:class="{'page-item':true, 'disabled':((page+1)==n)}">
                                                    <a v-bind:class="{'page-link':true}" href="#" @click.prevent="page=(n-1)">{{n}}</a>
                                                </li>
                                                <li v-bind:class="{'page-item':true, 'disabled':(pageCount<=(page+1))}"><a class="page-link" href="#" @click.prevent="page=page+1">Next</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Add New User</h5>
                                            <h5 v-show="editMode" class="modal-title" id="addNewLabel">Update User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form @submit.prevent="editMode ? updateUser() : createUser()">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <input v-model="form.name" type="text" name="name"
                                                    placeholder="Name"
                                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                    <has-error :form="form" field="name"></has-error>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nameID">Type</label>
                                                    <input type="radio" id="one" value="1" v-model="form.type_id">
                                                    <label for="one">Buyer</label>
                                                    <input type="radio" id="two" value="2" v-model="form.type_id">
                                                    <label for="two">Customer</label>
                                                    <has-error :form="form" field="type_id"></has-error>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button v-show="editMode" type="submit" class="btn btn-primary">Update</button>
                                                <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                </div>
            </div>
        </section>
    </div>
</template>
<script>
    export default {
       name: "List",
       data(){
        return {
            editMode: false,
            users:{},
            search:'',
            page: 0,
            pageCount: 0,
            totalData:0,
            totalFiltered:0,
            form: new Form({
                id: '',
                name : '',
                type_id : '',
            })
        }
    },
    mounted(){
        this.$Progress.start()
        this.$store.dispatch('getAllUserType', [this.search,0])
        this.$Progress.finish()
    },
    computed:{
        allusertypes(){
            this.$Progress.start()
            var data = this.$store.getters.getUserType;
            this.pageCount = data.pages;
            this.totalData = data.totalData;
            this.totalFiltered = data.totalFiltered;
            this.$Progress.finish()
            return data.usertypes;
        }
    },
    methods:{
        editModalWindow(user){
            this.form.clear();
            this.editMode = true
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(user)
        },
        updateUser(){
            this.form.post('manager/user-type/'+this.form.id)
            .then(()=>{
                Toast.fire({
                    icon: 'success',
                    title: 'User updated successfully'
                })
                Fire.$emit('AfterCreatedUserLoadIt');
                $('#addNew').modal('hide');
            })
            .catch(()=>{
                console.log("Error.....")
            })
            this.$store.dispatch('getAllUserType', [this.search,0])
        },
        customerStatus(id){
            return {
                'table-danger':!id,
                'table-default': id
            }
        },
        openModalWindow(){
            this.editMode = false
            this.form.reset();
            $('#addNew').modal('show');
        },
        createUser(){
            this.$Progress.start()
            this.form.post('manager/user-type/store')
            .then(() => {
            Fire.$emit('AfterCreatedUserLoadIt'); //custom events
            Toast.fire({
                icon: 'success',
                title: 'User created successfully'
            })
            this.$Progress.finish()
            $('#addNew').modal('hide');
        })
            .catch(() => {
               console.log("Error......")
           })
            this.$store.dispatch('getAllUserType', [this.search,0])
        },
        deleteUser(id){
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
                    axios.get('/bar/user-type/delete/'+id)
                    .then((response)=>{
                        that.$store.dispatch("getAllUserType", [that.search,0])
                        Toast.fire({
                          icon: 'success',
                          title: 'Customer Category Deleted successfully'
                      })
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
                      title: 'Service not Deleted'
                  })
                }
            })
        },
        pagechange(){
            this.$store.dispatch("getAllUserType", [this.search,this.page]);
        },
        searchService(){
            this.page = 0;
            this.pagechange();
        },
        userShow(clkid, show){
            axios.get('/bar/user-type/status/'+clkid+'/'+show)
            .then(()=>{
                this.$store.dispatch("getAllUserType", [this.search,0]);
                Toast.fire({
                    icon: 'success',
                    title: 'Status changed successfully'
                })
            })
            .catch(()=>{
            })
        },
        userSalary(clkid, show){
            axios.get('/bar/user-type/salary/'+clkid+'/'+show)
            .then(()=>{
                this.$store.dispatch("getAllUserType", [this.search,0]);
                Toast.fire({
                    icon: 'success',
                    title: 'Status changed successfully'
                })
            })
            .catch(()=>{
            })
        }
    },
    watch:{
        page:function(val){
            this.pagechange();
        }
    }
}
</script>

<style scoped>

</style>