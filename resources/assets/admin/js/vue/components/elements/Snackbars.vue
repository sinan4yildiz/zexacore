<template>
  <div>
    Connection is gone. Please check your internet.
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
  name: "Snackbars",
  data() {

  },
  computed: {
    ...mapGetters('Snackbars', ['allSnackbars'])
  },
  created() {
  }
}
</script>