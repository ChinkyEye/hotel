<template>
<div>
  <div class="content-header">
  <div class="container-fluid">
    <div class="row">
     <div class="col-sm-6">
          <p class="text-danger m-0">All Customer List</p>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-6" v-for="(detail,index) in getAllUsertype">
        <!-- small box -->
        <div :class="detail.type_id == 1 ? 'small-box bg-info' : 'small-box bg-success'">
          <div class="inner">
            <h3>{{detail.get_count_user_count}}</h3>
            <p>{{detail.name}}</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <router-link :to="`/customer/${detail.id}`" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
        </div>
      </div>
    </div>
</div><!-- /.container-fluid -->
</section>
</div>
</template>
<script>
    export default {
        name: "New",
        data(){
            return {
              
        }
    },
    mounted(){
        this.$store.dispatch("allUsertypeSelect");
    },
    computed:{
        getAllUsertype(){
          var avar = this.$store.getters.getUsertypeSelect;
          // console.log(avar);
            return avar;
        }
    },
  }
</script>

<style scoped>
</style>