new Vue({
    el: '#app',
    data: {
      isMenuOpen: false
    },
    methods: {
      toggleMenu() {
        this.isMenuOpen = !this.isMenuOpen;
      },
      closeMenu() {
        this.isMenuOpen = false;
      }
    }
  });
  