export default {
  data() {
    return {
      dropzone_options: {
        url: '/admin/documents/upload',
        thumbnailWidth: 150,
        maxFilesize: 0.5,
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') },
        acceptedFiles: '.doc,.docx',
        addRemoveLinks: true,

        "dictDefaultMessage": '<i class="pe-7s-cloud-upload icons"></i>Переместите документ в область загрузки',

        "dictFallbackMessage":          'Ваш браузер не поддерживает данный компонент! Пожалуйста, обновите браузер на актуальный.',
        "dictResponseError":            'Ошибка!',
        "dictInvalidFileType":          'Неверный формат',
        "dictFileTooBig":               'Файл слишком большого размера',
        "dictCancelUpload":             'Отмена',
        "dictUploadCanceled":           'Отменить загрузку',
        "dictCancelUploadConfirmation": 'Вы действительно хотите отменить загрузку?',
        "dictRemoveFile":               'Удалить файл',
        "dictRemoveFileConfirmation":   'Вы действительно хотите удалить файл?'
      }
    }
  }
};