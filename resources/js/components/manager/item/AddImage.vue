<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Add Image for Product from <span class="badge badge-info">{{name}}</span></h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Purcahse</li>
              <li class="breadcrumb-item active">Product</li>
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
          <div class="col-md-8"  >
            <div class="card card-primary" v-if="productimage == null">
              <div class="card-header">
                <router-link to="/product">
                  <i class="fas fa-arrow-left" title="Click to go back"></i>
                </router-link>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" enctype="multipart/form-data" @submit.prevent="addItemImage()">
                <div class="card-body">
                  <div class="form-group">
                    <input type="hidden" class="form-control" id="title" placeholder="Add New Title" v-model="form.id" name="id" :class="{ 'is-invalid': form.errors.has('title') }" autocomplete="off">
                    <!-- <input type="text" value="98" name="product_id"> -->
                    <label for="photo" class="d-block">Photo <code>*</code></label>
                    <input type="file" class="" @change="changePhoto($event)" id="photo" name="photo" :class="{ 'is-invalid': form.errors.has('photo') }">
                    <has-error :form="form" field="photo"></has-error>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Image"}}</button>
                </div>
              </form>
              
            </div>
          </div>
          <div class="col-md-4">
            <div class="box box-default position-relative">
              <div class="box-body">
                <div class="callout callout-success">
                  <img :src="imagePreview" class="img-thumbnail" v-show="showPreview"/>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="table-responsive " v-if="productimage != null" >
              <table class="table table-bordered table-hover table-sm m-0">
                <thead class="table-primary text-center">                  
                  <tr>
                    <th width="10">SN</th>
                    <th class="text-left">Image</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <tr v-for="(productimage,index) in getAllItemImage" :key="productimage.id">
                    <td>{{index+1}}</td>
                    <!-- <td>{{productimage.name}}</td> -->
                    <td><img :src="productImage(productimage.image_enc)" width="50" height="50"></td>
                    <!-- <td><img :src="productImage(productimage.image_enc)" width="50" height="50" v-else></td> -->
                    <!-- <td><img :src="userImage" v-if="userImage !== 'data:image/jpeg;base64,'"></td> -->
                    <td>
                      {{productimage.created_at | timeformat}} 
                      <span class="badge badge-warning text-danger">{{productimage.created_at  | formatDate}}</span>
                    </td>
                    <td>
                      <a href="" @click.prevent="deleteCitizenCharter(productimage.id)" class="btn btn-xs btn-outline-danger"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
                      
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
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
          photo: null,
          id: this.$route.params.itemid,
        }),
        state: {
          isSending: false
        },
        imagePreview: null,
        showPreview: false,
        productimage:'',
        name:''
      }
    },
    mounted(){
      this.$Progress.start()
      this.$Progress.finish()
      this.fetchPosts();
    },
    computed:{
      getAllItemImage(){
        var bvar = this.$store.getters.getItemImage;
        if(bvar.length == 0) return [];
        var avar = bvar[0].productimages;
        this.name = bvar[0].name; 
        this.productimage = bvar[0].productimage; 
        if(bvar.length==2)
          this.pagination = bvar[1];
        return avar;
      }
    },
    methods:{
      fetchPosts(){
        this.$Progress.start()
         this.$store.dispatch("allItemImage", [this.$route.params.itemid]);
        this.$Progress.finish()
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

      deleteCitizenCharter(id){
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
                axios.delete('/manager/item/destroyimage/'+id)
                .then((response)=>{
                    Toast.fire({
                      icon: 'success',
                      title: 'Image of Product Deleted successfully'
                  })
                     this.$store.dispatch("allItemImage", [this.$route.params.itemid]);
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
                  title: 'Image of Product not Deleted'
              })
            }
        })
      },
       addItemImage(){
        this.state.isSending = true;
        this.form.post('/manager/item/addimage/store',{
          headers: {
            'Content-Type': 'multipart/form-data',
          },
          transformRequest: [function (data,headers){
            return objectToFormData(data)
          }]
        })
        .then((response)=>{
          // this.$router.push('/about/background_slider')
          this.$router.push(`/item`)
          Toast.fire({
            icon: 'success',
            title: 'Image for Product Added successfully'
          })
        })
        .catch(()=>{
          this.state.isSending = false;
        })
        this.resetForm();
      },
      changePhoto(event){
        let file = event.target.files[0];
        // console.log(file);
        // 5 mb image
        if((file.size>5242880) || ((file.type != 'image/jpeg') && (file.type != 'image/png'))){
          this.state.isSending = true;
          Swal.fire({
           icon: 'error',
           title: 'Oops...',
           text: 'Something went wrong!',
           footer: '<a href>Why do I have this issue?</a>'
         })
       }else{
        let reader  = new FileReader();
        reader.addEventListener("load", function () {
            this.showPreview = true;
            this.imagePreview = reader.result;
            this.state.isSending = false;
        }.bind(this), false);
        if( file ){
          this.form.photo = file;
            if ( /\.(jpe?g|png)$/i.test( file.name ) ) {
                reader.readAsDataURL( file );
            }
          }
        }
      },
      resetForm() {
        this.form.reset();
      }
    
  }
}
</script>
<style scoped>
</style>
