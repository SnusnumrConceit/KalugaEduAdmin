export default {
  methods: {
    download(name, path) {
      console.log(name, path);
      axios({
        url: '/admin/documents/download',
        method: 'POST',
        responseType: 'blob',
        data: {
          url: path
        }
      }).then((response) => {
        console.log(response);
        let blob = new Blob([response.data]);
        let link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = `${name}.doc`;
        link.click();
      }).catch((err) => {
        console.error(err);
      })
    }
  }
}