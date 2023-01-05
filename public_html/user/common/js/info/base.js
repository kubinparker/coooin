function setWysiwyg(elm) {

    ClassicEditor
    .create( document.querySelector( elm ), {
      'alignment': {
        options: [
          {name: 'left', className: 'text-left'},
          {name: 'right', className: 'text-right'},
          {name: 'center', className: 'text-center'}
        ]
      }
    })
    .catch( error => {
      // console.log(elm);
      console.error( error );
    } );


  return;
}