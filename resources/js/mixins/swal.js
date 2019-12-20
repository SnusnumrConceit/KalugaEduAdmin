export default {
  methods: {
    showErrorSwal(messages) {
      let res = '';

      switch (typeof messages) {
        case 'string':
          res = messages;
          break;

        case 'object':
          res = (Object.keys(messages).length) ?
              `<div class="m-t-20">
                        <ul class="p-l-20 p-r-20">
                            ${Object.values(messages).map(msg => `<li class="text-left">${msg}</li>`).join('')}
                        </ul>
                </div>`
              : '';
          break;
      }

      this.$swal({
        title: 'Ошибка!',
        type: 'error',
        html: res
      });
    }
  }
}