<template>
  <div class="text-center" data-app="true">
    <!-- <v-btn
      :disabled="dialog"
      :loading="dialog"
      class="white--text"
      color="purple darken-2"
      @click="dialog = true"
    >
      Start loading
    </v-btn> -->
    <v-dialog
      v-model="dialog"
      hide-overlay
      persistent
      width="300"
    >
      <v-card
        color="primary"
        dark
      >
        <v-card-text>
          Please stand by
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
  export default {
    data () {
      return {
        dialog: false,
      }
    },

    methods: {
      setState (val) {
        //if (!val) return
        this.dialog = val;
        //setTimeout(() => (this.dialog = false), 4000)
      },
    },
  }
</script>
<style scoped>
.theme--dark.v-card {
    background-color: #253a4c;
    color: #fff;
}
</style>